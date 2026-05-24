@extends('layouts.admin')
@section('title', 'Detail Laporan — PolLapor')

@section('content')

{{-- Breadcrumb --}}
<div class="flex items-center gap-2 text-xs text-gray-400 mb-5">
    <a href="{{ route('laporan.index') }}" class="hover:text-blue-600 transition-colors font-medium">Dashboard</a>
    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
    <span class="text-gray-400">Laporan</span>
    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
    <span class="text-gray-700 font-semibold">Detail Laporan</span>
</div>

{{-- Page Header --}}
<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-6">
    <div>
        <h1 class="text-xl font-bold text-gray-900 tracking-tight">Detail Laporan</h1>
        <p class="text-sm text-gray-500 mt-0.5">Informasi lengkap dan penanganan laporan fasilitas</p>
    </div>
    <div class="flex items-center gap-2 flex-wrap">
        @php
            $statusColor = match($laporan->status) {
                'menunggu'            => 'bg-slate-100 text-slate-600 border-slate-200',
                'ditugaskan'          => 'bg-blue-50 text-blue-700 border-blue-200',
                'sedang_dikerjakan'   => 'bg-amber-50 text-amber-700 border-amber-200',
                'selesai'             => 'bg-green-50 text-green-700 border-green-200',
                'diteruskan_ke_pusat' => 'bg-red-50 text-red-700 border-red-200',
                default               => 'bg-gray-100 text-gray-500 border-gray-200',
            };
        @endphp
        <span class="px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wide border {{ $statusColor }}">
            {{ $laporan->status_label }}
        </span>
        <a href="{{ route('dashboard') }}"
            class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-white border border-gray-200 text-gray-600 text-xs font-semibold rounded-lg hover:bg-gray-50 transition-colors">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            Kembali
        </a>
    </div>
</div>

