@extends('layouts.admin')
@section('title', 'Manajemen Teknisi — PolLapor')

@section('content')
    <!-- Topbar & Actions -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Manajemen Teknisi</h1>
            <p class="text-sm text-gray-500 mt-1">Pantau status dan aktivitas teknisi fasilitas kampus</p>
        </div>
        <div class="flex items-center gap-3">
            <button class="flex items-center gap-2 px-4 py-2 border border-blue-600 text-blue-700 bg-white rounded-lg text-sm font-bold hover:bg-blue-50 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                Export Data
            </button>
            <button class="flex items-center gap-2 px-4 py-2 bg-blue-700 text-white rounded-lg text-sm font-bold hover:bg-blue-800 transition-colors shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Tambah Teknisi
            </button>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm relative">
            <div class="flex justify-between items-start mb-4">
                <div class="w-10 h-10 rounded-xl bg-gray-50 flex items-center justify-center text-gray-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                </div>
                <span class="text-[10px] font-bold text-gray-400 uppercase">Total</span>
            </div>
            <div class="text-4xl font-extrabold text-gray-900">{{ $ringkasanTeknisi['total'] }}</div>
            <div class="text-sm font-medium text-gray-500 mt-1">Total Teknisi Terdaftar</div>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm relative">
            <div class="flex justify-between items-start mb-4">
                <div class="w-10 h-10 rounded-xl bg-green-50 flex items-center justify-center text-green-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <span class="text-[10px] font-bold text-green-500 uppercase">Ready</span>
            </div>
            <div class="text-4xl font-extrabold text-green-600">{{ $ringkasanTeknisi['ready'] }}</div>
            <div class="text-sm font-medium text-gray-500 mt-1">Status: Available</div>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm relative">
            <div class="flex justify-between items-start mb-4">
                <div class="w-10 h-10 rounded-xl bg-orange-50 flex items-center justify-center text-orange-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                </div>
                <span class="text-[10px] font-bold text-orange-500 uppercase flex items-center gap-1">
                    <span class="w-1.5 h-1.5 rounded-full bg-orange-500 animate-pulse"></span>
                    Ongoing
                </span>
            </div>
            <div class="text-4xl font-extrabold text-orange-600">{{ $ringkasanTeknisi['busy'] }}</div>
            <div class="text-sm font-medium text-gray-500 mt-1">Status: Busy</div>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm relative">
            <div class="flex justify-between items-start mb-4">
                <div class="w-10 h-10 rounded-xl bg-gray-100 flex items-center justify-center text-gray-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <span class="text-[10px] font-bold text-gray-400 uppercase">Offline</span>
            </div>
            <div class="text-4xl font-extrabold text-gray-400">{{ $ringkasanTeknisi['offline'] }}</div>
            <div class="text-sm font-medium text-gray-400 mt-1">Status: Tidak Aktif</div>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Kolom Kiri: Teknisi Cards (Span 2) -->
        <div class="lg:col-span-2">
            
            <!-- Filters -->
            <div class="flex flex-wrap items-center gap-3 mb-6">
                <div class="relative flex-1 min-w-[200px]">
                    <svg class="w-4 h-4 absolute left-3 top-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    <input type="text" placeholder="Cari teknisi..." class="w-full pl-9 pr-4 py-2 bg-white border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <select class="px-4 py-2 bg-white border border-gray-200 rounded-lg text-sm text-gray-700 focus:outline-none">
                    <option>Semua Status</option>
                    <option>Available</option>
                    <option>Busy</option>
                </select>
                <select class="px-4 py-2 bg-white border border-gray-200 rounded-lg text-sm text-gray-700 focus:outline-none">
                    <option>Semua Keahlian</option>
                </select>
            </div>

            <!-- Cards Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @forelse($teknisiList as $teknisi)
                <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm flex flex-col justify-between">
                    <div>
                        <div class="flex justify-between items-start mb-4">
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-12 rounded-full bg-gradient-to-br from-slate-700 to-slate-900 flex items-center justify-center text-white font-bold text-lg shadow">
                                    {{ substr($teknisi->nama_lengkap, 0, 1) }}
                                </div>
                                <div>
                                    <h3 class="text-sm font-bold text-gray-900">{{ $teknisi->nama_lengkap }}</h3>
                                    <p class="text-xs text-gray-500">{{ $teknisi->unit_jurusan ?? 'Teknisi Umum' }}</p>
                                </div>
                            </div>
                            <span class="px-2 py-1 rounded text-[9px] font-bold uppercase tracking-wider
                                {{ $teknisi->is_busy ? 'bg-orange-50 text-orange-600' : 'bg-green-50 text-green-600' }}">
                                {{ $teknisi->is_busy ? 'BUSY' : 'AVAILABLE' }}
                            </span>
                        </div>

                        <!-- Keahlian Tags -->
                        <div class="flex flex-wrap gap-2 mb-4">
                            @if($teknisi->keahlian)
                                @foreach(explode(',', $teknisi->keahlian) as $tag)
                                    @if(trim($tag) != '')
                                        <span class="px-2 py-1 bg-gray-50 border border-gray-100 rounded text-[10px] font-medium text-gray-600">{{ trim($tag) }}</span>
                                    @endif
                                @endforeach
                            @else
                                <span class="px-2 py-1 bg-gray-50 border border-gray-100 rounded text-[10px] font-medium text-gray-400">Umum</span>
                            @endif
                        </div>
                    </div>

                    <div>
                        <!-- Active Task Info -->
                        @if($teknisi->is_busy && $teknisi->penanganan->isNotEmpty())
                            @php $aktif = $teknisi->penanganan->first(); @endphp
                            <div class="flex items-center gap-1.5 text-orange-600 mb-1">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                <span class="text-xs font-bold">{{ $teknisi->tugas_aktif }} Laporan Aktif</span>
                            </div>
                            <p class="text-[11px] text-gray-500 italic mb-4 truncate">Sedang menangani {{ $aktif->formulirLaporan?->nama_sarana }} di {{ $aktif->formulirLaporan?->lokasi?->nama_ruangan ?? 'ruangan' }}</p>
                            <button class="w-full py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-bold transition-colors">Monitor Aktivitas</button>
                        @else
                            <div class="flex items-center gap-1.5 text-green-600 mb-1">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <span class="text-xs font-bold">0 Laporan Aktif</span>
                            </div>
                            <p class="text-[11px] text-gray-400 italic mb-4">Last seen: 2 jam lalu</p>
                            <button class="w-full py-2 bg-gray-50 hover:bg-gray-100 text-gray-700 rounded-lg text-sm font-bold transition-colors border border-gray-200">Lihat Detail</button>
                        @endif
                    </div>
                </div>
                @empty
                <div class="col-span-2 p-8 text-center bg-white rounded-2xl border border-gray-100">
                    <p class="text-gray-500 text-sm">Belum ada data teknisi terdaftar.</p>
                </div>
                @endforelse
            </div>
        </div>

        <!-- Kolom Kanan: Distribusi, Beban Kerja, Feed -->
        <div class="space-y-6">
            


            <!-- Beban Kerja List -->
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-sm font-bold text-gray-900">Beban Kerja</h2>
                    <a href="#" class="text-xs font-bold text-blue-600">Lihat Semua</a>
                </div>
                
                <div class="space-y-4">
                    @foreach($teknisiList->sortByDesc('tugas_aktif')->take(4) as $t)
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-full bg-orange-50 text-orange-600 flex items-center justify-center text-xs font-bold">
                            {{ substr($t->nama_lengkap, 0, 2) }}
                        </div>
                        <div class="flex-1">
                            <div class="text-xs font-bold text-gray-900">{{ $t->nama_lengkap }}</div>
                            <div class="flex items-center gap-2 mt-1">
                                <div class="flex-1 bg-gray-100 h-1.5 rounded-full overflow-hidden">
                                    @php $percent = $t->tugas_aktif > 0 ? min(100, ($t->tugas_aktif / 5) * 100) : 0; @endphp
                                    <div class="{{ $t->tugas_aktif > 1 ? 'bg-orange-500' : ($t->tugas_aktif == 1 ? 'bg-blue-600' : 'bg-gray-300') }} h-full rounded-full" style="width: {{ $percent }}%"></div>
                                </div>
                                <span class="text-[10px] font-bold text-gray-900 w-3">{{ $t->tugas_aktif }}</span>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Activity Feed -->
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <h2 class="text-sm font-bold text-gray-900 mb-6">Aktivitas Terbaru</h2>
                
                <div class="relative border-l border-gray-100 ml-3 space-y-6">
                    @forelse($aktivitasTerbaru as $aktifitas)
                    <div class="relative pl-6">
                        <div class="absolute -left-[17px] top-1 w-8 h-8 rounded-full border-4 border-white flex items-center justify-center shadow-sm {{ $aktifitas->status_penanganan == 'selesai' ? 'bg-green-500 text-white' : 'bg-orange-500 text-white' }}">
                            @if($aktifitas->status_penanganan == 'selesai')
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            @else
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                            @endif
                        </div>
                        <div>
                            <h4 class="text-xs font-bold text-gray-900">{{ $aktifitas->status_penanganan == 'selesai' ? 'Laporan Selesai' : 'Tugas Baru Diterima' }}</h4>
                            <p class="text-[10px] text-gray-500 mt-1 leading-relaxed">
                                <span class="font-bold">{{ $aktifitas->teknisi->nama_lengkap }}</span> 
                                {{ $aktifitas->status_penanganan == 'selesai' ? 'menyelesaikan perbaikan' : 'memulai penanganan' }} 
                                {{ $aktifitas->formulirLaporan?->nama_sarana }} di {{ $aktifitas->formulirLaporan?->lokasi?->nama_ruangan ?? '-' }}.
                            </p>
                            <span class="text-[9px] text-gray-400 mt-1 block">{{ $aktifitas->updated_at->diffForHumans() }}</span>
                        </div>
                    </div>
                    @empty
                    <p class="text-sm text-gray-500 text-center py-4">Belum ada aktivitas teknisi terbaru.</p>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
@endsection
