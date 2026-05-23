@extends('layouts.admin')
@section('title', 'Eskalasi — PolLapor')
@section('page-title', 'Validasi Eskalasi')

@section('content')
    <div class="card">
        <div class="card-header">
            Laporan Diajukan Eskalasi oleh Teknisi
            <span class="text-sm text-muted">{{ $laporans->total() }} laporan</span>
        </div>
        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Sarana</th>
                        <th>Teknisi</th>
                        <th>Alasan Eskalasi</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($laporans as $laporan)
                    <tr>
                        <td class="text-sm text-muted">{{ substr($laporan->formulir_id, 0, 8) }}...</td>
                        <td><strong>{{ $laporan->nama_sarana }}</strong></td>
                        <td>{{ $laporan->penanganan?->teknisi?->nama_lengkap ?? '-' }}</td>
                        <td class="truncate">{{ $laporan->penanganan?->catatan_progres ?? '-' }}</td>
                        <td class="text-sm">{{ $laporan->updated_at?->format('d/m/Y H:i') }}</td>
                        <td>
                            <a href="{{ route('eskalasi.show', $laporan->formulir_id) }}" class="btn btn-warning btn-sm">
                                Review
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted" style="padding:40px;">
                            Tidak ada eskalasi yang menunggu.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if($laporans->hasPages())
    <div class="pagination">{{ $laporans->links('pagination::simple-default') }}</div>
    @endif
@endsection
