@extends('layouts.admin')
@section('title', 'Monitoring Laporan — PolLapor')

@section('content')
    <!-- Topbar & Actions -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Monitoring Laporan</h1>
            <p class="text-sm text-gray-500 mt-1">Pantau progres penanganan laporan fasilitas kampus secara real-time</p>
        </div>
        <div class="flex items-center gap-3">
            <button class="flex items-center gap-2 px-4 py-2 border border-blue-600 text-blue-700 bg-white rounded-lg text-sm font-bold hover:bg-blue-50 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                Export Data
            </button>
            <button onclick="window.location.reload()" class="flex items-center gap-2 px-4 py-2 bg-blue-700 text-white rounded-lg text-sm font-bold hover:bg-blue-800 transition-colors shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                Refresh Monitoring
            </button>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-2 md:grid-cols-5 gap-4 mb-6">
        <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm relative overflow-hidden group">
            <div class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center text-blue-600 mb-4">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            </div>
            <div class="absolute top-4 right-4 bg-blue-50 text-blue-600 text-xs font-bold px-2 py-1 rounded-md">+12%</div>
            <div class="text-sm font-medium text-gray-500 mb-1">Total Laporan</div>
            <div class="text-3xl font-extrabold text-gray-900">{{ $ringkasan['total_laporan'] }}</div>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm">
            <div class="w-10 h-10 rounded-xl bg-orange-50 flex items-center justify-center text-orange-600 mb-4">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
            </div>
            <div class="text-sm font-medium text-gray-500 mb-1">Ditinjau</div>
            <div class="text-3xl font-extrabold text-orange-600">{{ $ringkasan['ditinjau'] }}</div>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm">
            <div class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center text-blue-600 mb-4">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
            </div>
            <div class="text-sm font-medium text-gray-500 mb-1">Dalam Penanganan</div>
            <div class="text-3xl font-extrabold text-blue-700">{{ $ringkasan['dalam_penanganan'] }}</div>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm">
            <div class="w-10 h-10 rounded-xl bg-red-50 flex items-center justify-center text-red-600 mb-4">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
            </div>
            <div class="text-sm font-medium text-gray-500 mb-1">Eskalasi ke Pusat</div>
            <div class="text-3xl font-extrabold text-red-600">{{ $ringkasan['eskalasi'] }}</div>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm">
            <div class="w-10 h-10 rounded-xl bg-green-50 flex items-center justify-center text-green-600 mb-4">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <div class="text-sm font-medium text-gray-500 mb-1">Selesai</div>
            <div class="text-3xl font-extrabold text-green-600">{{ $ringkasan['selesai'] }}</div>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Kolom Kiri: Live Monitoring (Span 2) -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden h-full">
                <div class="p-6 border-b border-gray-100 flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-blue-600 animate-pulse"></span>
                        <h2 class="text-lg font-bold text-gray-900">Live Monitoring</h2>
                    </div>
                    <a href="#" class="text-sm font-bold text-blue-600 hover:text-blue-700">Lihat Semua</a>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50 border-b border-gray-100 text-xs uppercase tracking-wider text-gray-500 font-bold">
                                <th class="p-4 pl-6">Nomor Surat</th>
                                <th class="p-4">Nama Sarana</th>
                                <th class="p-4">Teknisi</th>
                                <th class="p-4 w-40">Progress</th>
                                <th class="p-4 pr-6">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($liveMonitoring as $laporan)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="p-4 pl-6">
                                    <div class="text-sm font-bold text-gray-900">{{ substr($laporan->formulir_id, 0, 12) }}</div>
                                </td>
                                <td class="p-4">
                                    <div class="text-sm font-bold text-gray-900">{{ $laporan->nama_sarana }}</div>
                                    <div class="text-xs text-gray-500">{{ $laporan->lokasi?->nama_ruangan ?? '-' }}</div>
                                </td>
                                <td class="p-4">
                                    @if($laporan->penanganan && $laporan->penanganan->teknisi)
                                    <div class="flex items-center gap-2">
                                        <div class="w-7 h-7 rounded-full bg-blue-100 text-blue-700 flex items-center justify-center text-xs font-bold">
                                            {{ substr($laporan->penanganan->teknisi->nama_lengkap, 0, 2) }}
                                        </div>
                                        <div class="text-sm text-gray-700 font-medium">{{ $laporan->penanganan->teknisi->nama_lengkap }}</div>
                                    </div>
                                    @else
                                    <span class="text-sm text-gray-400">-</span>
                                    @endif
                                </td>
                                <td class="p-4">
                                    <div class="flex items-center gap-2">
                                        <div class="w-full bg-gray-200 rounded-full h-1.5">
                                            @php
                                                $barColor = match(true) {
                                                    $laporan->progress_percent >= 100 => 'bg-green-500',
                                                    $laporan->progress_percent >= 60 => 'bg-blue-600',
                                                    $laporan->progress_percent >= 40 => 'bg-red-500',
                                                    default => 'bg-orange-400',
                                                };
                                            @endphp
                                            <div class="{{ $barColor }} h-1.5 rounded-full" style="width: {{ $laporan->progress_percent }}%"></div>
                                        </div>
                                        <span class="text-xs font-bold text-gray-500 w-8">{{ $laporan->progress_percent }}%</span>
                                    </div>
                                </td>
                                <td class="p-4 pr-6">
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-extrabold uppercase tracking-widest border 
                                        @if($laporan->status == 'selesai') bg-green-50 text-green-700 border-green-200
                                        @elseif(in_array($laporan->status, ['ditugaskan', 'sedang_dikerjakan'])) bg-blue-50 text-blue-700 border-blue-200
                                        @elseif($laporan->status == 'diteruskan_ke_pusat') bg-red-50 text-red-700 border-red-200
                                        @else bg-orange-50 text-orange-700 border-orange-200
                                        @endif
                                    ">
                                        {{ $laporan->status_label }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="p-8 text-center text-gray-500">Tidak ada data live monitoring saat ini.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Kolom Kanan: Teknisi & Prioritas -->
        <div class="space-y-6">
            
            <!-- Teknisi Aktif -->
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-sm font-bold text-gray-900">Teknisi Aktif</h2>
                    <span class="text-xs text-gray-500">{{ $teknisiAktif->where('is_busy', true)->count() }} Online</span>
                </div>
                
                <div class="space-y-4">
                    @forelse($teknisiAktif as $teknisi)
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="relative">
                                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-gray-700 to-gray-900 flex items-center justify-center text-white font-bold">
                                    {{ substr($teknisi->nama_lengkap, 0, 1) }}
                                </div>
                                <span class="absolute bottom-0 right-0 w-2.5 h-2.5 rounded-full border-2 border-white {{ $teknisi->is_busy ? 'bg-orange-500' : 'bg-green-500' }}"></span>
                            </div>
                            <div>
                                <div class="text-sm font-bold text-gray-900">{{ $teknisi->nama_lengkap }}</div>
                                <div class="text-xs text-gray-500">{{ $teknisi->unit_jurusan ?? 'Maintenance' }}</div>
                            </div>
                        </div>
                        <span class="px-2 py-1 rounded text-[10px] font-bold uppercase {{ $teknisi->is_busy ? 'bg-blue-50 text-blue-600' : 'bg-green-50 text-green-600' }}">
                            {{ $teknisi->is_busy ? 'Sibuk' : 'Tersedia' }}
                        </span>
                    </div>
                    @empty
                    <p class="text-sm text-gray-500 text-center">Tidak ada data teknisi.</p>
                    @endforelse
                </div>
            </div>

            <!-- Prioritas Tinggi -->
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <h2 class="text-sm font-bold text-gray-900 mb-4">Prioritas Tinggi</h2>
                
                <div class="space-y-4">
                    @forelse($prioritasTinggi as $laporan)
                    <div class="p-3 border border-red-100 rounded-xl bg-red-50/50 border-l-4 border-l-red-500 relative">
                        <div class="absolute top-3 right-3 text-[10px] font-bold text-red-600 uppercase tracking-wider">
                            {{ $laporan->prioritas }}
                        </div>
                        <h4 class="text-sm font-bold text-red-900 pr-12">{{ $laporan->nama_sarana }}</h4>
                        <p class="text-xs text-red-700/70 mt-1 line-clamp-2">{{ $laporan->keterangan_kerusakan }}</p>
                        <div class="text-[10px] text-red-500 mt-2 flex items-center gap-1 font-medium">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            {{ $laporan->lokasi?->nama_ruangan ?? '-' }}
                        </div>
                    </div>
                    @empty
                    <div class="p-4 border border-gray-100 rounded-xl text-center">
                        <p class="text-sm text-gray-500">Tidak ada isu prioritas tinggi.</p>
                    </div>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
@endsection
