<?php

namespace App\Http\Controllers;

use App\Models\FormulirLaporan;
use App\Models\Tracking;
use App\Models\Pengguna;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BeritaAcaraController extends Controller
{
    public function index()
    {
        $laporans = FormulirLaporan::with(['pelapor', 'lokasi', 'penanganan.teknisi'])
            ->siapBeritaAcara()
            ->orderBy('updated_at', 'desc')
            ->paginate(15);

        return view('berita-acara.index', compact('laporans'));
    }

    public function generate(string $formulirId)
    {
        $laporan = FormulirLaporan::with([
            'pelapor',
            'lokasi',
            'penanganan.teknisi',
            'trackings.aktor',
        ])->findOrFail($formulirId);

        $data = [
            'laporan' => $laporan,
            'nomor_ba' => 'BA/' . strtoupper(substr($formulirId, 0, 8)) . '/' . now()->format('m/Y'),
            'tanggal_cetak' => now()->translatedFormat('d F Y'),
        ];

        return view('berita-acara.pdf', $data);
    }

    public function kunciLaporan(Request $request, string $formulirId)
    {
        $laporan = FormulirLaporan::findOrFail($formulirId);

        if ($laporan->is_locked) {
            return back()->with('error', 'Laporan sudah dikunci sebelumnya.');
        }

        $now = now();

        $laporan->update([
            'is_locked' => true,
            'updated_at' => $now,
        ]);

        Tracking::create([
            'tracking_id' => (string) Str::uuid(),
            'formulir_id' => $formulirId,
            'aktor_id' => auth()->user()->user_id,
            'jenis_event' => Tracking::EVENT_PENANGANAN_SELESAI,
            'pesan_narasi' => 'Laporan dikunci oleh Admin. Tidak dapat diubah lagi.',
            'created_at' => $now,
        ]);

        // Jika ada penanganan, tandai teknisi kembali tersedia
        if ($laporan->penanganan) {
            Pengguna::where('user_id', $laporan->penanganan->teknisi_id)
                ->update(['is_busy' => false]);
        }

        return redirect()->route('berita-acara.index')
            ->with('success', 'Laporan berhasil dikunci.');
    }
}
