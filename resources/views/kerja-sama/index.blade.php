@extends('layouts.sim')

@section('title', 'Kerja Sama Industri')
@section('page-title', 'Kerja Sama Industri')

@section('content')
<div class="space-y-6">
    <!-- Subtitle & Tombol Tambah Kerja Sama Sesuai Mockup -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <p class="text-sm text-slate-500">Kelola mitra, masa berlaku, dan status kerja sama industri.</p>
        </div>
        <a href="{{ route('kerja-sama.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-[#0A4DBA] hover:bg-blue-700 text-white text-sm font-semibold shadow-lg shadow-blue-600/30 transition-all">
            <span>+</span> Tambah Kerja Sama
        </a>
    </div>

    <!-- 4 Stats Cards Persis Seperti di Mockup -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        <!-- Total Kerja Sama -->
        <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-slate-500">Total Kerja Sama</p>
                <h3 class="text-3xl font-extrabold text-slate-800 mt-1">{{ $stats['total'] }}</h3>
                <span class="text-xs text-slate-400 font-medium mt-0.5 inline-block">Semua mitra</span>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-blue-600 text-white flex items-center justify-center shadow-md shadow-blue-600/30">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
            </div>
        </div>

        <!-- Aktif -->
        <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-slate-500">Aktif</p>
                <h3 class="text-3xl font-extrabold text-slate-800 mt-1">{{ $stats['aktif'] }}</h3>
                <span class="text-xs text-emerald-600 font-medium mt-0.5 inline-block">Lihat aktif</span>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-emerald-500 text-white flex items-center justify-center shadow-md shadow-emerald-500/30">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            </div>
        </div>

        <!-- Akan Berakhir -->
        <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-slate-500">Akan Berakhir</p>
                <h3 class="text-3xl font-extrabold text-slate-800 mt-1">{{ $stats['akan_berakhir'] }}</h3>
                <span class="text-xs text-amber-600 font-medium mt-0.5 inline-block">Perlu perhatian</span>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-amber-500 text-white flex items-center justify-center shadow-md shadow-amber-500/30">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
            </div>
        </div>

        <!-- Berakhir -->
        <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-slate-500">Berakhir</p>
                <h3 class="text-3xl font-extrabold text-slate-800 mt-1">{{ $stats['berakhir'] }}</h3>
                <span class="text-xs text-slate-400 font-medium mt-0.5 inline-block">Arsip</span>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-purple-600 text-white flex items-center justify-center shadow-md shadow-purple-600/30">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
            </div>
        </div>
    </div>

    <!-- Filter Bar Sesuai Desain Mockup -->
    <div class="bg-white rounded-2xl p-4 border border-slate-200/80 shadow-sm">
        <form method="GET" action="{{ route('kerja-sama.index') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3 items-center">
            <!-- Cari nama industri -->
            <div class="lg:col-span-2 relative">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama industri..."
                       class="w-full pl-4 pr-10 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none">
            </div>

            <!-- Filter Status -->
            <div>
                <select name="status" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none">
                    <option value="">Semua Status</option>
                    <option value="aktif" {{ request('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="akan_berakhir" {{ request('status') == 'akan_berakhir' ? 'selected' : '' }}>Akan Berakhir</option>
                    <option value="berakhir" {{ request('status') == 'berakhir' ? 'selected' : '' }}>Berakhir</option>
                </select>
            </div>

            <!-- Filter Program Keahlian -->
            <div>
                <select name="program_keahlian" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none">
                    <option value="">Semua Program Keahlian</option>
                    <option value="TKJ" {{ request('program_keahlian') == 'TKJ' ? 'selected' : '' }}>TKJ</option>
                    <option value="RPL" {{ request('program_keahlian') == 'RPL' ? 'selected' : '' }}>RPL</option>
                    <option value="Akuntansi" {{ request('program_keahlian') == 'Akuntansi' ? 'selected' : '' }}>Akuntansi</option>
                </select>
            </div>

            <!-- Tombol Filter & Reset -->
            <div class="flex items-center gap-2">
                <button type="submit" class="flex-1 py-2.5 px-4 rounded-xl bg-blue-600 hover:bg-blue-500 text-white text-sm font-semibold transition">
                    Filter
                </button>
                <a href="{{ route('kerja-sama.index') }}" class="p-2.5 rounded-xl border border-slate-200 hover:bg-slate-50 text-slate-500" title="Reset Filter">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                </a>
            </div>
        </form>
    </div>

    <!-- Tabel Data Kerja Sama Industri Persis Seperti Mockup -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50/80 border-b border-slate-200 text-slate-500 uppercase tracking-wider font-semibold">
                    <tr>
                        <th class="py-3.5 px-4 w-12 text-center">No</th>
                        <th class="py-3.5 px-4">Nama Industri</th>
                        <th class="py-3.5 px-4">Alamat</th>
                        <th class="py-3.5 px-4">Kontak</th>
                        <th class="py-3.5 px-4">Program Keahlian</th>
                        <th class="py-3.5 px-4">Mulai</th>
                        <th class="py-3.5 px-4">Berakhir</th>
                        <th class="py-3.5 px-4 text-center">Status</th>
                        <th class="py-3.5 px-4 text-center w-28">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse($industris as $index => $item)
                        <tr class="hover:bg-blue-50/30 transition">
                            <td class="py-3.5 px-4 text-center font-medium">{{ $industris->firstItem() + $index }}</td>
                            <td class="py-3.5 px-4 font-semibold text-slate-800">
                                <a href="{{ route('kerja-sama.show', $item) }}" class="hover:text-blue-600">
                                    {{ $item->nama_industri }}
                                </a>
                            </td>
                            <td class="py-3.5 px-4 text-slate-500 max-w-xs truncate">{{ $item->alamat }}</td>
                            <td class="py-3.5 px-4 font-mono">{{ $item->kontak ?? '-' }}</td>
                            <td class="py-3.5 px-4">
                                <span class="px-2 py-0.5 rounded-md bg-slate-100 text-slate-700 font-semibold">{{ $item->program_keahlian }}</span>
                            </td>
                            <td class="py-3.5 px-4">{{ $item->tanggal_mulai->format('d/m/Y') }}</td>
                            <td class="py-3.5 px-4">{{ $item->tanggal_berakhir->format('d/m/Y') }}</td>
                            <td class="py-3.5 px-4 text-center">
                                @if($item->status === 'aktif')
                                    <span class="px-2.5 py-1 rounded-full text-[11px] font-semibold bg-emerald-100 text-emerald-700">Aktif</span>
                                @elseif($item->status === 'akan_berakhir')
                                    <span class="px-2.5 py-1 rounded-full text-[11px] font-semibold bg-amber-100 text-amber-700">Akan Berakhir</span>
                                @else
                                    <span class="px-2.5 py-1 rounded-full text-[11px] font-semibold bg-rose-100 text-rose-700">Berakhir</span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 text-center">
                                <div class="flex items-center justify-center gap-1.5">
                                    <a href="{{ route('kerja-sama.show', $item) }}" class="p-1.5 rounded-lg bg-blue-50 text-blue-600 hover:bg-blue-100" title="Detail">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    </a>
                                    <a href="{{ route('kerja-sama.edit', $item) }}" class="p-1.5 rounded-lg bg-amber-50 text-amber-600 hover:bg-amber-100" title="Edit">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="py-8 text-center text-slate-400">Belum ada data kerja sama industri.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($industris->hasPages())
            <div class="p-4 border-t border-slate-100">
                {{ $industris->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
