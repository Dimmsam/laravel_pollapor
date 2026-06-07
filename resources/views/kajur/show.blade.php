@extends('layouts.admin')
@section('title', 'Review Eskalasi — Kajur')

@section('content')
    <div class="mb-6 flex items-center gap-3">
        <a href="{{ route('kajur.index') }}" class="p-2 bg-white border border-gray-200 rounded-lg text-gray-500 hover:text-gray-700 hover:bg-gray-50 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Review Persetujuan</h1>
            <p class="text-sm text-gray-500 mt-1">ID: <span class="font-mono text-gray-900">{{ $laporan->formulir_id }}</span></p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Kolom Kiri: Detail Laporan & Tracking -->
        <div class="lg:col-span-2 space-y-6">
            
            <!-- Detail Card -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50">
                    <h2 class="font-bold text-gray-900">Informasi Fasilitas</h2>
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
                            <div class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Dikerjakan Oleh (Teknisi)</div>
                            <div class="font-medium text-gray-900">{{ $laporan->penanganan?->teknisi?->nama_lengkap ?? '-' }}</div>
                        </div>
                        <div class="md:col-span-2">
                            <div class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Keterangan Kerusakan Awal</div>
                            <div class="text-sm text-gray-700 bg-gray-50 p-3 rounded-lg border border-gray-100">{{ $laporan->keterangan_kerusakan }}</div>
                        </div>
                        <div class="md:col-span-2">
                            <div class="text-[10px] font-bold text-orange-500 uppercase tracking-wider mb-1">Alasan Eskalasi (Dari Teknisi)</div>
                            <div class="text-sm text-orange-800 bg-orange-50 p-4 rounded-lg border border-orange-100 font-medium">
                                "{{ $laporan->penanganan?->catatan_progres ?? 'Tidak ada catatan' }}"
                            </div>
                        </div>
                    </div>

                    <!-- Photos -->
                    @if($laporan->penanganan?->foto_progres_url)
                    <div class="mt-6 pt-6 border-t border-gray-100">
                        <div class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-3">Foto Kondisi / Bukti</div>
                        <div class="flex gap-3 overflow-x-auto pb-2">
                            @foreach($laporan->penanganan->foto_progres_url as $foto)
                            <a href="{{ $foto }}" target="_blank" class="block shrink-0 relative group">
                                <img src="{{ $foto }}" class="w-32 h-24 object-cover rounded-xl border border-gray-200 shadow-sm group-hover:shadow-md transition-all">
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
                    <h2 class="font-bold text-gray-900">Riwayat Perjalanan Laporan</h2>
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

        <!-- Kolom Kanan: Form Persetujuan -->
        <div>
            <div class="bg-white rounded-2xl shadow-lg border border-green-100 overflow-hidden sticky top-24 relative">
                <!-- Decorative top line -->
                <div class="h-1.5 w-full bg-gradient-to-r from-green-400 to-emerald-600"></div>
                
                <div class="p-6">
                    <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center text-green-600 mb-4 shadow-inner">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    
                    <h2 class="text-lg font-extrabold text-gray-900 mb-2">Persetujuan Eskalasi</h2>
                    <p class="text-sm text-gray-500 mb-6 leading-relaxed">
                        Dengan menyetujui, laporan ini akan diteruskan ke <strong>UPT-PP</strong>. Sistem akan <strong>mengunci laporan ini secara permanen</strong> dari perubahan teknisi maupun pelapor.
                    </p>

                    <form method="POST" action="{{ route('kajur.setujui', $laporan->formulir_id) }}">
                        @csrf
                        <div class="mb-6">
                            <label class="block text-[11px] font-bold text-gray-700 uppercase tracking-wider mb-2">Catatan Kajur <span class="text-gray-400 normal-case font-normal">(Opsional)</span></label>
                            <textarea name="catatan" rows="4" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:bg-white transition-all resize-none" placeholder="Tambahkan instruksi spesifik untuk UPT-PP jika diperlukan..."></textarea>
                        </div>
                        
                        <button type="submit" class="w-full flex items-center justify-center gap-2 py-3.5 bg-green-600 hover:bg-green-700 text-white rounded-xl text-sm font-bold shadow-md shadow-green-200 transition-all transform hover:-translate-y-0.5" onclick="return confirm('Apakah Anda yakin menyetujui eskalasi ini? Laporan akan dikunci permanen.')">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            Setujui & Teruskan
                        </button>
                    </form>
                </div>
            </div>
            
            <div class="mt-6 bg-red-50 rounded-2xl border border-red-100 p-6 text-center">
                <p class="text-xs text-red-600 font-medium mb-3">Tolak jika dirasa laporan tidak perlu ditangani UPT-PP.</p>
                <button type="button" onclick="document.getElementById('modalTolakKajur').classList.remove('hidden')" class="px-6 py-2 bg-white border border-red-200 text-red-600 rounded-lg text-sm font-bold hover:bg-red-100 transition-colors w-full">Tolak Eskalasi</button>
            </div>
        </div>
    </div>

    <!-- Modal Tolak Eskalasi (Kajur) -->
    <div id="modalTolakKajur" class="fixed inset-0 z-50 hidden bg-gray-900 bg-opacity-50 overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
            <!-- Background overlay for clicking outside -->
            <div class="fixed inset-0 transition-opacity" aria-hidden="true" onclick="document.getElementById('modalTolakKajur').classList.add('hidden')"></div>

            <div class="relative bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:max-w-lg w-full">
                <form action="{{ route('kajur.tolak', $laporan->formulir_id) }}" method="POST">
                    @csrf
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                    Tolak Eskalasi
                                </h3>
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500">
                                        Anda yakin ingin menolak eskalasi laporan ini? Laporan akan dikembalikan ke teknisi dan statusnya menjadi <span class="font-bold">Eskalasi Ditolak</span>.
                                    </p>
                                    <div class="mt-4">
                                        <label for="alasan_tolak" class="block text-sm font-medium text-gray-700">Alasan Penolakan <span class="text-red-500">*</span></label>
                                        <textarea id="alasan_tolak" name="alasan_tolak" rows="3" required class="mt-1 shadow-sm focus:ring-red-500 focus:border-red-500 block w-full sm:text-sm border-gray-300 rounded-md" placeholder="Tuliskan alasan penolakan..."></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse border-t border-gray-100">
                        <button type="submit" class="w-full inline-flex justify-center rounded-lg border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm transition-colors">
                            Tolak Eskalasi
                        </button>
                        <button type="button" onclick="document.getElementById('modalTolakKajur').classList.add('hidden')" class="mt-3 w-full inline-flex justify-center rounded-lg border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm transition-colors">
                            Batal
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
