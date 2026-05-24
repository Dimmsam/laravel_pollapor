@extends('layouts.admin')
@section('title', 'Dashboard — PolLapor')

@section('content')

{{-- Page Header --}}
<div class="flex items-start justify-between mb-6">
    <div>
        <h1 class="text-xl font-bold text-gray-900 tracking-tight">Dashboard</h1>
        <p class="text-sm text-gray-500 mt-0.5">Monitoring laporan fasilitas kampus secara real-time</p>
    </div>
    <span class="text-xs font-medium text-blue-600 bg-blue-50 border border-blue-200 px-3 py-1.5 rounded-full whitespace-nowrap mt-1">
        {{ now()->translatedFormat('d F Y') }}
    </span>
</div>

{{-- ── Stat Cards ────────────────────────────────────────────────────── --}}
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">

    {{-- Total --}}
    <div class="bg-white rounded-xl border border-gray-200 p-5 relative overflow-hidden hover:shadow-md transition-shadow">
        <div class="flex items-start justify-between mb-3">
            <div class="w-10 h-10 bg-blue-50 rounded-lg flex items-center justify-center">
                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            </div>
            <span class="text-xs font-semibold text-green-600 bg-green-50 px-2 py-0.5 rounded-full">Total</span>
        </div>
        <div class="text-3xl font-bold text-gray-900 tracking-tight">{{ $stats['total'] }}</div>
        <div class="text-xs font-medium text-gray-400 mt-1">Total Laporan</div>
    </div>

    {{-- Ditinjau (menunggu + ditugaskan) --}}
    <div class="bg-white rounded-xl border border-gray-200 p-5 relative overflow-hidden hover:shadow-md transition-shadow">
        <div class="flex items-start justify-between mb-3">
            <div class="w-10 h-10 bg-amber-50 rounded-lg flex items-center justify-center">
                <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
            </div>
            @if($stats['menunggu'] > 0)
            <span class="w-2 h-2 rounded-full bg-amber-400 animate-pulse mt-1"></span>
            @endif
        </div>
        <div class="text-3xl font-bold text-amber-600 tracking-tight">{{ $stats['menunggu'] + $stats['ditugaskan'] }}</div>
        <div class="text-xs font-medium text-gray-400 mt-1">Ditinjau</div>
    </div>

    {{-- Dalam Penanganan --}}
    <div class="bg-white rounded-xl border border-gray-200 p-5 relative overflow-hidden hover:shadow-md transition-shadow">
        <div class="flex items-start justify-between mb-3">
            <div class="w-10 h-10 bg-blue-50 rounded-lg flex items-center justify-center">
                <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            </div>
        </div>
        <div class="text-3xl font-bold text-blue-600 tracking-tight">{{ $stats['sedang_dikerjakan'] }}</div>
        <div class="text-xs font-medium text-gray-400 mt-1">Dalam Penanganan</div>
    </div>

    {{-- Selesai --}}
    <div class="bg-white rounded-xl border border-gray-200 p-5 relative overflow-hidden hover:shadow-md transition-shadow">
        <div class="flex items-start justify-between mb-3">
            <div class="w-10 h-10 bg-green-50 rounded-lg flex items-center justify-center">
                <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
        </div>
        <div class="text-3xl font-bold text-green-600 tracking-tight">{{ $stats['selesai'] }}</div>
        <div class="text-xs font-medium text-gray-400 mt-1">Selesai</div>
    </div>

</div>

