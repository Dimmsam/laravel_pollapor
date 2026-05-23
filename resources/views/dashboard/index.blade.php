@extends('layouts.admin')
@section('title', 'Dashboard Laporan — PolLapor')
@section('page-title', 'Dashboard Laporan Masuk')

@section('content')
    {{-- Stats --}}
    <div class="stats-grid">
        <div class="stat-card">
            <div class="value">{{ $stats['menunggu'] }}</div>
            <div class="label">Menunggu</div>
        </div>
        <div class="stat-card">
            <div class="value" style="color: var(--info);">{{ $stats['ditugaskan'] }}</div>
            <div class="label">Ditugaskan</div>
        </div>
        <div class="stat-card">
            <div class="value" style="color: var(--warning);">{{ $stats['sedang_dikerjakan'] }}</div>
            <div class="label">Sedang Dikerjakan</div>
        </div>
        <div class="stat-card">
            <div class="value" style="color: var(--success);">{{ $stats['selesai'] }}</div>
            <div class="label">Selesai</div>
        </div>
        <div class="stat-card">
            <div class="value" style="color: var(--danger);">{{ $stats['diteruskan'] }}</div>
            <div class="label">Diteruskan ke Pusat</div>
        </div>
        <div class="stat-card">
            <div class="value" style="color: var(--text-muted);">{{ $stats['total'] }}</div>
            <div class="label">Total</div>
        </div>
    </div>

    {{-- Filter --}}
    <form method="GET" action="{{ route('dashboard') }}">
        <div class="filter-bar">
            <input type="text" name="search" class="form-control" placeholder="🔍 Cari sarana/deskripsi..."
                   value="{{ request('search') }}">
            <select name="status" class="form-control">
                <option value="">Semua Status</option>
                <option value="menunggu" {{ request('status') == 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                <option value="ditugaskan" {{ request('status') == 'ditugaskan' ? 'selected' : '' }}>Ditugaskan</option>
                <option value="sedang_dikerjakan" {{ request('status') == 'sedang_dikerjakan' ? 'selected' : '' }}>Sedang Dikerjakan</option>
                <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                <option value="diteruskan_ke_pusat" {{ request('status') == 'diteruskan_ke_pusat' ? 'selected' : '' }}>Diteruskan ke Pusat</option>
            </select>
            <input type="date" name="dari_tanggal" class="form-control" value="{{ request('dari_tanggal') }}">
            <input type="date" name="sampai_tanggal" class="form-control" value="{{ request('sampai_tanggal') }}">
            <button type="submit" class="btn btn-primary btn-sm">Filter</button>
            <a href="{{ route('dashboard') }}" class="btn btn-outline btn-sm">Reset</a>
        </div>
    </form>

    {{-- Table --}}
    <div class="card">
        <div class="card-header">
            Daftar Laporan
            <span class="text-sm text-muted">{{ $laporans->total() }} laporan</span>
        </div>
        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Sarana</th>
                        <th>Pelapor</th>
                        <th>Lokasi</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($laporans as $laporan)
                    <tr>
                        <td class="text-sm text-muted">{{ substr($laporan->formulir_id, 0, 8) }}...</td>
                        <td>
                            <strong>{{ $laporan->nama_sarana }}</strong>
                            <div class="text-sm text-muted truncate">{{ $laporan->keterangan_kerusakan }}</div>
                        </td>
                        <td>{{ $laporan->pelapor?->nama_lengkap ?? '-' }}</td>
                        <td>{{ $laporan->lokasi?->nama_ruangan ?? '-' }}</td>
                        <td>
                            <span class="badge badge-{{ $laporan->status_color }}">
                                {{ $laporan->status_label }}
                            </span>
                        </td>
                        <td class="text-sm">{{ $laporan->created_at?->format('d/m/Y H:i') }}</td>
                        <td>
                            <a href="{{ route('laporan.show', $laporan->formulir_id) }}" class="btn btn-primary btn-sm">
                                Detail
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted" style="padding:40px;">
                            Tidak ada laporan ditemukan.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Pagination --}}
    @if($laporans->hasPages())
    <div class="pagination">
        {{ $laporans->links('pagination::simple-default') }}
    </div>
    @endif
@endsection
