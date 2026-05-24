@extends('layouts.admin')
@section('title', 'Berita Acara — PolLapor')
@section('page-title', 'Berita Acara & Arsip')

@section('content')

{{-- Page Header --}}
<div class="flex items-start justify-between mb-6">
    <div>
        <h1 class="text-xl font-bold text-gray-900 tracking-tight">Berita Acara & Arsip</h1>
        <p class="text-sm text-gray-500 mt-1">Cetak dan kunci laporan yang telah selesai ditangani</p>
    </div>
    <span class="text-xs font-medium text-blue-600 bg-blue-50 border border-blue-200 px-3 py-1.5 rounded-full whitespace-nowrap mt-1">
        {{ now()->translatedFormat('d F Y') }}
    </span>
</div>

{{-- Summary Cards --}}
<div class="grid grid-cols-1 sm:grid-cols-3 gap-3 mb-5">

    <div class="bg-white rounded-xl border border-gray-200 p-4 relative overflow-hidden hover:shadow-md transition-shadow">
        <div class="absolute top-0 left-0 right-0 h-0.5 bg-blue-500 rounded-t-xl"></div>
        <div class="flex items-center justify-between">
            <div>
                <div class="text-2xl font-bold text-gray-800 tracking-tight">{{ $laporans->total() }}</div>
                <div class="text-xs font-semibold text-gray-400 uppercase tracking-wide mt-1">Total Siap BA</div>
            </div>
            <div class="w-10 h-10 bg-blue-50 rounded-lg flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 p-4 relative overflow-hidden hover:shadow-md transition-shadow">
        <div class="absolute top-0 left-0 right-0 h-0.5 bg-red-500 rounded-t-xl"></div>
        <div class="flex items-center justify-between">
            <div>
                <div class="text-2xl font-bold text-red-600 tracking-tight">{{ $laporans->getCollection()->where('is_locked', true)->count() }}</div>
                <div class="text-xs font-semibold text-gray-400 uppercase tracking-wide mt-1">Sudah Dikunci</div>
            </div>
            <div class="w-10 h-10 bg-red-50 rounded-lg flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 p-4 relative overflow-hidden hover:shadow-md transition-shadow">
        <div class="absolute top-0 left-0 right-0 h-0.5 bg-green-500 rounded-t-xl"></div>
        <div class="flex items-center justify-between">
            <div>
                <div class="text-2xl font-bold text-green-600 tracking-tight">{{ $laporans->getCollection()->where('is_locked', false)->count() }}</div>
                <div class="text-xs font-semibold text-gray-400 uppercase tracking-wide mt-1">Belum Dikunci</div>
            </div>
            <div class="w-10 h-10 bg-green-50 rounded-lg flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 11V7a4 4 0 118 0m-4 8v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2z"/></svg>
            </div>
        </div>
    </div>

</div>

{{-- Info Banner --}}
<div class="bg-blue-50 border border-blue-100 rounded-xl px-5 py-3.5 flex items-start gap-3 mb-5">
    <svg class="w-4 h-4 text-blue-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
    <p class="text-xs text-blue-700 leading-relaxed">
        Halaman ini menampilkan laporan dengan status <span class="font-semibold">Selesai</span> dan <span class="font-semibold">Diteruskan ke Pusat</span> yang siap dicetak sebagai Berita Acara.
        Laporan yang telah dikunci <span class="font-semibold">tidak dapat diubah</span> dan bersifat final.
    </p>
</div>

