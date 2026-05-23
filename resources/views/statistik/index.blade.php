@extends('layouts.admin')
@section('title', 'Statistik — PolLapor')
@section('page-title', 'Dashboard Statistik')

@section('content')
    {{-- Ringkasan --}}
    <div class="stats-grid">
        <div class="stat-card">
            <div class="value">{{ $ringkasan['total_laporan'] }}</div>
            <div class="label">Total Laporan</div>
        </div>
        <div class="stat-card">
            <div class="value" style="color:var(--success);">{{ $ringkasan['selesai'] }}</div>
            <div class="label">Selesai</div>
        </div>
        <div class="stat-card">
            <div class="value" style="color:var(--warning);">{{ $ringkasan['sedang_dikerjakan'] }}</div>
            <div class="label">Sedang Dikerjakan</div>
        </div>
        <div class="stat-card">
            <div class="value" style="color:var(--info);">{{ $ringkasan['ditugaskan'] }}</div>
            <div class="label">Ditugaskan</div>
        </div>
        <div class="stat-card">
            <div class="value" style="color:var(--danger);">{{ $ringkasan['diteruskan'] }}</div>
            <div class="label">Diteruskan ke Pusat</div>
        </div>
        <div class="stat-card">
            <div class="value" style="color:var(--accent);">{{ $ringkasan['avg_hari_selesai'] }}</div>
            <div class="label">Rata-rata Hari Selesai</div>
        </div>
    </div>

    <div style="display:grid; grid-template-columns:2fr 1fr; gap:24px;">
        {{-- Chart: Laporan per Bulan --}}
        <div class="card">
            <div class="card-header">📊 Laporan per Bulan (12 Bulan Terakhir)</div>
            <div class="card-body">
                <canvas id="chartPerBulan" height="200"></canvas>
            </div>
        </div>

        {{-- Chart: Rasio Status --}}
        <div class="card">
            <div class="card-header">🥧 Rasio Status</div>
            <div class="card-body">
                <canvas id="chartStatus" height="200"></canvas>
            </div>
        </div>
    </div>

    {{-- Tabel Rasio --}}
    <div class="card mt-4">
        <div class="card-header">Detail Rasio Status</div>
        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>Status</th>
                        <th>Jumlah</th>
                        <th>Persentase</th>
                    </tr>
                </thead>
                <tbody>
                    @php $total = max($rasioStatus->sum(), 1); @endphp
                    @foreach($rasioStatus as $status => $jumlah)
                    <tr>
                        <td>{{ ucfirst(str_replace('_', ' ', $status)) }}</td>
                        <td>{{ $jumlah }}</td>
                        <td>{{ round(($jumlah / $total) * 100, 1) }}%</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- Chart.js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4/dist/chart.umd.min.js"></script>
    <script>
        const ctxBar = document.getElementById('chartPerBulan').getContext('2d');
        new Chart(ctxBar, {
            type: 'bar',
            data: {
                labels: {!! json_encode($laporanPerBulan->pluck('bulan')) !!},
                datasets: [{
                    label: 'Jumlah Laporan',
                    data: {!! json_encode($laporanPerBulan->pluck('total')) !!},
                    backgroundColor: '#3949AB',
                    borderRadius: 6,
                }]
            },
            options: {
                responsive: true,
                plugins: { legend: { display: false } },
                scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } }
            }
        });

        const ctxPie = document.getElementById('chartStatus').getContext('2d');
        const statusColors = {
            'menunggu': '#F59E0B',
            'ditugaskan': '#3B82F6',
            'sedang_dikerjakan': '#F97316',
            'selesai': '#10B981',
            'diteruskan_ke_pusat': '#EF4444',
        };
        const labels = {!! json_encode($rasioStatus->keys()) !!};
        const values = {!! json_encode($rasioStatus->values()) !!};
        new Chart(ctxPie, {
            type: 'doughnut',
            data: {
                labels: labels.map(l => l.replace(/_/g, ' ')),
                datasets: [{
                    data: values,
                    backgroundColor: labels.map(l => statusColors[l] || '#9CA3AF'),
                }]
            },
            options: { responsive: true, plugins: { legend: { position: 'bottom' } } }
        });
    </script>
@endsection