{{-- Main Grid --}}
<div class="grid grid-cols-1 lg:grid-cols-3 gap-5">

    {{-- ═══════════════════════════════════════ --}}
    {{-- LEFT COLUMN (span 2)                   --}}
    {{-- ═══════════════════════════════════════ --}}
    <div class="lg:col-span-2 space-y-5">

        {{-- Data Utama --}}
        <div class="bg-white border border-gray-200 rounded-xl overflow-hidden">
            <div class="flex items-center gap-2 px-5 py-3.5 border-b border-gray-100">
                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                <h2 class="text-sm font-semibold text-gray-800">Data Utama</h2>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-0 divide-y sm:divide-y-0 sm:divide-x divide-gray-100">
                {{-- Left sub-col --}}
                <div class="divide-y divide-gray-100">
                    <div class="px-5 py-4">
                        <div class="text-xs text-gray-400 font-medium mb-1">Nomor Formulir</div>
                        <div class="font-mono text-sm font-semibold text-gray-800">{{ substr($laporan->formulir_id, 0, 12) }}…</div>
                    </div>
                    <div class="px-5 py-4">
                        <div class="text-xs text-gray-400 font-medium mb-1">Nama Sarana</div>
                        <div class="text-sm font-semibold text-gray-800">{{ $laporan->nama_sarana }}</div>
                    </div>
                    <div class="px-5 py-4">
                        <div class="text-xs text-gray-400 font-medium mb-1">Nomor Inventaris</div>
                        <div class="text-sm font-semibold text-gray-800">{{ $laporan->nomor_inventaris ?? '—' }}</div>
                    </div>
                </div>
                {{-- Right sub-col --}}
                <div class="divide-y divide-gray-100">
                    <div class="px-5 py-4">
                        <div class="text-xs text-gray-400 font-medium mb-1">Tanggal Masuk</div>
                        <div class="text-sm font-semibold text-gray-800">{{ $laporan->created_at?->format('d M Y, H:i') ?? '—' }}</div>
                    </div>
                    <div class="px-5 py-4">
                        <div class="text-xs text-gray-400 font-medium mb-1">Lokasi</div>
                        <div class="text-sm font-semibold text-gray-800">{{ $laporan->lokasi?->nama_ruangan ?? '—' }}</div>
                    </div>
                    <div class="px-5 py-4">
                        <div class="text-xs text-gray-400 font-medium mb-1">Pelapor</div>
                        <div class="text-sm font-semibold text-gray-800">{{ $laporan->pelapor?->nama_lengkap ?? '—' }}</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Keterangan Kerusakan --}}
        <div class="bg-white border border-gray-200 rounded-xl overflow-hidden">
            <div class="flex items-center gap-2 px-5 py-3.5 border-b border-gray-100">
                <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                <h2 class="text-sm font-semibold text-gray-800">Keterangan Kerusakan</h2>
            </div>
            <div class="px-5 py-4">
                <p class="text-sm text-gray-700 leading-relaxed">{{ $laporan->keterangan_kerusakan }}</p>
            </div>
        </div>

        {{-- Dokumentasi --}}
        <div class="bg-white border border-gray-200 rounded-xl overflow-hidden">
            <div class="flex items-center gap-2 px-5 py-3.5 border-b border-gray-100">
                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                <h2 class="text-sm font-semibold text-gray-800">Dokumentasi</h2>
            </div>
            <div class="px-5 py-4">
                @if($laporan->foto_kerusakan_url)
                    <div class="rounded-lg overflow-hidden mb-3 bg-gray-100">
                        <img src="{{ $laporan->foto_kerusakan_url }}"
                             class="w-full h-72 object-cover"
                             alt="Foto Kerusakan">
                    </div>
                @else
                    <div class="rounded-lg bg-gray-50 border border-dashed border-gray-200 h-48 flex flex-col items-center justify-center text-gray-300 mb-3">
                        <svg class="w-10 h-10 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        <span class="text-xs font-medium">Tidak ada foto kerusakan</span>
                    </div>
                @endif
            </div>
        </div>

        {{-- Riwayat Aktivitas --}}
        <div class="bg-white border border-gray-200 rounded-xl overflow-hidden">
            <div class="flex items-center gap-2 px-5 py-3.5 border-b border-gray-100">
                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <h2 class="text-sm font-semibold text-gray-800">Riwayat Aktivitas</h2>
                <span class="ml-auto text-xs text-gray-400 bg-gray-100 px-2 py-0.5 rounded-full">{{ $laporan->trackings->count() }} aktivitas</span>
            </div>
            <div class="px-5 py-4">
                @forelse($laporan->trackings as $track)
                <div class="relative flex gap-4 {{ !$loop->last ? 'pb-6' : '' }}">
                    {{-- vertical line --}}
                    @if(!$loop->last)
                    <div class="absolute left-[7px] top-5 bottom-0 w-px bg-gray-100"></div>
                    @endif

                    {{-- dot --}}
                    <div class="w-3.5 h-3.5 rounded-full bg-blue-100 border-2 border-blue-500 flex-shrink-0 mt-1 relative z-10"></div>

                    {{-- content --}}
                    <div class="flex-1 min-w-0">
                        <div class="flex items-start justify-between gap-2">
                            <div>
                                <span class="text-sm font-semibold text-gray-800">{{ $track->aktor?->nama_lengkap ?? 'Sistem' }}</span>
                                <span class="text-sm text-gray-400"> melakukan pembaruan</span>
                            </div>
                            <span class="text-xs text-gray-400 whitespace-nowrap flex-shrink-0">{{ $track->created_at?->format('d M, H:i') }}</span>
                        </div>
                        <p class="mt-1.5 text-xs text-gray-600 bg-gray-50 border border-gray-100 rounded-lg px-3 py-2 inline-block">
                            {{ $track->pesan_narasi }}
                        </p>
                    </div>
                </div>
                @empty
                <div class="py-8 text-center">
                    <div class="text-gray-300 mb-2">
                        <svg class="w-8 h-8 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <p class="text-sm text-gray-400">Belum ada aktivitas.</p>
                </div>
                @endforelse

                @if($laporan->status == 'menunggu')
                <div class="mt-4 pt-4 border-t border-gray-100 text-center">
                    <span class="inline-flex items-center gap-1.5 text-xs text-gray-400 bg-gray-50 border border-gray-100 px-3 py-2 rounded-lg">
                        <span class="w-1.5 h-1.5 rounded-full bg-amber-400 animate-pulse"></span>
                        Menunggu penugasan teknisi...
                    </span>
                </div>
                @endif
            </div>
        </div>

    </div>

    {{-- ═══════════════════════════════════════ --}}
    {{-- RIGHT COLUMN (span 1)                  --}}
    {{-- ═══════════════════════════════════════ --}}
    <div class="space-y-5">

        {{-- Status Stepper --}}
        <div class="bg-white border border-gray-200 rounded-xl overflow-hidden">
            <div class="px-5 py-3.5 border-b border-gray-100">
                <h2 class="text-sm font-semibold text-gray-800">Status Laporan</h2>
            </div>
            <div class="px-5 py-4">
                @php
                    $steps = [
                        ['label' => 'Laporan Dibuat',     'done' => true,                                                                                   'time' => $laporan->created_at?->format('d M, H:i')],
                        ['label' => 'Ditinjau Admin',     'done' => $laporan->status != 'menunggu',                                                         'time' => $laporan->updated_at?->format('d M, H:i')],
                        ['label' => 'Teknisi Ditugaskan', 'done' => in_array($laporan->status, ['ditugaskan','sedang_dikerjakan','selesai']),                'time' => null],
                        ['label' => 'Dalam Penanganan',   'done' => in_array($laporan->status, ['sedang_dikerjakan','selesai']),                             'time' => null],
                        ['label' => 'Selesai',            'done' => $laporan->status == 'selesai',                                                          'time' => null],
                    ];
                    $currentStep = collect($steps)->filter(fn($s) => $s['done'])->count();
                @endphp

                <div class="space-y-0">
                    @foreach($steps as $i => $step)
                    <div class="flex gap-3 relative {{ !$loop->last ? 'pb-5' : '' }}">
                        {{-- connector line --}}
                        @if(!$loop->last)
                        <div class="absolute left-[11px] top-6 bottom-0 w-0.5 {{ $step['done'] && isset($steps[$i+1]) && $steps[$i+1]['done'] ? 'bg-blue-500' : 'bg-gray-100' }}"></div>
                        @endif

                        {{-- step circle --}}
                        <div class="flex-shrink-0 mt-0.5 relative z-10">
                            @if($step['done'])
                                <div class="w-6 h-6 rounded-full bg-blue-600 flex items-center justify-center">
                                    <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                                </div>
                            @elseif($i == $currentStep)
                                <div class="w-6 h-6 rounded-full border-2 border-blue-500 bg-white flex items-center justify-center">
                                    <div class="w-2 h-2 rounded-full bg-blue-500"></div>
                                </div>
                            @else
                                <div class="w-6 h-6 rounded-full border-2 border-gray-200 bg-white"></div>
                            @endif
                        </div>

                        {{-- step info --}}
                        <div class="flex-1 min-w-0 pt-0.5">
                            <div class="text-sm font-semibold {{ $step['done'] ? 'text-gray-800' : ($i == $currentStep ? 'text-blue-600' : 'text-gray-300') }}">
                                {{ $step['label'] }}
                            </div>
                            @if($step['time'])
                            <div class="text-xs text-gray-400 mt-0.5">{{ $step['time'] }}</div>
                            @elseif(!$step['done'])
                            <div class="text-xs text-gray-300 mt-0.5">Menunggu...</div>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Tugaskan Teknisi --}}
        <div class="bg-white border border-gray-200 rounded-xl overflow-hidden">
            <div class="flex items-center gap-2 px-5 py-3.5 border-b border-gray-100">
                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                <h2 class="text-sm font-semibold text-gray-800">Tugaskan Teknisi</h2>
            </div>
            <div class="px-5 py-4">
                @if($laporan->penanganan)
                    {{-- Already assigned --}}
                    <div class="bg-blue-50 border border-blue-100 rounded-lg p-4">
                        <div class="text-xs font-semibold text-blue-500 uppercase tracking-wide mb-2">Ditugaskan Kepada</div>
                        <div class="flex items-center gap-3 mb-3">
                            <div class="w-8 h-8 rounded-full bg-blue-200 text-blue-700 flex items-center justify-center text-sm font-bold flex-shrink-0">
                                {{ substr($laporan->penanganan->teknisi?->nama_lengkap ?? 'T', 0, 1) }}
                            </div>
                            <div>
                                <div class="text-sm font-bold text-blue-900">{{ $laporan->penanganan->teknisi?->nama_lengkap ?? '—' }}</div>
                                <div class="text-xs text-blue-500">{{ $laporan->penanganan->teknisi?->unit_jurusan ?? '' }}</div>
                            </div>
                        </div>
                        <div class="flex items-center gap-1.5 text-xs text-blue-600 font-medium">
                            <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span>
                            {{ $laporan->penanganan->status_label }}
                        </div>
                    </div>
                @else
                    @if($teknisiList->isEmpty())
                        <div class="text-center py-6">
                            <svg class="w-8 h-8 text-gray-200 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            <p class="text-sm text-gray-400">Tidak ada teknisi tersedia.</p>
                        </div>
                    @else
                        <form method="POST" action="{{ route('laporan.assign', $laporan->formulir_id) }}">
                            @csrf
                            <div class="mb-4">
                                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">Pilih Teknisi</label>
                                <select name="teknisi_id"
                                    class="w-full h-10 text-sm border border-gray-200 rounded-lg px-3 bg-gray-50 text-gray-700 focus:outline-none focus:border-blue-400 focus:bg-white transition-colors cursor-pointer"
                                    required>
                                    <option value="">— Pilih Teknisi —</option>
                                    @foreach($teknisiList as $teknisi)
                                    <option value="{{ $teknisi->user_id }}">
                                        {{ $teknisi->nama_lengkap }}{{ $teknisi->unit_jurusan ? ' ('.$teknisi->unit_jurusan.')' : '' }}
                                    </option>
                                    @endforeach
                                </select>
                                <div class="mt-2 flex items-center gap-1.5 text-xs text-blue-600 font-medium">
                                    <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span>
                                    {{ $teknisiList->count() }} teknisi tersedia
                                </div>
                            </div>
                            <button type="submit"
                                class="w-full h-10 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-lg flex items-center justify-center gap-2 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                                Assign Teknisi
                            </button>
                        </form>
                    @endif
                @endif
            </div>
        </div>

        {{-- Tindakan Cepat --}}
        <div class="bg-white border border-gray-200 rounded-xl overflow-hidden">
            <div class="px-5 py-3.5 border-b border-gray-100">
                <h2 class="text-sm font-semibold text-gray-800">Tindakan Cepat</h2>
            </div>
            <div class="p-4 grid grid-cols-2 gap-2.5">

                {{-- Ubah Status --}}
                <button type="button"
                    class="flex flex-col items-center gap-2 p-4 rounded-lg border border-gray-200 hover:border-blue-300 hover:bg-blue-50 text-gray-500 hover:text-blue-600 transition-all group">
                    <div class="w-9 h-9 rounded-lg bg-gray-50 group-hover:bg-blue-100 flex items-center justify-center transition-colors">
                        <svg class="w-4.5 h-4.5 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    </div>
                    <span class="text-xs font-semibold">Ubah Status</span>
                </button>

                {{-- Cetak --}}
                <a href="{{ route('berita-acara.generate', $laporan->formulir_id) }}" target="_blank"
                    class="flex flex-col items-center gap-2 p-4 rounded-lg border border-gray-200 hover:border-blue-300 hover:bg-blue-50 text-gray-500 hover:text-blue-600 transition-all group">
                    <div class="w-9 h-9 rounded-lg bg-gray-50 group-hover:bg-blue-100 flex items-center justify-center transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                    </div>
                    <span class="text-xs font-semibold">Cetak BA</span>
                </a>

                {{-- Tolak --}}
                <button type="button"
                    onclick="alert('Fitur Tolak Laporan belum tersedia.')"
                    class="flex flex-col items-center gap-2 p-4 rounded-lg border border-red-100 bg-red-50 hover:bg-red-100 hover:border-red-200 text-red-500 transition-all group">
                    <div class="w-9 h-9 rounded-lg bg-white flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </div>
                    <span class="text-xs font-semibold">Tolak</span>
                </button>

                {{-- Hubungi --}}
                <a href="mailto:{{ $laporan->pelapor?->email ?? '' }}"
                    class="flex flex-col items-center gap-2 p-4 rounded-lg border border-gray-200 hover:border-blue-300 hover:bg-blue-50 text-gray-500 hover:text-blue-600 transition-all group">
                    <div class="w-9 h-9 rounded-lg bg-gray-50 group-hover:bg-blue-100 flex items-center justify-center transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    </div>
                    <span class="text-xs font-semibold">Hubungi</span>
                </a>

            </div>
        </div>

    </div>
</div>

@endsection