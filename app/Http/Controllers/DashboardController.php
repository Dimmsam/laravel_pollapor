<?php

namespace App\Http\Controllers;

use App\Models\FormulirLaporan;
use App\Models\Pengguna;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // ─── Statistik ringkas ─────────────────────────────────────────
        $stats = [
            'total'            => FormulirLaporan::count(),
            'menunggu'         => FormulirLaporan::menunggu()->count(),
            'ditugaskan'       => FormulirLaporan::ditugaskan()->count(),
            'sedang_dikerjakan'=> FormulirLaporan::sedangDikerjakan()->count(),
            'selesai'          => FormulirLaporan::selesai()->count(),
            'diteruskan'       => FormulirLaporan::diteruskanKePusat()->count(),
        ];

        // ─── Laporan terbaru (5) ───────────────────────────────────────
        $laporanTerbaru = FormulirLaporan::with(['pelapor', 'lokasi', 'penanganan.teknisi'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // ─── Statistik mingguan (7 hari terakhir) ─────────────────────
        $statistikMingguan = collect(range(6, 0))->map(function ($daysAgo) {
            $date = now()->subDays($daysAgo);
            return [
                'label' => $date->translatedFormat('D'),
                'count' => FormulirLaporan::whereDate('created_at', $date->toDateString())->count(),
            ];
        });

        // ─── Teknisi aktif ────────────────────────────────────────────
        $teknisiAktif = Pengguna::where('role', 'teknisi')
            ->limit(3)
            ->get();

        return view('dashboard.dashboard_utama', compact(
            'stats',
            'laporanTerbaru',
            'statistikMingguan',
            'teknisiAktif',
        ));
    }

    /**
     * Halaman daftar laporan (terpisah dari dashboard)
     */
    public function laporan(Request $request)
    {
        $query = FormulirLaporan::with(['pelapor', 'lokasi', 'penanganan'])
            ->orderBy('created_at', 'desc');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_sarana', 'ilike', "%{$search}%")
                  ->orWhere('keterangan_kerusakan', 'ilike', "%{$search}%")
                  ->orWhere('formulir_id', 'ilike', "%{$search}%");
            });
        }

        if ($request->filled('dari_tanggal')) {
            $query->whereDate('created_at', '>=', $request->dari_tanggal);
        }
        if ($request->filled('sampai_tanggal')) {
            $query->whereDate('created_at', '<=', $request->sampai_tanggal);
        }

        $laporans = $query->paginate(15)->withQueryString();

        $stats = [
            'menunggu'          => FormulirLaporan::menunggu()->count(),
            'ditugaskan'        => FormulirLaporan::ditugaskan()->count(),
            'sedang_dikerjakan' => FormulirLaporan::sedangDikerjakan()->count(),
            'selesai'           => FormulirLaporan::selesai()->count(),
            'diteruskan'        => FormulirLaporan::diteruskanKePusat()->count(),
            'total'             => FormulirLaporan::count(),
        ];

        return view('dashboard.laporan_list', compact('laporans', 'stats'));
    }
}