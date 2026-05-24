@extends('layouts.admin')
@section('title', 'Laporan — PolLapor')

@section('content')

{{-- Page Header --}}
<div class="flex items-start justify-between mb-6">
    <div>
        <h1 class="text-xl font-bold text-gray-900 tracking-tight">Daftar Laporan</h1>
        <p class="text-sm text-gray-500 mt-1">Kelola semua laporan fasilitas yang masuk</p>
    </div>
    <span class="text-xs font-medium text-blue-600 bg-blue-50 border border-blue-200 px-3 py-1.5 rounded-full whitespace-nowrap mt-1">
        {{ now()->translatedFormat('d F Y') }}
    </span>
</div>

{{-- Stats Grid --}}
<div class="grid grid-cols-2 sm:grid-cols-3 xl:grid-cols-6 gap-3 mb-5">

    <div class="bg-white rounded-xl border border-gray-200 p-4 relative overflow-hidden hover:shadow-md transition-shadow cursor-pointer group"
         onclick="setFilter('menunggu')">
        <div class="absolute top-0 left-0 right-0 h-0.5 bg-slate-400 rounded-t-xl"></div>
        <div class="text-2xl font-bold text-slate-500 tracking-tight">{{ $stats['menunggu'] }}</div>
        <div class="text-xs font-semibold text-gray-400 uppercase tracking-wide mt-1">Menunggu</div>
        @if($stats['menunggu'] > 0)
        <span class="absolute top-3 right-3 w-2 h-2 rounded-full bg-amber-400 animate-pulse"></span>
        @endif
    </div>

    <div class="bg-white rounded-xl border border-gray-200 p-4 relative overflow-hidden hover:shadow-md transition-shadow cursor-pointer group"
         onclick="setFilter('ditugaskan')">
        <div class="absolute top-0 left-0 right-0 h-0.5 bg-blue-500 rounded-t-xl"></div>
        <div class="text-2xl font-bold text-blue-600 tracking-tight">{{ $stats['ditugaskan'] }}</div>
        <div class="text-xs font-semibold text-gray-400 uppercase tracking-wide mt-1">Ditugaskan</div>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 p-4 relative overflow-hidden hover:shadow-md transition-shadow cursor-pointer group"
         onclick="setFilter('sedang_dikerjakan')">
        <div class="absolute top-0 left-0 right-0 h-0.5 bg-amber-400 rounded-t-xl"></div>
        <div class="text-2xl font-bold text-amber-600 tracking-tight">{{ $stats['sedang_dikerjakan'] }}</div>
        <div class="text-xs font-semibold text-gray-400 uppercase tracking-wide mt-1">Sedang Dikerjakan</div>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 p-4 relative overflow-hidden hover:shadow-md transition-shadow cursor-pointer group"
         onclick="setFilter('selesai')">
        <div class="absolute top-0 left-0 right-0 h-0.5 bg-green-500 rounded-t-xl"></div>
        <div class="text-2xl font-bold text-green-600 tracking-tight">{{ $stats['selesai'] }}</div>
        <div class="text-xs font-semibold text-gray-400 uppercase tracking-wide mt-1">Selesai</div>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 p-4 relative overflow-hidden hover:shadow-md transition-shadow cursor-pointer group"
         onclick="setFilter('diteruskan_ke_pusat')">
        <div class="absolute top-0 left-0 right-0 h-0.5 bg-red-500 rounded-t-xl"></div>
        <div class="text-2xl font-bold text-red-600 tracking-tight">{{ $stats['diteruskan'] }}</div>
        <div class="text-xs font-semibold text-gray-400 uppercase tracking-wide mt-1">Diteruskan</div>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 p-4 relative overflow-hidden hover:shadow-md transition-shadow">
        <div class="absolute top-0 left-0 right-0 h-0.5 bg-gray-800 rounded-t-xl"></div>
        <div class="text-2xl font-bold text-gray-800 tracking-tight">{{ $stats['total'] }}</div>
        <div class="text-xs font-semibold text-gray-400 uppercase tracking-wide mt-1">Total</div>
    </div>

</div>

