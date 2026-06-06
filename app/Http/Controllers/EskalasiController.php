<?php

namespace App\Http\Controllers;

use App\Models\FormulirLaporan;
use App\Models\Penanganan;
use App\Models\Tracking;
use App\Models\Pengguna;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class EskalasiController extends Controller
{
    public function index()
    {
        // Laporan selesai dari teknisi yang perlu di-review admin
        $laporans = FormulirLaporan::with(['pelapor', 'lokasi', 'penanganan.teknisi'])
            ->whereHas('penanganan', function ($q) {
                $q->where('status_penanganan', Penanganan::STATUS_SELESAI);
            })
            ->where('status', FormulirLaporan::STATUS_SEDANG_DIKERJAKAN)
            ->orderBy('updated_at', 'desc')
            ->paginate(15);

        return view('eskalasi.index', compact('laporans'));
    }

    public function show(string $formulirId)
    {
        $laporan = FormulirLaporan::with([
            'pelapor',
            'lokasi',
            'penanganan.teknisi',
            'trackings.aktor',
        ])->findOrFail($formulirId);

        return view('eskalasi.show', compact('laporan'));
    }

    public function teruskanKeKajur(Request $request, string $formulirId)
    {
        $laporan = FormulirLaporan::findOrFail($formulirId);
        $now = now();

        $laporan->update([
            'status' => FormulirLaporan::STATUS_MENUNGGU_PERSETUJUAN_KAJUR,
            'is_locked' => true,
            'updated_at' => $now,
        ]);

        Tracking::create([
            'tracking_id' => (string) Str::uuid(),
            'formulir_id' => $formulirId,
            'aktor_id' => auth()->user()->user_id,
            'jenis_event' => Tracking::EVENT_DITERUSKAN_KE_PUSAT, // Bisa ganti event jika ada EVENT_MENUNGGU_KAJUR, tapi biarkan saja
            'pesan_narasi' => 'Admin Jurusan meneruskan laporan eskalasi ke Kepala Jurusan. '
                . ($request->catatan ? 'Catatan: ' . $request->catatan : ''),
            'created_at' => $now,
        ]);

        // Jika ada penanganan, tandai teknisi kembali tersedia dan beri notifikasi
        if ($laporan->penanganan) {
            \Illuminate\Support\Facades\DB::table('notifikasi')->insert([
                'notifikasi_id' => (string) Str::uuid(),
                'penerima_id' => $laporan->penanganan->teknisi_id,
                'formulir_id' => $formulirId,
                'judul' => 'Eskalasi Diteruskan ke Kajur: ' . $laporan->nama_sarana,
                'pesan' => 'Admin Jurusan telah meneruskan eskalasi Anda ke Kepala Jurusan.',
                'tipe' => 'info',
                'is_read' => false,
                'created_at' => $now,
            ]);

            Pengguna::where('user_id', $laporan->penanganan->teknisi_id)
                ->update(['is_busy' => false]);
        }

        return redirect()->route('eskalasi.index')
            ->with('success', 'Laporan eskalasi berhasil diteruskan ke Kepala Jurusan.');
    }

    public function tolakEskalasi(Request $request, string $formulirId)
    {
        $request->validate([
            'alasan_tolak' => 'required|string|max:500',
        ]);

        $laporan = FormulirLaporan::with('penanganan')->findOrFail($formulirId);
        $now = now();

        $laporan->update([
            'status' => 'ditolak_eskalasi', // set status_formulir ke ditolak_eskalasi
            'updated_at' => $now,
        ]);

        if ($laporan->penanganan) {
            $laporan->penanganan->update([
                'status_penanganan' => Penanganan::STATUS_DITOLAK_ESKALASI ?? 'ditolak_eskalasi',
                'updated_at' => $now,
            ]);
        }

        Tracking::create([
            'tracking_id' => (string) Str::uuid(),
            'formulir_id' => $formulirId,
            'aktor_id' => auth()->user()->user_id,
            'jenis_event' => Tracking::EVENT_PENANGANAN_DIMULAI,
            'pesan_narasi' => 'Admin Jurusan menolak eskalasi. Alasan: ' . $request->alasan_tolak,
            'created_at' => $now,
        ]);

        if ($laporan->penanganan) {
            \Illuminate\Support\Facades\DB::table('notifikasi')->insert([
                'notifikasi_id' => (string) Str::uuid(),
                'penerima_id' => $laporan->penanganan->teknisi_id,
                'formulir_id' => $formulirId,
                'judul' => 'Eskalasi Ditolak: ' . $laporan->nama_sarana,
                'pesan' => 'Admin Jurusan menolak eskalasi Anda. Alasan: ' . $request->alasan_tolak,
                'tipe' => 'warning',
                'is_read' => false,
                'created_at' => $now,
            ]);
        }

        return redirect()->route('eskalasi.index')
            ->with('success', 'Eskalasi ditolak. Laporan dikembalikan ke teknisi.');
    }
}