{{-- Table Card --}}
<div class="bg-white border border-gray-200 rounded-xl overflow-hidden">

    {{-- Table Header --}}
    <div class="flex items-center justify-between px-5 py-3.5 border-b border-gray-100">
        <span class="text-sm font-semibold text-gray-800">Daftar Laporan Siap Berita Acara</span>
        <span class="text-xs text-gray-400 bg-gray-100 px-2.5 py-0.5 rounded-full font-medium">
            {{ $laporans->total() }} laporan
        </span>
    </div>

    {{-- Table --}}
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-100">
                    <th class="text-left text-xs font-semibold text-gray-400 uppercase tracking-wide px-5 py-3">ID Formulir</th>
                    <th class="text-left text-xs font-semibold text-gray-400 uppercase tracking-wide px-5 py-3">Sarana</th>
                    <th class="text-left text-xs font-semibold text-gray-400 uppercase tracking-wide px-5 py-3">Teknisi</th>
                    <th class="text-left text-xs font-semibold text-gray-400 uppercase tracking-wide px-5 py-3">Status</th>
                    <th class="text-left text-xs font-semibold text-gray-400 uppercase tracking-wide px-5 py-3">Kunci</th>
                    <th class="text-left text-xs font-semibold text-gray-400 uppercase tracking-wide px-5 py-3">Tanggal</th>
                    <th class="text-left text-xs font-semibold text-gray-400 uppercase tracking-wide px-5 py-3">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($laporans as $laporan)
                <tr class="hover:bg-gray-50 transition-colors {{ $laporan->is_locked ? 'opacity-75' : '' }}">

                    {{-- ID --}}
                    <td class="px-5 py-3.5">
                        <span class="font-mono text-xs text-gray-400 bg-gray-100 px-2 py-0.5 rounded">
                            {{ substr($laporan->formulir_id, 0, 8) }}…
                        </span>
                    </td>

                    {{-- Sarana --}}
                    <td class="px-5 py-3.5">
                        <div class="font-semibold text-sm text-gray-800">{{ $laporan->nama_sarana }}</div>
                        <div class="text-xs text-gray-400 mt-0.5">{{ $laporan->lokasi?->nama_ruangan ?? '—' }}</div>
                    </td>

                    {{-- Teknisi --}}
                    <td class="px-5 py-3.5">
                        @if($laporan->penanganan?->teknisi)
                            <div class="flex items-center gap-2">
                                <div class="w-6 h-6 rounded-full bg-blue-100 text-blue-700 flex items-center justify-center text-xs font-bold flex-shrink-0">
                                    {{ substr($laporan->penanganan->teknisi->nama_lengkap, 0, 1) }}
                                </div>
                                <span class="text-sm text-gray-700">{{ $laporan->penanganan->teknisi->nama_lengkap }}</span>
                            </div>
                        @else
                            <span class="text-sm text-gray-300">—</span>
                        @endif
                    </td>

                    {{-- Status Badge --}}
                    <td class="px-5 py-3.5">
                        @php
                            $badgeClass = match($laporan->status) {
                                'selesai'             => 'bg-green-50 text-green-700',
                                'diteruskan_ke_pusat' => 'bg-red-50 text-red-700',
                                default               => 'bg-gray-100 text-gray-500',
                            };
                            $dotClass = match($laporan->status) {
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

                    {{-- Kunci Status --}}
                    <td class="px-5 py-3.5">
                        @if($laporan->is_locked)
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-500">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                                Dikunci
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 11V7a4 4 0 118 0m-4 8v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2z"/></svg>
                                Terbuka
                            </span>
                        @endif
                    </td>

                    {{-- Tanggal --}}
                    <td class="px-5 py-3.5">
                        <span class="text-xs text-gray-500 whitespace-nowrap">
                            {{ $laporan->updated_at?->format('d/m/Y') }}
                        </span>
                        <div class="text-xs text-gray-300 mt-0.5">{{ $laporan->updated_at?->format('H:i') }}</div>
                    </td>

                    {{-- Aksi --}}
                    <td class="px-5 py-3.5">
                        <div class="flex items-center gap-2">

                            {{-- Cetak BA --}}
                            <a href="{{ route('berita-acara.generate', $laporan->formulir_id) }}" target="_blank"
                                class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold rounded-lg transition-colors">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                                Cetak
                            </a>

                            {{-- Kunci --}}
                            @if(!$laporan->is_locked)
                            <form method="POST" action="{{ route('berita-acara.kunci', $laporan->formulir_id) }}"
                                  onsubmit="return confirm('Yakin ingin mengunci laporan ini? Laporan yang dikunci tidak dapat diubah kembali.')">
                                @csrf
                                <button type="submit"
                                    class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-white hover:bg-red-50 text-gray-600 hover:text-red-600 text-xs font-semibold rounded-lg border border-gray-200 hover:border-red-200 transition-all">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                                    Kunci
                                </button>
                            </form>
                            @else
                            <span class="inline-flex items-center px-3 py-1.5 text-xs text-gray-300 font-medium cursor-default">
                                Final
                            </span>
                            @endif

                        </div>
                    </td>

                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-5 py-16 text-center">
                        <div class="flex flex-col items-center gap-3 text-gray-300">
                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            <div>
                                <span class="text-sm font-medium block">Belum ada laporan siap berita acara.</span>
                                <span class="text-xs mt-1 block">Laporan dengan status Selesai atau Diteruskan ke Pusat akan muncul di sini.</span>
                            </div>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    @if($laporans->hasPages())
    <div class="px-5 py-3 border-t border-gray-100 flex justify-end">
        {{ $laporans->links('pagination::simple-default') }}
    </div>
    @endif

</div>

@endsection