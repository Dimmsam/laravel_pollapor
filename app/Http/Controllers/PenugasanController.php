<?php

namespace App\Http\Controllers;

use App\Models\FormulirLaporan;
use App\Models\Penanganan;
use App\Models\Pengguna;
use App\Models\Tracking;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PenugasanController extends Controller
{
    public function show(string $formulirId)
    {
        $laporan = FormulirLaporan::with(['pelapor', 'lokasi', 'penanganan.teknisi', 'trackings'])
            ->findOrFail($formulirId);

        $teknisiList = Pengguna::teknisi()
            ->available()
            ->orderBy('nama_lengkap')
            ->get();

        return view('dashboard.detail_laporan', compact('laporan', 'teknisiList'));
    }

    public function assign(Request $request, string $formulirId)
    {
        $request->validate([
            'teknisi_id' => 'required|string|exists:pengguna,user_id',
        ]);

        return DB::transaction(function () use ($request, $formulirId) {
            $laporan = FormulirLaporan::lockForUpdate()->findOrFail($formulirId);

            if ($laporan->penanganan) {
                return back()->with('error', 'Laporan ini sudah memiliki penanganan.');
            }

            $now = now();

            Penanganan::create([
                'penanganan_id' => (string) Str::uuid(),
                'formulir_id' => $formulirId,
                'teknisi_id' => $request->teknisi_id,
                'status_penanganan' => Penanganan::STATUS_MULAI,
                'tanggal_mulai' => $now,
                'updated_at' => $now,
            ]);

            $laporan->update([
                'status' => FormulirLaporan::STATUS_DITUGASKAN,
                'updated_at' => $now,
            ]);

            Pengguna::where('user_id', $request->teknisi_id)
                ->update(['is_busy' => true]);

            Tracking::create([
                'tracking_id' => (string) Str::uuid(),
                'formulir_id' => $formulirId,
                'aktor_id' => auth()->user()->user_id,
                'jenis_event' => Tracking::EVENT_TEKNISI_DITUGASKAN,
                'pesan_narasi' => 'Admin Jurusan menugaskan teknisi untuk menangani laporan.',
                'created_at' => $now,
            ]);

            return redirect()->route('laporan.index')
                ->with('success', 'Teknisi berhasil ditugaskan.');
        });
    }

    public function tolakLaporan(Request $request, string $formulirId)
    {
        $request->validate(['alasan_tolak' => 'required|string|max:500']);

        $laporan = FormulirLaporan::findOrFail($formulirId);
        $now = now();

        $laporan->update([
            'status' => FormulirLaporan::STATUS_MENUNGGU,
            'is_locked' => true,
            'updated_at' => $now,
        ]);

        Tracking::create([
            'tracking_id' => (string) Str::uuid(),
            'formulir_id' => $formulirId,
            'aktor_id' => auth()->user()->user_id,
            'jenis_event' => Tracking::EVENT_LAPORAN_DITOLAK,
            'pesan_narasi' => 'Admin menolak laporan. Alasan: ' . $request->alasan_tolak,
            'created_at' => $now,
        ]);

        return redirect()->route('laporan.index')
            ->with('success', 'Laporan berhasil ditolak.');
    }

    public function ubahStatus(Request $request, string $formulirId)
    {
        $request->validate([
            'status' => 'required|string',
            'alasan' => 'required|string|max:500',
        ]);

        $laporan = FormulirLaporan::findOrFail($formulirId);
        $now = now();

        $laporan->update([
            'status' => $request->status,
            'updated_at' => $now,
        ]);

        // Catat sebagai event diterima admin (fallback) atau event lain sesuai kebutuhan
        Tracking::create([
            'tracking_id' => (string) Str::uuid(),
            'formulir_id' => $formulirId,
            'aktor_id' => auth()->user()->user_id,
            'jenis_event' => Tracking::EVENT_LAPORAN_DITERIMA,
            'pesan_narasi' => 'Admin mengubah status secara manual menjadi ' . $request->status . '. Alasan: ' . $request->alasan,
            'created_at' => $now,
        ]);

        return redirect()->back()->with('success', 'Status laporan berhasil diubah secara manual.');
    }
}
