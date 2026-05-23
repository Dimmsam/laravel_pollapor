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
        $laporanPerBulan = FormulirLaporan::select(
                DB::raw("to_char(created_at, 'YYYY-MM') as bulan"),
                DB::raw('count(*) as total')
            )
            ->where('created_at', '>=', now()->subMonths(12))
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get();

        $rasioStatus = FormulirLaporan::select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->get()
            ->pluck('total', 'status');

        $ringkasan = [
            'total_laporan' => FormulirLaporan::count(),
            'selesai' => FormulirLaporan::selesai()->count(),
            'sedang_dikerjakan' => FormulirLaporan::sedangDikerjakan()->count(),
            'menunggu' => FormulirLaporan::menunggu()->count(),
            'ditugaskan' => FormulirLaporan::ditugaskan()->count(),
            'diteruskan' => FormulirLaporan::diteruskanKePusat()->count(),
        ];

        $avgWaktu = Penanganan::whereNotNull('tanggal_selesai')
            ->whereNotNull('tanggal_mulai')
            ->select(DB::raw('AVG(EXTRACT(EPOCH FROM (tanggal_selesai - tanggal_mulai)) / 86400) as avg_hari'))
            ->value('avg_hari');

        $ringkasan['avg_hari_selesai'] = $avgWaktu ? round($avgWaktu, 1) : 0;

        return view('statistik.index', compact('laporanPerBulan', 'rasioStatus', 'ringkasan'));
    }

    public function performaTeknisi()
    {
        $teknisiList = Pengguna::teknisi()
            ->withCount([
                'penanganan as total_tugas',
                'penanganan as tugas_selesai' => function ($q) {
                    $q->where('status_penanganan', Penanganan::STATUS_SELESAI);
                },
                'penanganan as tugas_aktif' => function ($q) {
                    $q->where('status_penanganan', Penanganan::STATUS_MULAI);
                },
            ])
            ->orderBy('nama_lengkap')
            ->get();

        $avgPerTeknisi = Penanganan::whereNotNull('tanggal_selesai')
            ->whereNotNull('tanggal_mulai')
            ->where('status_penanganan', Penanganan::STATUS_SELESAI)
            ->select(
                'teknisi_id',
                DB::raw('AVG(EXTRACT(EPOCH FROM (tanggal_selesai - tanggal_mulai)) / 86400) as avg_hari')
            )
            ->groupBy('teknisi_id')
            ->pluck('avg_hari', 'teknisi_id');

        return view('statistik.performa', compact('teknisiList', 'avgPerTeknisi'));
    }
}
