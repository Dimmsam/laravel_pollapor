<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Berita Acara — {{ $nomor_ba }}</title>
    <style>
        @page { margin: 2cm; size: A4; }
        body { font-family: 'Times New Roman', serif; font-size: 13pt; line-height: 1.6; color: #111; }
        .header { text-align: center; border-bottom: 3px double #1A237E; padding-bottom: 16px; margin-bottom: 24px; }
        .header h2 { color: #1A237E; margin: 0; font-size: 16pt; }
        .header h1 { margin: 4px 0; font-size: 18pt; }
        .header .nomor { font-size: 12pt; color: #555; }
        table.info { width: 100%; margin: 16px 0; border-collapse: collapse; }
        table.info td { padding: 4px 8px; vertical-align: top; }
        table.info td:first-child { font-weight: bold; width: 180px; }
        .section-title { font-weight: bold; font-size: 14pt; margin: 24px 0 8px; color: #1A237E; border-bottom: 1px solid #ccc; padding-bottom: 4px; }
        .timeline { margin: 0; padding: 0; list-style: none; }
        .timeline li { padding: 6px 0; border-bottom: 1px dotted #ddd; font-size: 12pt; }
        .timeline li .time { font-size: 10pt; color: #888; }
        .ttd-grid { display: flex; justify-content: space-between; margin-top: 48px; }
        .ttd-box { text-align: center; width: 45%; }
        .ttd-box .line { border-top: 1px solid #333; margin-top: 60px; padding-top: 4px; }
        .footer { margin-top: 40px; font-size: 10pt; color: #888; text-align: center; }

        @media print {
            body { -webkit-print-color-adjust: exact; }
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>POLITEKNIK NEGERI JEMBER</h2>
        <h1>BERITA ACARA</h1>
        <h2>PENANGANAN KERUSAKAN SARANA/PRASARANA</h2>
        <div class="nomor">Nomor: {{ $nomor_ba }}</div>
    </div>

    <p>Pada hari ini, <strong>{{ $tanggal_cetak }}</strong>, telah dilakukan penanganan kerusakan sarana/prasarana sebagai berikut:</p>

    <div class="section-title">I. Data Laporan</div>
    <table class="info">
        <tr><td>ID Formulir</td><td>: {{ $laporan->formulir_id }}</td></tr>
        <tr><td>Nama Sarana</td><td>: {{ $laporan->nama_sarana }}</td></tr>
        <tr><td>Keterangan Kerusakan</td><td>: {{ $laporan->keterangan_kerusakan }}</td></tr>
        <tr><td>Lokasi</td><td>: {{ $laporan->lokasi?->nama_ruangan ?? '-' }}</td></tr>
        <tr><td>Nomor Inventaris</td><td>: {{ $laporan->nomor_inventaris ?? '-' }}</td></tr>
        <tr><td>Pelapor</td><td>: {{ $laporan->pelapor?->nama_lengkap ?? '-' }}</td></tr>
        <tr><td>Tanggal Laporan</td><td>: {{ $laporan->created_at?->format('d/m/Y H:i') }}</td></tr>
        <tr><td>Status Akhir</td><td>: {{ $laporan->status_label }}</td></tr>
    </table>

    @if($laporan->penanganan)
    <div class="section-title">II. Data Penanganan</div>
    <table class="info">
        <tr><td>Teknisi</td><td>: {{ $laporan->penanganan->teknisi?->nama_lengkap ?? '-' }}</td></tr>
        <tr><td>Status Penanganan</td><td>: {{ $laporan->penanganan->status_label }}</td></tr>
        <tr><td>Tanggal Mulai</td><td>: {{ $laporan->penanganan->tanggal_mulai?->format('d/m/Y H:i') ?? '-' }}</td></tr>
        <tr><td>Tanggal Selesai</td><td>: {{ $laporan->penanganan->tanggal_selesai?->format('d/m/Y H:i') ?? '-' }}</td></tr>
        <tr><td>Catatan Progres</td><td>: {{ $laporan->penanganan->catatan_progres ?? '-' }}</td></tr>
        <tr><td>Deskripsi Hasil</td><td>: {{ $laporan->penanganan->deskripsi_hasil ?? '-' }}</td></tr>
    </table>
    @endif

    <div class="section-title">III. Riwayat Tracking</div>
    <ul class="timeline">
        @forelse($laporan->trackings as $track)
        <li>
            <span class="time">[{{ $track->created_at?->format('d/m/Y H:i') }}]</span>
            {{ $track->pesan_narasi }}
            <span class="time">— {{ $track->aktor?->nama_lengkap ?? 'System' }}</span>
        </li>
        @empty
        <li>Tidak ada data tracking.</li>
        @endforelse
    </ul>

    <p style="margin-top:24px;">Demikian berita acara ini dibuat untuk dipergunakan sebagaimana mestinya.</p>

    <div class="ttd-grid">
        <div class="ttd-box">
            <div>Mengetahui,</div>
            <div>Kepala Jurusan</div>
            <div class="line">( ...................................... )</div>
        </div>
        <div class="ttd-box">
            <div>Jember, {{ $tanggal_cetak }}</div>
            <div>Admin Jurusan</div>
            <div class="line">( {{ auth()->user()->nama_lengkap }} )</div>
        </div>
    </div>

    <div class="footer">
        Dicetak pada {{ now()->format('d/m/Y H:i') }} — Dokumen ini dihasilkan secara otomatis oleh sistem PolLapor.
    </div>

    <script>window.onload = function() { window.print(); }</script>
</body>
</html>
