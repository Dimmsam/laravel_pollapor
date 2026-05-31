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
            'status' => FormulirLaporan::STATUS_DITERUSKAN_KE_PUSAT,
            'is_locked' => true,
            'updated_at' => $now,
        ]);

        Tracking::create([
            'tracking_id' => (string) Str::uuid(),
            'formulir_id' => $formulirId,
            'aktor_id' => auth()->user()->user_id,
            'jenis_event' => Tracking::EVENT_DITERUSKAN_KE_PUSAT,
            'pesan_narasi' => 'Admin Jurusan meneruskan laporan ke pusat (UPT-PP). '
                . ($request->catatan ? 'Catatan: ' . $request->catatan : ''),
            'created_at' => $now,
        ]);

        // Jika ada penanganan, tandai teknisi kembali tersedia
        if ($laporan->penanganan) {
            Pengguna::where('user_id', $laporan->penanganan->teknisi_id)
                ->update(['is_busy' => false]);
        }

        return redirect()->route('eskalasi.index')
            ->with('success', 'Laporan berhasil diteruskan ke pusat.');
    }

    public function tolakEskalasi(Request $request, string $formulirId)
    {
        $request->validate([
            'alasan_tolak' => 'required|string|max:500',
        ]);

        $laporan = FormulirLaporan::with('penanganan')->findOrFail($formulirId);
        $now = now();

        $laporan->update([
            'status' => FormulirLaporan::STATUS_SEDANG_DIKERJAKAN,
            'updated_at' => $now,
        ]);

        if ($laporan->penanganan) {
            $laporan->penanganan->update([
                'status_penanganan' => Penanganan::STATUS_MULAI,
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

        return redirect()->route('eskalasi.index')
            ->with('success', 'Eskalasi ditolak. Laporan dikembalikan ke teknisi.');
    }
}
