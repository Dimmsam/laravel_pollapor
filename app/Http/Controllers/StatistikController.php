<?php

namespace App\Http\Controllers;

use App\Models\FormulirLaporan;
use App\Models\Penanganan;
use App\Models\Pengguna;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StatistikController extends Controller
{
    public function index()
    {
        // 1. Stats Ringkasan
        $ringkasan = [
            'total_laporan' => FormulirLaporan::count(),
            'ditinjau' => FormulirLaporan::menunggu()->count(),
            'dalam_penanganan' => FormulirLaporan::whereIn('status', [FormulirLaporan::STATUS_DITUGASKAN, FormulirLaporan::STATUS_SEDANG_DIKERJAKAN])->count(),
            'eskalasi' => FormulirLaporan::diteruskanKePusat()->count(),
            'selesai' => FormulirLaporan::selesai()->count(),
        ];

        // 2. Live Monitoring Laporan
        $liveMonitoring = FormulirLaporan::with(['penanganan.teknisi', 'lokasi'])
            ->orderBy('updated_at', 'desc')
            ->take(8)
            ->get();

        // Tambahkan atribut progress dummy berdasarkan status
        foreach ($liveMonitoring as $laporan) {
            $laporan->progress_percent = match ($laporan->status) {
                FormulirLaporan::STATUS_MENUNGGU => 10,
                FormulirLaporan::STATUS_DITUGASKAN => 30,
                FormulirLaporan::STATUS_SEDANG_DIKERJAKAN => 60,
                FormulirLaporan::STATUS_DITERUSKAN_KE_PUSAT => 45,
                FormulirLaporan::STATUS_SELESAI => 100,
                default => 0,
            };
        }

        // 3. Teknisi Aktif
        $teknisiAktif = Pengguna::teknisi()
            ->orderBy('is_busy', 'desc')
            ->orderBy('nama_lengkap', 'asc')
            ->get();

        // 4. Prioritas Tinggi
        $prioritasTinggi = FormulirLaporan::with('lokasi')
            ->whereIn('prioritas', ['urgent', 'sangat_urgent'])
            ->where('status', '!=', FormulirLaporan::STATUS_SELESAI)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('statistik.index', compact('ringkasan', 'liveMonitoring', 'teknisiAktif', 'prioritasTinggi'));
    }

    public function performaTeknisi()
    {
        $teknisiList = Pengguna::teknisi()
            ->with(['penanganan' => function($q) {
                $q->where('status_penanganan', Penanganan::STATUS_MULAI)->with('formulirLaporan.lokasi');
            }])
            ->withCount([
                'penanganan as total_tugas',
                'penanganan as tugas_selesai' => function ($q) {
                    $q->where('status_penanganan', Penanganan::STATUS_SELESAI);
                },
                'penanganan as tugas_aktif' => function ($q) {
                    $q->where('status_penanganan', Penanganan::STATUS_MULAI);
                },
            ])
            ->orderBy('is_busy', 'desc')
            ->orderBy('nama_lengkap')
            ->get();

        $ringkasanTeknisi = [
            'total' => $teknisiList->count(),
            'ready' => $teknisiList->where('is_busy', false)->count(),
            'busy' => $teknisiList->where('is_busy', true)->count(),
            'offline' => 2, // Dummy untuk mockup
        ];

        // Hitung distribusi keahlian dari CSV string di DB
        $keahlianDist = [];
        foreach ($teknisiList as $t) {
            if ($t->keahlian) {
                $tags = array_map('trim', explode(',', $t->keahlian));
                foreach ($tags as $tag) {
                    if (!empty($tag)) {
                        $keahlianDist[$tag] = ($keahlianDist[$tag] ?? 0) + 1;
                    }
                }
            }
        }
        arsort($keahlianDist);

        $aktivitasTerbaru = Penanganan::with(['teknisi', 'formulirLaporan.lokasi'])
            ->orderBy('updated_at', 'desc')
            ->take(4)
            ->get();

        return view('statistik.performa', compact('teknisiList', 'ringkasanTeknisi', 'keahlianDist', 'aktivitasTerbaru'));
    }
}
