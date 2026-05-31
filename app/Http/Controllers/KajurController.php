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
            ->diteruskanKePusat()
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

        // Jika ada penanganan, tandai teknisi kembali tersedia
        if ($laporan->penanganan) {
            Pengguna::where('user_id', $laporan->penanganan->teknisi_id)
                ->update(['is_busy' => false]);
        }

        return redirect()->route('kajur.index')
            ->with('success', 'Eskalasi disetujui dan diteruskan ke UPT-PP.');
    }
}
