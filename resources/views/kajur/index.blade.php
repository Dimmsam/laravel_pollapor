@extends('layouts.admin')
@section('title', 'Persetujuan Kajur — PolLapor')
@section('page-title', 'Persetujuan Eskalasi — Kajur')

@section('content')
    <div class="card">
        <div class="card-header">
            Antrean Eskalasi untuk Kajur
            <span class="text-sm text-muted">{{ $laporans->total() }} laporan</span>
        </div>
        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Sarana</th>
                        <th>Lokasi</th>
                        <th>Teknisi</th>
                        <th>Catatan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($laporans as $laporan)
                    <tr>
                        <td class="text-sm text-muted">{{ substr($laporan->formulir_id, 0, 8) }}...</td>
                        <td><strong>{{ $laporan->nama_sarana }}</strong></td>
                        <td>{{ $laporan->lokasi?->nama_ruangan ?? '-' }}</td>
                        <td>{{ $laporan->penanganan?->teknisi?->nama_lengkap ?? '-' }}</td>
                        <td class="truncate">{{ $laporan->penanganan?->catatan_progres ?? '-' }}</td>
                        <td>
                            <a href="{{ route('kajur.show', $laporan->formulir_id) }}" class="btn btn-primary btn-sm">
                                Review
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted" style="padding:40px;">
                            Tidak ada eskalasi menunggu persetujuan.
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
