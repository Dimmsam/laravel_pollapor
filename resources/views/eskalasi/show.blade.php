@extends('layouts.admin')
@section('title', 'Review Eskalasi — PolLapor')

@section('content')
    <div class="mb-6 flex items-center gap-3">
        <a href="{{ route('eskalasi.index') }}" class="p-2 bg-white border border-gray-200 rounded-lg text-gray-500 hover:text-gray-700 hover:bg-gray-50 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Validasi Eskalasi Teknisi</h1>
            <p class="text-sm text-gray-500 mt-1">ID: <span class="font-mono text-gray-900">{{ $laporan->formulir_id }}</span></p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Kolom Kiri: Detail Laporan & Tracking -->
        <div class="lg:col-span-2 space-y-6">
            
            <!-- Detail Card -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50">
                    <h2 class="font-bold text-gray-900">Informasi Fasilitas & Pelapor</h2>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-y-6 gap-x-8">
                        <div>
                            <div class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Nama Sarana</div>
                            <div class="font-medium text-gray-900">{{ $laporan->nama_sarana }}</div>
                        </div>
                        <div>
                            <div class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Lokasi</div>
                            <div class="font-medium text-gray-900">{{ $laporan->lokasi?->nama_ruangan ?? '-' }}</div>
                        </div>
                        <div>
                            <div class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Pelapor</div>
                            <div class="font-medium text-gray-900">{{ $laporan->pelapor?->nama_lengkap ?? '-' }}</div>
                        </div>
                        <div>
                            <div class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Teknisi Bertugas</div>
                            <div class="font-medium text-gray-900">{{ $laporan->penanganan?->teknisi?->nama_lengkap ?? '-' }}</div>
                        </div>
                        <div class="md:col-span-2">
                            <div class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Keterangan Kerusakan Awal</div>
                            <div class="text-sm text-gray-700 bg-gray-50 p-3 rounded-lg border border-gray-100">{{ $laporan->keterangan_kerusakan }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Alasan Eskalasi -->
            <div class="bg-orange-50 rounded-2xl shadow-sm border border-orange-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-orange-200/50 bg-orange-100/50 flex items-center gap-2">
                    <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    <h2 class="font-bold text-orange-900">Alasan Eskalasi dari Teknisi</h2>
                </div>
                <div class="p-6">
                    <p class="text-orange-800 text-sm font-medium leading-relaxed mb-4">
                        "{{ $laporan->penanganan?->catatan_progres ?? 'Tidak ada catatan.' }}"
                    </p>

                    @if($laporan->penanganan?->foto_progres_url)
                    <div class="mt-4 pt-4 border-t border-orange-200/50">
                        <div class="text-[10px] font-bold text-orange-700 uppercase tracking-wider mb-3">Foto Bukti Lapangan</div>
                        <div class="flex gap-3 overflow-x-auto pb-2">
                            @foreach($laporan->penanganan->foto_progres_url as $foto)
                            <a href="{{ $foto }}" target="_blank" class="block shrink-0 relative group">
                                <img src="{{ $foto }}" class="w-32 h-24 object-cover rounded-xl border border-orange-200 shadow-sm group-hover:shadow-md transition-all">
                                <div class="absolute inset-0 bg-black/0 group-hover:bg-black/10 transition-colors rounded-xl flex items-center justify-center">
                                    <svg class="w-6 h-6 text-white opacity-0 group-hover:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                </div>
                            </a>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Tracking Timeline -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50">
                    <h2 class="font-bold text-gray-900">Riwayat Laporan</h2>
                </div>
                <div class="p-6">
                    <div class="relative border-l border-gray-200 ml-3 space-y-8">
                        @forelse($laporan->trackings as $track)
                        <div class="relative pl-6">
                            <div class="absolute -left-[21px] top-1 w-10 h-10 rounded-full border-4 border-white bg-blue-100 text-blue-600 flex items-center justify-center shadow-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <div>
                                <div class="flex items-center gap-2 mb-1">
                                    <span class="font-bold text-gray-900 text-sm">{{ $track->aktor?->nama_lengkap ?? 'System' }}</span>
                                    <span class="text-[10px] text-gray-400 font-medium">{{ $track->created_at?->format('d M Y, H:i') }}</span>
                                </div>
                                <p class="text-xs text-gray-600 bg-gray-50 p-3 rounded-lg border border-gray-100 inline-block mt-1">{{ $track->pesan_narasi }}</p>
                            </div>
                        </div>
                        @empty
                        <p class="text-sm text-gray-500 text-center ml-[-12px]">Belum ada riwayat aktivitas.</p>
                        @endforelse
                    </div>
                </div>
            </div>

        </div>

        <!-- Kolom Kanan: Aksi Validasi -->
        <div class="space-y-6">
            
            <!-- Panel Teruskan Kajur -->
            <div class="bg-white rounded-2xl shadow-lg border border-orange-200 overflow-hidden sticky top-24 relative">
                <!-- Decorative top line -->
                <div class="h-1.5 w-full bg-gradient-to-r from-orange-400 to-amber-500"></div>
                
                <div class="p-6">
                    <div class="w-12 h-12 bg-orange-100 rounded-full flex items-center justify-center text-orange-600 mb-4 shadow-inner">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    
                    <h2 class="text-lg font-extrabold text-gray-900 mb-2">Teruskan ke Kajur</h2>
                    <p class="text-sm text-gray-500 mb-6 leading-relaxed">
                        Jika Anda setuju bahwa masalah ini membutuhkan perhatian khusus, teruskan laporan ini ke <strong>Kepala Jurusan</strong> untuk meminta persetujuan.
                    </p>

                    <form method="POST" action="{{ route('eskalasi.teruskan', $laporan->formulir_id) }}">
                        @csrf
                        <div class="mb-6">
                            <label class="block text-[11px] font-bold text-gray-700 uppercase tracking-wider mb-2">Catatan Admin <span class="text-gray-400 normal-case font-normal">(Opsional)</span></label>
                            <textarea name="catatan" rows="3" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-orange-500 focus:bg-white transition-all resize-none" placeholder="Tambahkan catatan untuk dibaca Kajur..."></textarea>
                        </div>
                        
                        <button type="submit" class="w-full flex items-center justify-center gap-2 py-3.5 bg-orange-500 hover:bg-orange-600 text-white rounded-xl text-sm font-bold shadow-md shadow-orange-200 transition-all transform hover:-translate-y-0.5" onclick="return confirm('Yakin ingin meneruskan eskalasi ini ke Kepala Jurusan?')">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 11l7-7 7 7M5 19l7-7 7 7"></path></svg>
                            Teruskan ke Kajur
                        </button>
                    </form>
                </div>
            </div>
            
            <!-- Panel Tolak -->
            <div class="bg-white rounded-2xl shadow-sm border border-red-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-red-100 bg-red-50 flex items-center gap-2">
                    <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    <h2 class="font-bold text-red-900">Tolak Eskalasi</h2>
                </div>
                <div class="p-6">
                    <p class="text-sm text-gray-500 mb-4 leading-relaxed">
                        Jika eskalasi dirasa tidak tepat, kembalikan laporan ke teknisi yang bersangkutan untuk diselesaikan.
                    </p>

                    <form method="POST" action="{{ route('eskalasi.tolak', $laporan->formulir_id) }}">
                        @csrf
                        <div class="mb-4">
                            <label class="block text-[11px] font-bold text-gray-700 uppercase tracking-wider mb-2">Alasan Penolakan <span class="text-red-500">*</span></label>
                            <textarea name="alasan_tolak" rows="3" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-red-500 focus:bg-white transition-all resize-none" placeholder="Jelaskan alasan penolakan agar teknisi paham..." required></textarea>
                        </div>
                        
                        <button type="submit" class="w-full py-3 bg-red-50 hover:bg-red-600 text-red-600 hover:text-white rounded-xl text-sm font-bold border border-red-200 hover:border-red-600 transition-colors" onclick="return confirm('Apakah Anda yakin ingin menolak eskalasi ini dan mengembalikannya ke Teknisi?')">
                            Kembalikan ke Teknisi
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>
@endsection
