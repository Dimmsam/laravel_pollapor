<?php

namespace App\Http\Controllers;

use App\Models\FormulirLaporan;
use App\Models\Tracking;
use App\Models\Pengguna;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class KajurController extends Controller
{
    public function index()
    {
        $laporans = FormulirLaporan::with(['pelapor', 'lokasi', 'penanganan.teknisi'])
            ->menungguPersetujuanKajur()
            ->orderBy('updated_at', 'desc')
            ->paginate(15);

        return view('kajur.index', compact('laporans'));
    }

    public function show(string $formulirId)
    {
        $laporan = FormulirLaporan::with([
            'pelapor',
            'lokasi',
            'penanganan.teknisi',
            'trackings.aktor',
        ])->findOrFail($formulirId);

        return view('kajur.show', compact('laporan'));
    }

    public function setujuiEskalasi(Request $request, string $formulirId)
    {
        $laporan = FormulirLaporan::findOrFail($formulirId);
        $now = now();

        $laporan->update([
            'status' => FormulirLaporan::STATUS_DITERUSKAN_KE_PUSAT,
            'is_locked' => true,
            'updated_at' => $now,
        ]);

        Tracking::create([
            'tracking_id' => (string) Str::uuid(),
            'formulir_id' => $formulirId,
            'aktor_id' => auth()->user()->user_id,
            'jenis_event' => Tracking::EVENT_DITERUSKAN_KE_PUSAT,
            'pesan_narasi' => 'Kepala Jurusan menyetujui eskalasi ke UPT-PP. Laporan dikunci. '
                . ($request->catatan ? 'Catatan: ' . $request->catatan : ''),
            'created_at' => $now,
        ]);

        // Jika ada penanganan, tandai teknisi kembali tersedia dan kirim notifikasi
        if ($laporan->penanganan) {
            \Illuminate\Support\Facades\DB::table('notifikasi')->insert([
                'notifikasi_id' => (string) Str::uuid(),
                'penerima_id' => $laporan->penanganan->teknisi_id,
                'formulir_id' => $formulirId,
                'judul' => 'Eskalasi Disetujui: ' . $laporan->nama_sarana,
                'pesan' => 'Kepala Jurusan menyetujui eskalasi Anda dan meneruskannya ke UPT-PP.',
                'tipe' => 'success',
                'is_read' => false,
                'created_at' => $now,
            ]);

            Pengguna::where('user_id', $laporan->penanganan->teknisi_id)
                ->update(['is_busy' => false]);
        }

        return redirect()->route('kajur.index')
            ->with('success', 'Eskalasi disetujui dan diteruskan ke UPT-PP.');
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
            'is_locked' => false,
            'updated_at' => $now,
        ]);

        if ($laporan->penanganan) {
            $laporan->penanganan->update([
                'status_penanganan' => \App\Models\Penanganan::STATUS_DITOLAK_ESKALASI ?? 'ditolak_eskalasi',
                'updated_at' => $now,
            ]);
        }

        Tracking::create([
            'tracking_id' => (string) Str::uuid(),
            'formulir_id' => $formulirId,
            'aktor_id' => auth()->user()->user_id,
            'jenis_event' => 'eskalasi_ditolak',
            'pesan_narasi' => 'Kepala Jurusan menolak eskalasi. Alasan: ' . $request->alasan_tolak,
            'created_at' => $now,
        ]);

        if ($laporan->penanganan) {
            \Illuminate\Support\Facades\DB::table('notifikasi')->insert([
                'notifikasi_id' => (string) Str::uuid(),
                'penerima_id' => $laporan->penanganan->teknisi_id,
                'formulir_id' => $formulirId,
                'judul' => 'Eskalasi Ditolak Kajur: ' . $laporan->nama_sarana,
                'pesan' => 'Kepala Jurusan menolak eskalasi Anda. Alasan: ' . $request->alasan_tolak,
                'tipe' => 'warning',
                'is_read' => false,
                'created_at' => $now,
            ]);
        }

        return redirect()->route('kajur.index')
            ->with('success', 'Eskalasi ditolak. Laporan dikembalikan ke teknisi.');
    }
}
