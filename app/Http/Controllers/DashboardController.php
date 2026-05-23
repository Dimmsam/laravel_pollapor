<?php

namespace App\Http\Controllers;

use App\Models\FormulirLaporan;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * UC-05: Dashboard Laporan Masuk
     */
    public function index(Request $request)
    {
        $query = FormulirLaporan::with(['pelapor', 'lokasi', 'penanganan'])
            ->orderBy('created_at', 'desc');

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_sarana', 'ilike', "%{$search}%")
                  ->orWhere('keterangan_kerusakan', 'ilike', "%{$search}%")
                  ->orWhere('formulir_id', 'ilike', "%{$search}%");
            });
        }

        // Filter by tanggal
        if ($request->filled('dari_tanggal')) {
            $query->whereDate('created_at', '>=', $request->dari_tanggal);
        }
        if ($request->filled('sampai_tanggal')) {
            $query->whereDate('created_at', '<=', $request->sampai_tanggal);
        }

        $laporans = $query->paginate(15)->withQueryString();

        // Hitung statistik ringkas
        $stats = [
            'menunggu' => FormulirLaporan::menunggu()->count(),
            'ditugaskan' => FormulirLaporan::ditugaskan()->count(),
            'sedang_dikerjakan' => FormulirLaporan::sedangDikerjakan()->count(),
            'selesai' => FormulirLaporan::selesai()->count(),
            'diteruskan' => FormulirLaporan::diteruskanKePusat()->count(),
            'total' => FormulirLaporan::count(),
        ];

        return view('dashboard.index', compact('laporans', 'stats'));
    }
}
