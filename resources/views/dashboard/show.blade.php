@extends('layouts.admin')
@section('title', 'Detail Laporan — PolLapor')
@section('page-title', 'Detail Laporan & Penugasan')

@section('content')
    <div style="display:grid; grid-template-columns:1fr 1fr; gap:24px;">
        {{-- Kolom Kiri: Info Laporan --}}
        <div>
            <div class="card mb-4">
                <div class="card-header">Informasi Laporan</div>
                <div class="card-body">
                    <table style="width:100%; font-size:14px;">
                        <tr><td style="padding:8px 0;font-weight:600;width:140px;">ID Laporan</td><td>{{ $laporan->formulir_id }}</td></tr>
                        <tr><td style="padding:8px 0;font-weight:600;">Nama Sarana</td><td>{{ $laporan->nama_sarana }}</td></tr>
                        <tr><td style="padding:8px 0;font-weight:600;">Kerusakan</td><td>{{ $laporan->keterangan_kerusakan }}</td></tr>
                        <tr><td style="padding:8px 0;font-weight:600;">Lokasi</td><td>{{ $laporan->lokasi?->nama_ruangan ?? '-' }}</td></tr>
                        <tr><td style="padding:8px 0;font-weight:600;">No. Inventaris</td><td>{{ $laporan->nomor_inventaris ?? '-' }}</td></tr>
                        <tr><td style="padding:8px 0;font-weight:600;">Pelapor</td><td>{{ $laporan->pelapor?->nama_lengkap ?? '-' }}</td></tr>
                        <tr><td style="padding:8px 0;font-weight:600;">Status</td><td><span class="badge badge-{{ $laporan->status_color }}">{{ $laporan->status_label }}</span></td></tr>
                        <tr><td style="padding:8px 0;font-weight:600;">Tanggal</td><td>{{ $laporan->created_at?->format('d/m/Y H:i') }}</td></tr>
                    </table>

                    @if($laporan->foto_kerusakan_url)
                    <div style="margin-top:16px;">
                        <strong style="font-size:13px;">Foto Kerusakan:</strong><br>
                        <img src="{{ $laporan->foto_kerusakan_url }}" alt="Foto Kerusakan"
                             style="max-width:100%; border-radius:8px; margin-top:8px; border:1px solid var(--border);">
                    </div>
                    @endif
                </div>
            </div>

            {{-- Tracking Timeline --}}
            <div class="card">
                <div class="card-header">Tracking Status</div>
                <div class="card-body">
                    @forelse($laporan->trackings as $track)
                    <div class="timeline-item">
                        <div class="timeline-dot" style="background: {{ match($track->jenis_event) {
                            'penanganan_selesai' => 'var(--success)',
                            'teknisi_ditugaskan' => 'var(--info)',
                            'penanganan_dimulai', 'teknisi_mulai_periksa' => 'var(--warning)',
                            'diteruskan_ke_pusat' => 'var(--danger)',
                            default => 'var(--info)',
                        } }};">●</div>
                        <div class="timeline-body">
                            <div class="meta">
                                {{ $track->created_at?->format('d/m/Y H:i') }}
                                · {{ $track->aktor?->nama_lengkap ?? 'System' }}
                            </div>
                            <div class="msg">{{ $track->pesan_narasi }}</div>
                        </div>
                    </div>
                    @empty
                    <p class="text-muted text-sm">Belum ada tracking.</p>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- Kolom Kanan: Penugasan --}}
        <div>
            @if($laporan->penanganan)
                {{-- Sudah ada penanganan --}}
                <div class="card">
                    <div class="card-header">Penanganan Aktif</div>
                    <div class="card-body">
                        <table style="width:100%; font-size:14px;">
                            <tr><td style="padding:8px 0;font-weight:600;width:140px;">Teknisi</td><td>{{ $laporan->penanganan->teknisi?->nama_lengkap ?? '-' }}</td></tr>
                            <tr><td style="padding:8px 0;font-weight:600;">Status</td><td><span class="badge badge-blue">{{ $laporan->penanganan->status_label }}</span></td></tr>
                            <tr><td style="padding:8px 0;font-weight:600;">Mulai</td><td>{{ $laporan->penanganan->tanggal_mulai?->format('d/m/Y H:i') ?? '-' }}</td></tr>
                            <tr><td style="padding:8px 0;font-weight:600;">Selesai</td><td>{{ $laporan->penanganan->tanggal_selesai?->format('d/m/Y H:i') ?? '-' }}</td></tr>
                            <tr><td style="padding:8px 0;font-weight:600;">Catatan</td><td>{{ $laporan->penanganan->catatan_progres ?? '-' }}</td></tr>
                            <tr><td style="padding:8px 0;font-weight:600;">Hasil</td><td>{{ $laporan->penanganan->deskripsi_hasil ?? '-' }}</td></tr>
                        </table>
                    </div>
                </div>
            @else
                {{-- Form assign teknisi --}}
                <div class="card">
                    <div class="card-header">Tugaskan Teknisi</div>
                    <div class="card-body">
                        @if($teknisiList->isEmpty())
                            <p class="text-muted">Tidak ada teknisi yang tersedia saat ini.</p>
                        @else
                            <form method="POST" action="{{ route('laporan.assign', $laporan->formulir_id) }}">
                                @csrf
                                <div class="form-group">
                                    <label>Pilih Teknisi</label>
                                    <select name="teknisi_id" class="form-control" required>
                                        <option value="">— Pilih Teknisi —</option>
                                        @foreach($teknisiList as $teknisi)
                                        <option value="{{ $teknisi->user_id }}">
                                            {{ $teknisi->nama_lengkap }}
                                            ({{ $teknisi->unit_jurusan ?? '-' }})
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-success">
                                    ✅ Tugaskan Teknisi
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>

    <div class="mt-4">
        <a href="{{ route('dashboard') }}" class="btn btn-outline">← Kembali ke Dashboard</a>
    </div>
@endsection
