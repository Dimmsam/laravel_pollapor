@extends('layouts.admin')
@section('title', 'Validasi Eskalasi — PolLapor')

@section('content')
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Validasi Eskalasi</h1>
            <p class="text-sm text-gray-500 mt-1">Daftar laporan yang diajukan eskalasi oleh teknisi lapangan</p>
        </div>
        <div class="bg-orange-50 text-orange-700 px-4 py-2 rounded-lg text-sm font-bold border border-orange-100 flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
            {{ $laporans->total() }} Menunggu Validasi
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm whitespace-nowrap">
                <thead class="bg-gray-50/50 text-gray-500 font-medium border-b border-gray-100">
                    <tr>
                        <th class="px-6 py-4">ID Laporan</th>
                        <th class="px-6 py-4">Informasi Sarana</th>
                        <th class="px-6 py-4">Dikelola Oleh</th>
                        <th class="px-6 py-4">Alasan Eskalasi</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($laporans as $laporan)
                    <tr class="hover:bg-gray-50/50 transition-colors group">
                        <td class="px-6 py-4">
                            <span class="font-mono text-xs font-medium text-gray-500 bg-gray-100 px-2 py-1 rounded">{{ substr($laporan->formulir_id, 0, 8) }}</span>
                            <div class="text-[10px] text-gray-400 mt-1">{{ $laporan->updated_at?->format('d M Y') }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="font-bold text-gray-900">{{ $laporan->nama_sarana }}</div>
                            <div class="text-xs text-gray-500 flex items-center gap-1 mt-0.5">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                {{ $laporan->lokasi?->nama_ruangan ?? '-' }}
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <div class="w-6 h-6 rounded-full bg-blue-100 text-blue-700 flex items-center justify-center text-[10px] font-bold">
                                    {{ substr($laporan->penanganan?->teknisi?->nama_lengkap ?? 'T', 0, 1) }}
                                </div>
                                <span class="font-medium text-gray-700">{{ $laporan->penanganan?->teknisi?->nama_lengkap ?? '-' }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 max-w-xs">
                            <p class="text-gray-500 truncate" title="{{ $laporan->penanganan?->catatan_progres }}">{{ $laporan->penanganan?->catatan_progres ?? '-' }}</p>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('eskalasi.show', $laporan->formulir_id) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-orange-50 text-orange-700 rounded-lg text-sm font-bold hover:bg-orange-600 hover:text-white transition-colors">
                                Review
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center">
                            <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-3 text-gray-400">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            </div>
                            <h3 class="text-gray-900 font-medium">Semua Aman!</h3>
                            <p class="text-sm text-gray-500 mt-1">Tidak ada laporan yang diajukan untuk eskalasi saat ini.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if($laporans->hasPages())
    <div class="mt-6">
        {{ $laporans->links('pagination::tailwind') }}
    </div>
    @endif
@endsection
