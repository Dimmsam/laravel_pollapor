<?php

namespace App\Http\Controllers;

use App\Models\FormulirLaporan;
use App\Models\Penanganan;
use App\Models\Pengguna;
use App\Models\Tracking;
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

        return view('dashboard.show', compact('laporan', 'teknisiList'));
    }

    public function assign(Request $request, string $formulirId)
    {
        $request->validate([
            'teknisi_id' => 'required|string|exists:pengguna,user_id',
        ]);

        $laporan = FormulirLaporan::findOrFail($formulirId);

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

        return redirect()->route('dashboard')
            ->with('success', 'Teknisi berhasil ditugaskan.');
    }
}
