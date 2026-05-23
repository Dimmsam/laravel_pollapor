@extends('layouts.admin')
@section('title', 'Performa Teknisi — PolLapor')
@section('page-title', 'Tabel Performa Teknisi')

@section('content')
    <div class="card">
        <div class="card-header">
            👷 Performa Teknisi
            <span class="text-sm text-muted">{{ $teknisiList->count() }} teknisi</span>
        </div>
        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>Nama Teknisi</th>
                        <th>Unit</th>
                        <th>Total Tugas</th>
                        <th>Selesai</th>
                        <th>Aktif</th>
                        <th>Rata-rata (hari)</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($teknisiList as $teknisi)
                    <tr>
                        <td><strong>{{ $teknisi->nama_lengkap }}</strong></td>
                        <td class="text-sm">{{ $teknisi->unit_jurusan ?? '-' }}</td>
                        <td class="text-center">{{ $teknisi->total_tugas }}</td>
                        <td class="text-center" style="color:var(--success);font-weight:600;">{{ $teknisi->tugas_selesai }}</td>
                        <td class="text-center" style="color:var(--info);font-weight:600;">{{ $teknisi->tugas_aktif }}</td>
                        <td class="text-center">
                            @if(isset($avgPerTeknisi[$teknisi->user_id]))
                                {{ round($avgPerTeknisi[$teknisi->user_id], 1) }} hari
                            @else
                                -
                            @endif
                        </td>
                        <td>
                            @if($teknisi->is_busy)
                                <span class="badge badge-red">Sibuk</span>
                            @else
                                <span class="badge badge-green">Available</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted" style="padding:40px;">
                            Tidak ada data teknisi.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