{{-- ── Charts + Teknisi Aktif Row ───────────────────────────────────── --}}
<div class="grid grid-cols-1 lg:grid-cols-3 gap-5 mb-5">

    {{-- Statistik Mingguan --}}
    <div class="bg-white border border-gray-200 rounded-xl overflow-hidden lg:col-span-1">
        <div class="flex items-center justify-between px-5 py-3.5 border-b border-gray-100">
            <span class="text-sm font-semibold text-gray-800">Statistik Mingguan</span>
        </div>
        <div class="px-5 py-4">
            @php $maxVal = $statistikMingguan->max('count') ?: 1; @endphp
            <div class="flex items-end gap-2 h-28">
                @foreach($statistikMingguan as $i => $day)
                @php
                    $height = $day['count'] > 0 ? max(8, round(($day['count'] / $maxVal) * 100)) : 4;
                    $isToday = $i === 6;
                @endphp
                <div class="flex-1 flex flex-col items-center gap-1.5">
                    <span class="text-xs text-gray-400 font-medium">{{ $day['count'] > 0 ? $day['count'] : '' }}</span>
                    <div class="w-full rounded-t-md transition-all {{ $isToday ? 'bg-blue-600' : 'bg-blue-100' }}"
                         style="height: {{ $height }}%"></div>
                    <span class="text-xs {{ $isToday ? 'text-blue-600 font-bold' : 'text-gray-400' }}">{{ $day['label'] }}</span>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Distribusi Status --}}
    <div class="bg-white border border-gray-200 rounded-xl overflow-hidden lg:col-span-1">
        <div class="flex items-center justify-between px-5 py-3.5 border-b border-gray-100">
            <span class="text-sm font-semibold text-gray-800">Distribusi Status</span>
        </div>
        <div class="px-5 py-4 flex flex-col justify-center gap-3">
            @php
                $distribusi = [
                    ['label' => 'Selesai',           'value' => $stats['selesai'],          'color' => 'bg-green-500'],
                    ['label' => 'Ditinjau',           'value' => $stats['menunggu'] + $stats['ditugaskan'], 'color' => 'bg-amber-400'],
                    ['label' => 'Dalam Penanganan',   'value' => $stats['sedang_dikerjakan'],'color' => 'bg-blue-500'],
                    ['label' => 'Diteruskan ke Pusat','value' => $stats['diteruskan'],       'color' => 'bg-red-400'],
                ];
                $total = $stats['total'] ?: 1;
            @endphp

            {{-- Donut visual sederhana via progress bars --}}
            <div class="relative flex items-center justify-center mb-2">
                <div class="w-24 h-24 rounded-full border-8 border-gray-100 flex items-center justify-center">
                    <div class="text-center">
                        <div class="text-xl font-bold text-gray-800">{{ $stats['total'] }}</div>
                        <div class="text-xs text-gray-400">Total</div>
                    </div>
                </div>
            </div>

            @foreach($distribusi as $item)
            <div class="flex items-center gap-3">
                <span class="w-2.5 h-2.5 rounded-full {{ $item['color'] }} flex-shrink-0"></span>
                <span class="text-xs text-gray-600 flex-1">{{ $item['label'] }}</span>
                <span class="text-xs font-bold text-gray-800">{{ $item['value'] }}</span>
            </div>
            @endforeach
        </div>
    </div>

    {{-- Teknisi Aktif --}}
    <div class="bg-white border border-gray-200 rounded-xl overflow-hidden lg:col-span-1">
        <div class="flex items-center justify-between px-5 py-3.5 border-b border-gray-100">
            <span class="text-sm font-semibold text-gray-800">Teknisi Aktif</span>
            <span class="text-xs font-semibold text-green-600 bg-green-50 border border-green-100 px-2 py-0.5 rounded-full">
                {{ $teknisiAktif->count() }} Online
            </span>
        </div>
        <div class="divide-y divide-gray-50">
            @forelse($teknisiAktif as $teknisi)
            <div class="flex items-center gap-3 px-5 py-3.5">
                <div class="w-9 h-9 rounded-full bg-blue-100 text-blue-700 flex items-center justify-center text-sm font-bold flex-shrink-0">
                    {{ substr($teknisi->nama_lengkap, 0, 1) }}
                </div>
                <div class="flex-1 min-w-0">
                    <div class="text-sm font-semibold text-gray-800 truncate">{{ $teknisi->nama_lengkap }}</div>
                    <div class="text-xs text-gray-400 truncate">{{ $teknisi->unit_jurusan ?? 'Teknisi' }}</div>
                </div>
                <span class="w-2 h-2 rounded-full bg-green-400 flex-shrink-0"></span>
            </div>
            @empty
            <div class="px-5 py-8 text-center text-sm text-gray-400">Tidak ada teknisi tersedia.</div>
            @endforelse
        </div>
        <div class="px-5 py-3 border-t border-gray-100">
            <a href="{{ route('statistik.performa') }}"
               class="w-full h-8 flex items-center justify-center text-xs font-semibold text-gray-600 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                Semua Teknisi
            </a>
        </div>
    </div>

</div>

