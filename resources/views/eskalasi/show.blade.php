@extends('layouts.admin')
@section('title', 'Review Eskalasi — PolLapor')
@section('page-title', 'Review Eskalasi')

@section('content')
    <div style="display:grid; grid-template-columns:1fr 1fr; gap:24px;">
        {{-- Info Laporan --}}
        <div>
            <div class="card mb-4">
                <div class="card-header">Detail Laporan</div>
                <div class="card-body">
                    <table style="width:100%; font-size:14px;">
                        <tr><td style="padding:8px 0;font-weight:600;width:140px;">Sarana</td><td>{{ $laporan->nama_sarana }}</td></tr>
                        <tr><td style="padding:8px 0;font-weight:600;">Kerusakan</td><td>{{ $laporan->keterangan_kerusakan }}</td></tr>
                        <tr><td style="padding:8px 0;font-weight:600;">Lokasi</td><td>{{ $laporan->lokasi?->nama_ruangan ?? '-' }}</td></tr>
                        <tr><td style="padding:8px 0;font-weight:600;">Pelapor</td><td>{{ $laporan->pelapor?->nama_lengkap ?? '-' }}</td></tr>
                        <tr><td style="padding:8px 0;font-weight:600;">Teknisi</td><td>{{ $laporan->penanganan?->teknisi?->nama_lengkap ?? '-' }}</td></tr>
                    </table>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header">Catatan Eskalasi dari Teknisi</div>
                <div class="card-body">
                    <p>{{ $laporan->penanganan?->catatan_progres ?? 'Tidak ada catatan.' }}</p>
                    @if($laporan->penanganan?->foto_progres_url)
                    <div style="margin-top:12px; display:flex; gap:8px; flex-wrap:wrap;">
                        @foreach($laporan->penanganan->foto_progres_url as $foto)
                        <img src="{{ $foto }}" alt="Foto" style="width:120px; height:90px; object-fit:cover; border-radius:8px; border:1px solid var(--border);">
                        @endforeach
                    </div>
                    @endif
                </div>
            </div>

            {{-- Tracking --}}
            <div class="card">
                <div class="card-header">Tracking</div>
                <div class="card-body">
                    @forelse($laporan->trackings as $track)
                    <div class="timeline-item">
                        <div class="timeline-dot" style="background: var(--info);">●</div>
                        <div class="timeline-body">
                            <div class="meta">{{ $track->created_at?->format('d/m/Y H:i') }} · {{ $track->aktor?->nama_lengkap ?? 'System' }}</div>
                            <div class="msg">{{ $track->pesan_narasi }}</div>
                        </div>
                    </div>
                    @empty
                    <p class="text-muted text-sm">Belum ada tracking.</p>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- Aksi --}}
        <div>
            <div class="card mb-4">
                <div class="card-header" style="background:#FEF3C7;">⚠️ Teruskan ke Kajur</div>
                <div class="card-body">
                    <p class="text-sm text-muted mb-4">Teruskan eskalasi ini ke Kepala Jurusan untuk persetujuan.</p>
                    <form method="POST" action="{{ route('eskalasi.teruskan', $laporan->formulir_id) }}">
                        @csrf
                        <div class="form-group">
                            <label>Catatan (opsional)</label>
                            <textarea name="catatan" class="form-control" rows="3" placeholder="Tambahkan catatan untuk Kajur..."></textarea>
                        </div>
                        <button type="submit" class="btn btn-warning">⬆️ Teruskan ke Kajur</button>
                    </form>
                </div>
            </div>

            <div class="card">
                <div class="card-header" style="background:#FEE2E2;">❌ Tolak Eskalasi</div>
                <div class="card-body">
                    <p class="text-sm text-muted mb-4">Tolak eskalasi dan kembalikan ke teknisi untuk ditangani ulang.</p>
                    <form method="POST" action="{{ route('eskalasi.tolak', $laporan->formulir_id) }}">
                        @csrf
                        <div class="form-group">
                            <label>Alasan Penolakan *</label>
                            <textarea name="alasan_tolak" class="form-control" rows="3" placeholder="Jelaskan alasan penolakan..." required></textarea>
                        </div>
                        <button type="submit" class="btn btn-danger">❌ Tolak Eskalasi</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-4">
        <a href="{{ route('eskalasi.index') }}" class="btn btn-outline">← Kembali</a>
    </div>
@endsection