{{-- Filter --}}
<form method="GET" action="{{ route('laporan.index') }}" id="filter-form">
    <div class="bg-white border border-gray-200 rounded-xl px-4 py-3 flex items-center gap-3 flex-wrap mb-5">

        <svg class="w-4 h-4 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01-.293.707L13 13.414V19a1 1 0 01-.553.894l-4 2A1 1 0 017 21v-7.586L3.293 6.707A1 1 0 013 6V4z"/></svg>
        <span class="text-xs font-semibold text-gray-400 uppercase tracking-wide">Filter</span>

        <input type="text" name="search" value="{{ request('search') }}"
            placeholder="Cari sarana atau deskripsi..."
            class="flex-1 min-w-40 h-8 text-sm border border-gray-200 rounded-lg px-3 bg-gray-50 text-gray-700 placeholder-gray-400 focus:outline-none focus:border-blue-400 focus:bg-white transition-colors">

        <select name="status" id="status-select"
            class="h-8 text-sm border border-gray-200 rounded-lg px-3 bg-gray-50 text-gray-700 focus:outline-none focus:border-blue-400 focus:bg-white transition-colors cursor-pointer" style="min-width:160px">
            <option value="">Semua Status</option>
            <option value="menunggu"            {{ request('status') == 'menunggu' ? 'selected' : '' }}>Menunggu</option>
            <option value="ditugaskan"          {{ request('status') == 'ditugaskan' ? 'selected' : '' }}>Ditugaskan</option>
            <option value="sedang_dikerjakan"   {{ request('status') == 'sedang_dikerjakan' ? 'selected' : '' }}>Sedang Dikerjakan</option>
            <option value="selesai"             {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
            <option value="diteruskan_ke_pusat" {{ request('status') == 'diteruskan_ke_pusat' ? 'selected' : '' }}>Diteruskan ke Pusat</option>
        </select>

        <input type="date" name="dari_tanggal" value="{{ request('dari_tanggal') }}"
            class="h-8 text-sm border border-gray-200 rounded-lg px-3 bg-gray-50 text-gray-700 focus:outline-none focus:border-blue-400 focus:bg-white transition-colors" style="width:135px">

        <input type="date" name="sampai_tanggal" value="{{ request('sampai_tanggal') }}"
            class="h-8 text-sm border border-gray-200 rounded-lg px-3 bg-gray-50 text-gray-700 focus:outline-none focus:border-blue-400 focus:bg-white transition-colors" style="width:135px">

        <div class="flex gap-2 ml-auto">
            <button type="submit"
                class="h-8 px-4 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-lg flex items-center gap-1.5 transition-colors">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35" stroke-linecap="round" stroke-linejoin="round"/></svg>
                Filter
            </button>
            <a href="{{ route('laporan.index') }}"
                class="h-8 px-4 bg-white hover:bg-gray-50 text-gray-600 text-sm font-semibold rounded-lg border border-gray-200 flex items-center transition-colors">
                Reset
            </a>
        </div>

    </div>
</form>

{{-- Active filter indicator --}}
@if(request()->hasAny(['search', 'status', 'dari_tanggal', 'sampai_tanggal']))
<div class="flex items-center gap-2 mb-4 flex-wrap">
    <span class="text-xs text-gray-400 font-medium">Filter aktif:</span>
    @if(request('status'))
    <span class="inline-flex items-center gap-1 text-xs font-semibold bg-blue-50 text-blue-700 border border-blue-100 px-2.5 py-1 rounded-full">
        Status: {{ str_replace('_', ' ', ucfirst(request('status'))) }}
    </span>
    @endif
    @if(request('search'))
    <span class="inline-flex items-center gap-1 text-xs font-semibold bg-blue-50 text-blue-700 border border-blue-100 px-2.5 py-1 rounded-full">
        Cari: "{{ request('search') }}"
    </span>
    @endif
    @if(request('dari_tanggal') || request('sampai_tanggal'))
    <span class="inline-flex items-center gap-1 text-xs font-semibold bg-blue-50 text-blue-700 border border-blue-100 px-2.5 py-1 rounded-full">
        Tanggal: {{ request('dari_tanggal') ?? '—' }} s/d {{ request('sampai_tanggal') ?? '—' }}
    </span>
    @endif
</div>
@endif

{{-- Table --}}
<div class="bg-white border border-gray-200 rounded-xl overflow-hidden">

    <div class="flex items-center justify-between px-5 py-3.5 border-b border-gray-100">
        <span class="text-sm font-semibold text-gray-800">Daftar Laporan</span>
        <span class="text-xs text-gray-400 bg-gray-100 px-2.5 py-0.5 rounded-full font-medium">
            {{ $laporans->total() }} laporan
        </span>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-100">
                    <th class="text-left text-xs font-semibold text-gray-400 uppercase tracking-wide px-5 py-3">ID</th>
                    <th class="text-left text-xs font-semibold text-gray-400 uppercase tracking-wide px-5 py-3">Sarana</th>
                    <th class="text-left text-xs font-semibold text-gray-400 uppercase tracking-wide px-5 py-3">Pelapor</th>
                    <th class="text-left text-xs font-semibold text-gray-400 uppercase tracking-wide px-5 py-3">Lokasi</th>
                    <th class="text-left text-xs font-semibold text-gray-400 uppercase tracking-wide px-5 py-3">Status</th>
                    <th class="text-left text-xs font-semibold text-gray-400 uppercase tracking-wide px-5 py-3">Prioritas</th>
                    <th class="text-left text-xs font-semibold text-gray-400 uppercase tracking-wide px-5 py-3">Tanggal</th>
                    <th class="text-left text-xs font-semibold text-gray-400 uppercase tracking-wide px-5 py-3">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($laporans as $laporan)
                <tr class="hover:bg-gray-50 transition-colors">

                    <td class="px-5 py-3.5">
                        <span class="font-mono text-xs text-gray-400 bg-gray-100 px-1.5 py-0.5 rounded">
                            {{ substr($laporan->formulir_id, 0, 8) }}…
                        </span>
                    </td>

                    <td class="px-5 py-3.5">
                        <div class="font-semibold text-sm text-gray-800">{{ $laporan->nama_sarana }}</div>
                        <div class="text-xs text-gray-400 mt-0.5 max-w-xs truncate">{{ $laporan->keterangan_kerusakan }}</div>
                    </td>

                    <td class="px-5 py-3.5">
                        @if($laporan->pelapor)
                        <div class="flex items-center gap-2">
                            <div class="w-6 h-6 rounded-full bg-gray-100 text-gray-500 flex items-center justify-center text-xs font-bold flex-shrink-0">
                                {{ substr($laporan->pelapor->nama_lengkap ?? 'U', 0, 1) }}
                            </div>
                            <span class="text-sm text-gray-600">{{ $laporan->pelapor->nama_lengkap }}</span>
                        </div>
                        @else
                            <span class="text-sm text-gray-300">—</span>
                        @endif
                    </td>

                    <td class="px-5 py-3.5">
                        <span class="text-sm text-gray-600">{{ $laporan->lokasi?->nama_ruangan ?? '—' }}</span>
                    </td>

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
                            <span class="w-1.5 h-1.5 rounded-full {{ $dotClass }} {{ $laporan->status == 'menunggu' ? 'animate-pulse' : '' }}"></span>
                            {{ $laporan->status_label }}
                        </span>
                    </td>

                    <td class="px-5 py-3.5">
                        @if($laporan->prioritas)
                        @php
                            $prioBadge = match(strtolower($laporan->prioritas)) {
                                'tinggi' => 'bg-red-50 text-red-600',
                                'sedang' => 'bg-amber-50 text-amber-600',
                                'rendah' => 'bg-gray-100 text-gray-500',
                                default  => 'bg-gray-100 text-gray-500',
                            };
                        @endphp
                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-semibold {{ $prioBadge }}">
                            {{ ucfirst($laporan->prioritas) }}
                        </span>
                        @else
                            <span class="text-xs text-gray-300">—</span>
                        @endif
                    </td>

                    <td class="px-5 py-3.5">
                        <span class="text-xs text-gray-500 whitespace-nowrap">{{ $laporan->created_at?->format('d/m/Y') }}</span>
                        <div class="text-xs text-gray-300 mt-0.5">{{ $laporan->created_at?->format('H:i') }}</div>
                    </td>

                    <td class="px-5 py-3.5">
                        <a href="{{ route('laporan.show', $laporan->formulir_id) }}"
                            class="inline-flex items-center gap-1 px-3 py-1.5 bg-gray-100 hover:bg-blue-600 text-gray-600 hover:text-white text-xs font-semibold rounded-lg border border-gray-200 hover:border-blue-600 transition-all">
                            Detail
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                        </a>
                    </td>

                </tr>
                @empty
                <tr>
                    <td colspan="8" class="px-5 py-16 text-center">
                        <div class="flex flex-col items-center gap-3 text-gray-300">
                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            <span class="text-sm font-medium">Tidak ada laporan ditemukan.</span>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($laporans->hasPages())
    <div class="px-5 py-3 border-t border-gray-100 flex justify-end">
        {{ $laporans->links('pagination::simple-default') }}
    </div>
    @endif

</div>

<script>
function setFilter(status) {
    document.getElementById('status-select').value = status;
    document.getElementById('filter-form').submit();
}
</script>

@endsection