{{-- ── Laporan Terbaru ──────────────────────────────────────────────── --}}
<div class="bg-white border border-gray-200 rounded-xl overflow-hidden">

    <div class="flex items-center justify-between px-5 py-3.5 border-b border-gray-100">
        <span class="text-sm font-semibold text-gray-800">Laporan Terbaru</span>
        <a href="{{ route('laporan.index') }}" class="text-xs font-semibold text-blue-600 hover:text-blue-700 transition-colors">
            Lihat Semua →
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-100">
                    <th class="text-left text-xs font-semibold text-gray-400 uppercase tracking-wide px-5 py-3">Nomor Surat</th>
                    <th class="text-left text-xs font-semibold text-gray-400 uppercase tracking-wide px-5 py-3">Nama Sarana</th>
                    <th class="text-left text-xs font-semibold text-gray-400 uppercase tracking-wide px-5 py-3">Prioritas</th>
                    <th class="text-left text-xs font-semibold text-gray-400 uppercase tracking-wide px-5 py-3">Status</th>
                    <th class="text-left text-xs font-semibold text-gray-400 uppercase tracking-wide px-5 py-3">Teknisi</th>
                    <th class="text-left text-xs font-semibold text-gray-400 uppercase tracking-wide px-5 py-3">Tanggal</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($laporanTerbaru as $laporan)
                <tr class="hover:bg-gray-50 transition-colors cursor-pointer"
                    onclick="window.location='{{ route('laporan.show', $laporan->formulir_id) }}'">

                    {{-- Nomor Surat --}}
                    <td class="px-5 py-3.5">
                        <span class="font-mono text-xs text-gray-500 font-semibold">
                            {{ $laporan->nomor_surat ?? substr($laporan->formulir_id, 0, 8).'…' }}
                        </span>
                    </td>

                    {{-- Nama Sarana + Lokasi --}}
                    <td class="px-5 py-3.5">
                        <div class="font-semibold text-sm text-gray-800">{{ $laporan->nama_sarana }}</div>
                        <div class="text-xs text-gray-400 mt-0.5">{{ $laporan->lokasi?->nama_ruangan ?? '—' }}</div>
                    </td>

                    {{-- Prioritas --}}
                    <td class="px-5 py-3.5">
                        @if($laporan->prioritas)
                        @php
                            $prioBadge = match(strtolower($laporan->prioritas)) {
                                'tinggi' => 'bg-red-100 text-red-700',
                                'sedang' => 'bg-amber-100 text-amber-700',
                                'rendah' => 'bg-gray-100 text-gray-500',
                                default  => 'bg-gray-100 text-gray-500',
                            };
                        @endphp
                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-bold uppercase tracking-wide {{ $prioBadge }}">
                            {{ $laporan->prioritas }}
                        </span>
                        @else
                            <span class="text-xs text-gray-300">—</span>
                        @endif
                    </td>

                    {{-- Status --}}
                    <td class="px-5 py-3.5">
                        @php
                            $badgeClass = match($laporan->status) {
                                'menunggu'            => 'bg-slate-100 text-slate-600',
                                'ditugaskan'          => 'bg-blue-50 text-blue-700',
                                'sedang_dikerjakan'   => 'bg-amber-50 text-amber-700',
                                'selesai'             => 'bg-green-50 text-green-700',
                                'diteruskan_ke_pusat' => 'bg-red-50 text-red-700',
                                default               => 'bg-gray-100 text-gray-500',
                            };
                            $dotClass = match($laporan->status) {
                                'menunggu'            => 'bg-slate-400',
                                'ditugaskan'          => 'bg-blue-500',
                                'sedang_dikerjakan'   => 'bg-amber-400',
                                'selesai'             => 'bg-green-500',
                                'diteruskan_ke_pusat' => 'bg-red-500',
                                default               => 'bg-gray-400',
                            };
                        @endphp
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold {{ $badgeClass }}">
                            <span class="w-1.5 h-1.5 rounded-full {{ $dotClass }}"></span>
                            {{ $laporan->status_label }}
                        </span>
                    </td>

                    {{-- Teknisi --}}
                    <td class="px-5 py-3.5">
                        @if($laporan->penanganan?->teknisi)
                            <span class="text-sm text-gray-600">{{ $laporan->penanganan->teknisi->nama_lengkap }}</span>
                        @else
                            <span class="text-xs text-gray-300">Belum ditugaskan</span>
                        @endif
                    </td>

                    {{-- Tanggal --}}
                    <td class="px-5 py-3.5">
                        <span class="text-xs text-gray-500">{{ $laporan->created_at?->format('d M Y') }}</span>
                    </td>

                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-5 py-12 text-center">
                        <div class="flex flex-col items-center gap-2 text-gray-300">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            <span class="text-sm font-medium">Belum ada laporan.</span>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>

@endsection