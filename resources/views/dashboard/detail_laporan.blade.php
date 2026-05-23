@extends('layouts.admin')
@section('title', 'Detail Laporan — PolLapor')

@section('content')
    <!-- Breadcrumb & Header -->
    <div class="mb-6">
        <div class="flex items-center gap-2 text-sm text-gray-500 mb-2">
            <a href="{{ route('dashboard') }}" class="hover:text-blue-600 transition-colors">Dashboard</a>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            <a href="#" class="hover:text-blue-600 transition-colors">Laporan</a>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            <span class="font-semibold text-blue-700">Detail Laporan</span>
        </div>
        
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Detail Laporan</h1>
                <p class="text-sm text-gray-500 mt-1">Informasi lengkap dan penanganan laporan fasilitas</p>
            </div>
            <div class="flex flex-wrap items-center gap-3">
                <span class="px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-orange-100 text-orange-700 border border-orange-200">
                    {{ $laporan->status_label }}
                </span>
                <span class="px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-red-100 text-red-700 border border-red-200">
                    Prioritas Tinggi
                </span>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Left Column (Span 2) -->
        <div class="lg:col-span-2 space-y-6">
            
            <!-- Data Utama -->
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <div class="flex items-center gap-2 mb-6">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    <h2 class="text-lg font-bold text-gray-900">Data Utama</h2>
                </div>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-y-6 gap-x-12">
                    <div>
                        <div class="text-sm text-gray-500 mb-1">Nomor Surat</div>
                        <div class="font-semibold text-gray-900">{{ substr($laporan->formulir_id, 0, 12) }}</div>
                    </div>
                    <div>
                        <div class="text-sm text-gray-500 mb-1">Tanggal Masuk</div>
                        <div class="font-semibold text-gray-900">{{ $laporan->created_at?->format('d M Y') ?? '-' }}</div>
                    </div>
                    <div>
                        <div class="text-sm text-gray-500 mb-1">Nama Sarana</div>
                        <div class="font-semibold text-gray-900">{{ $laporan->nama_sarana }}</div>
                    </div>
                    <div>
                        <div class="text-sm text-gray-500 mb-1">Lokasi</div>
                        <div class="font-semibold text-gray-900">{{ $laporan->lokasi?->nama_ruangan ?? '-' }}</div>
                    </div>
                    <div>
                        <div class="text-sm text-gray-500 mb-1">Nomor Inventaris</div>
                        <div class="font-semibold text-gray-900">{{ $laporan->nomor_inventaris ?? '-' }}</div>
                    </div>
                    <div>
                        <div class="text-sm text-gray-500 mb-1">Pelapor</div>
                        <div class="font-semibold text-gray-900">{{ $laporan->pelapor?->nama_lengkap ?? '-' }}</div>
                    </div>
                </div>
            </div>

            <!-- Keterangan Kerusakan -->
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <div class="flex items-center gap-2 mb-4">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    <h2 class="text-lg font-bold text-gray-900">Keterangan Kerusakan</h2>
                </div>
                <p class="text-gray-700 text-sm leading-relaxed">
                    {{ $laporan->keterangan_kerusakan }}
                </p>
            </div>

            <!-- Dokumentasi -->
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <div class="flex items-center gap-2 mb-4">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    <h2 class="text-lg font-bold text-gray-900">Dokumentasi</h2>
                </div>
                
                @if($laporan->foto_kerusakan_url)
                <div class="rounded-xl overflow-hidden mb-4">
                    <img src="{{ $laporan->foto_kerusakan_url }}" class="w-full h-80 object-cover" alt="Foto Kerusakan Utama">
                </div>
                @else
                <div class="rounded-xl overflow-hidden mb-4 bg-gray-200 flex items-center justify-center h-80">
                    <span class="text-gray-400">Tidak ada foto</span>
                </div>
                @endif
                
                <!-- Mockup Thumbnails -->
                <div class="flex flex-wrap gap-4">
                    <div class="w-24 h-20 bg-gray-200 rounded-lg overflow-hidden"><img src="https://images.unsplash.com/photo-1621252179027-94459d278660?q=80&w=300&auto=format&fit=crop" class="w-full h-full object-cover"></div>
                    <div class="w-24 h-20 bg-gray-200 rounded-lg overflow-hidden"><img src="https://images.unsplash.com/photo-1581092921461-eab62e97a780?q=80&w=300&auto=format&fit=crop" class="w-full h-full object-cover"></div>
                    <div class="w-24 h-20 bg-gray-200 rounded-lg overflow-hidden"><img src="https://images.unsplash.com/photo-1628102491629-778571d893a3?q=80&w=300&auto=format&fit=crop" class="w-full h-full object-cover"></div>
                    <div class="w-24 h-20 bg-gray-100 rounded-lg flex items-center justify-center text-sm font-semibold text-gray-500">+2 Foto</div>
                </div>
            </div>

            <!-- Riwayat Aktivitas -->
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <div class="flex items-center gap-2 mb-6">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <h2 class="text-lg font-bold text-gray-900">Riwayat Aktivitas</h2>
                </div>
                
                <div class="relative pl-4 space-y-6">
                    @forelse($laporan->trackings as $track)
                    <div class="relative">
                        <!-- Line -->
                        @if(!$loop->last)
                        <div class="absolute top-5 left-1.5 w-px h-full bg-gray-200"></div>
                        @endif
                        
                        <div class="flex items-start gap-4">
                            <div class="w-3 h-3 rounded-full bg-blue-500 mt-1.5 relative z-10 ring-4 ring-white"></div>
                            <div class="flex-1">
                                <div class="flex flex-col sm:flex-row sm:justify-between items-start gap-1">
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">{{ $track->aktor?->nama_lengkap ?? 'Sistem' }} <span class="font-normal text-gray-500">melakukan pembaruan</span></p>
                                        <p class="text-sm text-gray-600 mt-1 bg-gray-50 p-2 rounded-lg inline-block">{{ $track->pesan_narasi }}</p>
                                    </div>
                                    <div class="text-xs text-gray-400 whitespace-nowrap">{{ $track->created_at?->format('d M, H:i') }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <p class="text-sm text-gray-500">Belum ada aktivitas.</p>
                    @endforelse
                    
                    @if($laporan->status == 'menunggu')
                    <div class="pt-4 text-center">
                        <span class="inline-block px-4 py-2 bg-gray-50 text-gray-500 text-xs rounded-lg font-medium border border-gray-100">Menunggu penugasan teknisi...</span>
                    </div>
                    @endif
                </div>
            </div>

        </div>

        <!-- Right Column (Span 1) -->
        <div class="space-y-6">
            
            <!-- Status Laporan (Stepper) -->
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <h2 class="text-lg font-bold text-gray-900 mb-6">Status Laporan</h2>
                
                <div class="relative space-y-6 pl-2">
                    <!-- Step 1 -->
                    <div class="flex gap-4 relative">
                        <div class="absolute top-6 left-2.5 w-px h-10 bg-blue-500"></div>
                        <div class="w-5 h-5 rounded-full bg-blue-600 text-white flex items-center justify-center relative z-10 mt-0.5 shadow-sm">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        </div>
                        <div>
                            <h4 class="text-sm font-bold text-gray-900">Laporan Dibuat</h4>
                            <p class="text-xs text-gray-500">{{ $laporan->created_at?->format('d M, H:i') }}</p>
                        </div>
                    </div>

                    <!-- Step 2 -->
                    <div class="flex gap-4 relative">
                        <div class="absolute top-6 left-2.5 w-px h-10 {{ $laporan->status != 'menunggu' ? 'bg-blue-500' : 'bg-gray-200' }}"></div>
                        <div class="w-5 h-5 rounded-full {{ $laporan->status != 'menunggu' ? 'bg-blue-600 text-white' : 'bg-white border-2 border-blue-600 ring-2 ring-blue-100' }} flex items-center justify-center relative z-10 mt-0.5 shadow-sm">
                            @if($laporan->status != 'menunggu')
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            @else
                                <div class="w-2 h-2 rounded-full bg-blue-600"></div>
                            @endif
                        </div>
                        <div>
                            <h4 class="text-sm font-bold {{ $laporan->status != 'menunggu' ? 'text-gray-900' : 'text-blue-700' }}">Ditinjau Admin</h4>
                            <p class="text-xs text-gray-500">{{ $laporan->updated_at?->format('d M, H:i') }}</p>
                        </div>
                    </div>

                    <!-- Step 3 -->
                    <div class="flex gap-4 relative">
                        <div class="absolute top-6 left-2.5 w-px h-10 bg-gray-200"></div>
                        <div class="w-5 h-5 rounded-full {{ in_array($laporan->status, ['ditugaskan', 'sedang_dikerjakan', 'selesai']) ? 'bg-blue-600 text-white' : 'bg-white border-2 border-gray-300' }} flex items-center justify-center relative z-10 mt-0.5">
                            @if(in_array($laporan->status, ['ditugaskan', 'sedang_dikerjakan', 'selesai']))
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            @endif
                        </div>
                        <div>
                            <h4 class="text-sm font-bold {{ in_array($laporan->status, ['ditugaskan', 'sedang_dikerjakan', 'selesai']) ? 'text-gray-900' : 'text-gray-400' }}">Teknisi Ditugaskan</h4>
                            <p class="text-xs text-gray-400">Belum diproses</p>
                        </div>
                    </div>
                    
                    <!-- Step 4 -->
                    <div class="flex gap-4 relative">
                        <div class="absolute top-6 left-2.5 w-px h-10 bg-gray-200"></div>
                        <div class="w-5 h-5 rounded-full {{ in_array($laporan->status, ['sedang_dikerjakan', 'selesai']) ? 'bg-blue-600 text-white' : 'bg-white border-2 border-gray-300' }} flex items-center justify-center relative z-10 mt-0.5">
                            @if(in_array($laporan->status, ['sedang_dikerjakan', 'selesai']))
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            @endif
                        </div>
                        <div>
                            <h4 class="text-sm font-bold {{ in_array($laporan->status, ['sedang_dikerjakan', 'selesai']) ? 'text-gray-900' : 'text-gray-400' }}">Dalam Penanganan</h4>
                            <p class="text-xs text-gray-400">Belum diproses</p>
                        </div>
                    </div>

                    <!-- Step 5 -->
                    <div class="flex gap-4">
                        <div class="w-5 h-5 rounded-full {{ $laporan->status == 'selesai' ? 'bg-blue-600 text-white' : 'bg-white border-2 border-gray-300' }} flex items-center justify-center relative z-10 mt-0.5">
                            @if($laporan->status == 'selesai')
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            @endif
                        </div>
                        <div>
                            <h4 class="text-sm font-bold {{ $laporan->status == 'selesai' ? 'text-gray-900' : 'text-gray-400' }}">Selesai</h4>
                            <p class="text-xs text-gray-400">Belum diproses</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tugaskan Teknisi -->
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <h2 class="text-lg font-bold text-gray-900 mb-4">Tugaskan Teknisi</h2>
                
                @if($laporan->penanganan)
                    <div class="p-4 bg-blue-50 rounded-xl border border-blue-100 mb-4">
                        <div class="text-sm font-medium text-blue-900 mb-1">Ditugaskan Kepada:</div>
                        <div class="font-bold text-blue-800 flex items-center gap-2">
                            <div class="w-6 h-6 rounded-full bg-blue-200 text-blue-700 flex items-center justify-center text-xs">
                                {{ substr($laporan->penanganan->teknisi?->nama_lengkap ?? 'T', 0, 1) }}
                            </div>
                            {{ $laporan->penanganan->teknisi?->nama_lengkap ?? '-' }}
                        </div>
                        <div class="text-xs text-blue-600 mt-2 font-medium">Status: {{ $laporan->penanganan->status_label }}</div>
                    </div>
                @else
                    @if($teknisiList->isEmpty())
                        <p class="text-sm text-gray-500 p-4 bg-gray-50 rounded-xl text-center border border-gray-100">Tidak ada teknisi yang tersedia.</p>
                    @else
                        <form method="POST" action="{{ route('laporan.assign', $laporan->formulir_id) }}">
                            @csrf
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Pilih Teknisi Tersedia</label>
                                <div class="relative">
                                    <select name="teknisi_id" class="w-full appearance-none bg-gray-50 border border-gray-200 text-gray-700 py-3 px-4 rounded-xl leading-tight focus:outline-none focus:bg-white focus:border-blue-500 font-medium text-sm transition-colors cursor-pointer" required>
                                        <option value="">— Pilih Teknisi —</option>
                                        @foreach($teknisiList as $teknisi)
                                        <option value="{{ $teknisi->user_id }}">
                                            {{ $teknisi->nama_lengkap }} ({{ $teknisi->unit_jurusan ?? '-' }})
                                        </option>
                                        @endforeach
                                    </select>
                                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-500">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                    </div>
                                </div>
                                <div class="mt-3 flex items-center gap-2 text-xs font-medium text-blue-600 bg-blue-50 px-3 py-2 rounded-lg w-max border border-blue-100">
                                    <span class="w-2 h-2 rounded-full bg-blue-600"></span>
                                    <span>{{ count($teknisiList) }} Teknisi Tersedia</span>
                                </div>
                            </div>
                            <button type="submit" class="w-full bg-blue-700 hover:bg-blue-800 text-white font-semibold py-3 px-4 rounded-xl shadow-sm transition-all flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                                Assign Teknisi
                            </button>
                        </form>
                    @endif
                @endif
            </div>

            <!-- Tindakan Cepat -->
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <h2 class="text-lg font-bold text-gray-900 mb-4">Tindakan Cepat</h2>
                <div class="grid grid-cols-2 gap-3">
                    <button class="flex flex-col items-center justify-center gap-2 p-4 rounded-xl border border-gray-200 hover:border-blue-500 hover:bg-blue-50 hover:text-blue-700 transition-all text-gray-600">
                        <div class="w-10 h-10 rounded-full bg-gray-50 flex items-center justify-center text-blue-600 mb-1">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                        </div>
                        <span class="text-xs font-bold text-gray-800">Ubah Status</span>
                    </button>
                    <a href="{{ route('berita-acara.generate', $laporan->formulir_id) }}" target="_blank" class="flex flex-col items-center justify-center gap-2 p-4 rounded-xl border border-gray-200 hover:border-blue-500 hover:bg-blue-50 hover:text-blue-700 transition-all text-gray-600">
                        <div class="w-10 h-10 rounded-full bg-gray-50 flex items-center justify-center text-blue-600 mb-1">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                        </div>
                        <span class="text-xs font-bold text-gray-800">Cetak</span>
                    </a>
                    
                    <button type="button" class="col-span-1 h-full flex flex-col items-center justify-center gap-2 p-4 rounded-xl border border-red-100 bg-red-50 text-red-600 hover:bg-red-100 hover:border-red-200 transition-all" onclick="alert('Fitur Tolak Laporan belum tersedia (API belum dibuat).')">
                        <div class="w-10 h-10 rounded-full bg-white flex items-center justify-center text-red-600 mb-1 shadow-sm">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </div>
                        <span class="text-xs font-bold">Tolak Laporan</span>
                    </button>
                    
                    <a href="mailto:{{ $laporan->pelapor?->email ?? '' }}" class="flex flex-col items-center justify-center gap-2 p-4 rounded-xl border border-gray-200 hover:border-blue-500 hover:bg-blue-50 hover:text-blue-700 transition-all text-gray-600">
                        <div class="w-10 h-10 rounded-full bg-gray-50 flex items-center justify-center text-blue-600 mb-1">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                        </div>
                        <span class="text-xs font-bold text-gray-800">Hubungi</span>
                    </a>
                </div>
            </div>

        </div>

    </div>
@endsection
