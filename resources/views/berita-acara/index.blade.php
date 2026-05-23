@extends('layouts.admin')
@section('title', 'Berita Acara — PolLapor')
@section('page-title', 'Berita Acara & Arsip')

@section('content')
    {{-- Laporan Siap Berita Acara --}}
    <div class="card mb-4">
        <div class="card-header">
            📄 Laporan Siap Berita Acara
            <span class="text-sm text-muted">{{ $laporans->total() }} laporan</span>
        </div>
        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Sarana</th>
                        <th>Status</th>
                        <th>Dikunci</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($laporans as $laporan)
                    <tr>
                        <td class="text-sm text-muted">{{ substr($laporan->formulir_id, 0, 8) }}...</td>
                        <td><strong>{{ $laporan->nama_sarana }}</strong></td>
                        <td><span class="badge badge-{{ $laporan->status_color }}">{{ $laporan->status_label }}</span></td>
                        <td>
                            @if($laporan->is_locked)
                                <span class="badge badge-gray">🔒 Dikunci</span>
                            @else
                                <span class="badge badge-green">Terbuka</span>
                            @endif
                        </td>
                        <td class="text-sm">{{ $laporan->updated_at?->format('d/m/Y') }}</td>
                        <td style="display:flex;gap:6px;">
                            <a href="{{ route('berita-acara.generate', $laporan->formulir_id) }}" class="btn btn-primary btn-sm" target="_blank">
                                📄 Cetak
                            </a>
                            @if(!$laporan->is_locked)
                            <form method="POST" action="{{ route('berita-acara.kunci', $laporan->formulir_id) }}" style="display:inline;">
                                @csrf
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin kunci laporan ini?')">
                                    🔒 Kunci
                                </button>
                            </form>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted" style="padding:40px;">
                            Tidak ada laporan siap berita acara.
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
