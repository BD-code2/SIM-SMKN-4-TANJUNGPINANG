@extends('layouts.sim')

@section('title', 'Daftar Surat Masuk')
@section('page-title', 'Buku Agenda Surat Masuk')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <p class="text-sm text-slate-500">Pencatatan surat masuk, pembuatan nomor agenda otomatis, dan disposisi.</p>
        </div>
        <a href="{{ route('surat-masuk.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-[#0A4DBA] hover:bg-blue-700 text-white text-sm font-semibold shadow-lg shadow-blue-600/30 transition-all">
            <span>+</span> Catat Surat Masuk
        </a>
    </div>

    <!-- Filter & Search -->
    <div class="bg-white rounded-2xl p-4 border border-slate-200/80 shadow-sm">
        <form method="GET" action="{{ route('surat-masuk.index') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 items-center">
            <div class="lg:col-span-2">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari No. Agenda, No. Surat, Pengirim, atau Perihal..."
                       class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-blue-500 outline-none">
            </div>

            <div>
                <select name="status" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                    <option value="">Semua Status</option>
                    <option value="diterima" {{ request('status') == 'diterima' ? 'selected' : '' }}>Diterima</option>
                    <option value="didisposisi" {{ request('status') == 'didisposisi' ? 'selected' : '' }}>Didisposisi</option>
                    <option value="diproses" {{ request('status') == 'diproses' ? 'selected' : '' }}>Diproses</option>
                    <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                    <option value="diarsipkan" {{ request('status') == 'diarsipkan' ? 'selected' : '' }}>Diarsipkan</option>
                </select>
            </div>

            <div class="flex items-center gap-2">
                <button type="submit" class="flex-1 py-2.5 px-4 rounded-xl bg-blue-600 hover:bg-blue-500 text-white text-sm font-semibold transition">
                    Filter
                </button>
                <a href="{{ route('surat-masuk.index') }}" class="p-2.5 rounded-xl border border-slate-200 hover:bg-slate-50 text-slate-500">Reset</a>
            </div>
        </form>
    </div>

    <!-- Tabel Data Surat Masuk -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50/80 border-b border-slate-200 text-slate-500 uppercase tracking-wider font-semibold">
                    <tr>
                        <th class="py-3.5 px-4">No. Agenda</th>
                        <th class="py-3.5 px-4">No. Surat & Tgl</th>
                        <th class="py-3.5 px-4">Pengirim</th>
                        <th class="py-3.5 px-4">Perihal</th>
                        <th class="py-3.5 px-4 text-center">Sifat</th>
                        <th class="py-3.5 px-4 text-center">Status</th>
                        <th class="py-3.5 px-4 text-center w-28">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse($suratMasuk as $item)
                        <tr class="hover:bg-blue-50/30 transition">
                            <td class="py-3.5 px-4 font-mono font-semibold text-blue-600">
                                <a href="{{ route('surat-masuk.show', $item) }}">{{ $item->no_agenda }}</a>
                            </td>
                            <td class="py-3.5 px-4">
                                <div class="font-medium text-slate-800">{{ $item->no_surat }}</div>
                                <div class="text-[11px] text-slate-400">Tgl: {{ $item->tanggal_surat->format('d/m/Y') }}</div>
                            </td>
                            <td class="py-3.5 px-4 font-medium text-slate-800">{{ $item->pengirim }}</td>
                            <td class="py-3.5 px-4 text-slate-600 max-w-xs truncate">{{ $item->perihal }}</td>
                            <td class="py-3.5 px-4 text-center">
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold {{ $item->sifat === 'segera' ? 'bg-rose-100 text-rose-700' : ($item->sifat === 'rahasia' ? 'bg-purple-100 text-purple-700' : 'bg-slate-100 text-slate-600') }}">
                                    {{ ucfirst($item->sifat) }}
                                </span>
                            </td>
                            <td class="py-3.5 px-4 text-center">
                                <span class="px-2.5 py-1 rounded-full text-[11px] font-semibold {{ $item->status === 'selesai' ? 'bg-emerald-100 text-emerald-700' : ($item->status === 'didisposisi' ? 'bg-blue-100 text-blue-700' : 'bg-amber-100 text-amber-700') }}">
                                    {{ ucfirst($item->status) }}
                                </span>
                            </td>
                            <td class="py-3.5 px-4 text-center">
                                <div class="flex items-center justify-center gap-1.5">
                                    <a href="{{ route('surat-masuk.show', $item) }}" class="p-1.5 rounded-lg bg-blue-50 text-blue-600 hover:bg-blue-100" title="Detail & Disposisi">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    </a>
                                    <a href="{{ route('surat-keluar.create', ['referensi_id' => $item->id]) }}" class="p-1.5 rounded-lg bg-emerald-50 text-emerald-600 hover:bg-emerald-100" title="Balas dengan Surat Keluar">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"></path></svg>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-8 text-center text-slate-400">Belum ada data surat masuk.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($suratMasuk->hasPages())
            <div class="p-4 border-t border-slate-100">
                {{ $suratMasuk->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
