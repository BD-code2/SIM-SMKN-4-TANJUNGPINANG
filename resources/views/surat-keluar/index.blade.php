@extends('layouts.sim')

@section('title', 'Daftar Surat Keluar')
@section('page-title', 'Buku Agenda Surat Keluar')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <p class="text-sm text-slate-500">Konsep surat, persetujuan Kepala Sekolah, generate nomor surat otomatis & cetak PDF.</p>
        </div>
        <a href="{{ route('surat-keluar.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-[#0A4DBA] hover:bg-blue-700 text-white text-sm font-semibold shadow-lg shadow-blue-600/30 transition-all">
            <span>+</span> Buat Konsep Surat
        </a>
    </div>

    <!-- Filter & Search -->
    <div class="bg-white rounded-2xl p-4 border border-slate-200/80 shadow-sm">
        <form method="GET" action="{{ route('surat-keluar.index') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 items-center">
            <div class="lg:col-span-2">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari No. Surat, Tujuan, atau Perihal..."
                       class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-blue-500 outline-none">
            </div>

            <div>
                <select name="status" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                    <option value="">Semua Status</option>
                    <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                    <option value="menunggu_persetujuan" {{ request('status') == 'menunggu_persetujuan' ? 'selected' : '' }}>Menunggu Persetujuan</option>
                    <option value="disetujui" {{ request('status') == 'disetujui' ? 'selected' : '' }}>Disetujui</option>
                    <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak (Revisi)</option>
                    <option value="dikirim" {{ request('status') == 'dikirim' ? 'selected' : '' }}>Dikirim</option>
                    <option value="diarsipkan" {{ request('status') == 'diarsipkan' ? 'selected' : '' }}>Diarsipkan</option>
                </select>
            </div>

            <div class="flex items-center gap-2">
                <button type="submit" class="flex-1 py-2.5 px-4 rounded-xl bg-blue-600 hover:bg-blue-500 text-white text-sm font-semibold transition">
                    Filter
                </button>
                <a href="{{ route('surat-keluar.index') }}" class="p-2.5 rounded-xl border border-slate-200 hover:bg-slate-50 text-slate-500">Reset</a>
            </div>
        </form>
    </div>

    <!-- Tabel Data Surat Keluar -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50/80 border-b border-slate-200 text-slate-500 uppercase tracking-wider font-semibold">
                    <tr>
                        <th class="py-3.5 px-4">No. Surat</th>
                        <th class="py-3.5 px-4">Tujuan</th>
                        <th class="py-3.5 px-4">Perihal</th>
                        <th class="py-3.5 px-4">Tanggal</th>
                        <th class="py-3.5 px-4 text-center">Status</th>
                        <th class="py-3.5 px-4 text-center w-36">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse($suratKeluar as $item)
                        <tr class="hover:bg-blue-50/30 transition">
                            <td class="py-3.5 px-4 font-mono font-semibold text-blue-600">
                                @if($item->no_surat)
                                    <a href="{{ route('surat-keluar.show', $item) }}">{{ $item->no_surat }}</a>
                                @else
                                    <span class="text-slate-400 italic">(Belum generate / Draft)</span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 font-medium text-slate-800">{{ $item->tujuan }}</td>
                            <td class="py-3.5 px-4 text-slate-600 max-w-xs truncate">{{ $item->perihal }}</td>
                            <td class="py-3.5 px-4">{{ $item->tanggal_surat->format('d/m/Y') }}</td>
                            <td class="py-3.5 px-4 text-center">
                                @if($item->status === 'disetujui')
                                    <span class="px-2.5 py-1 rounded-full text-[11px] font-semibold bg-emerald-100 text-emerald-700">Disetujui</span>
                                @elseif($item->status === 'menunggu_persetujuan')
                                    <span class="px-2.5 py-1 rounded-full text-[11px] font-semibold bg-amber-100 text-amber-700">Menunggu Approval</span>
                                @elseif($item->status === 'ditolak')
                                    <span class="px-2.5 py-1 rounded-full text-[11px] font-semibold bg-rose-100 text-rose-700">Ditolak</span>
                                @elseif($item->status === 'dikirim')
                                    <span class="px-2.5 py-1 rounded-full text-[11px] font-semibold bg-blue-100 text-blue-700">Dikirim</span>
                                @else
                                    <span class="px-2.5 py-1 rounded-full text-[11px] font-semibold bg-slate-100 text-slate-600">Draft</span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 text-center">
                                <div class="flex items-center justify-center gap-1.5">
                                    <a href="{{ route('surat-keluar.show', $item) }}" class="p-1.5 rounded-lg bg-blue-50 text-blue-600 hover:bg-blue-100" title="Detail & Approval">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    </a>
                                    @if(in_array($item->status, ['disetujui', 'dikirim', 'diarsipkan']))
                                        <a href="{{ route('surat-keluar.pdf', $item) }}" target="_blank" class="p-1.5 rounded-lg bg-rose-50 text-rose-600 hover:bg-rose-100" title="Cetak PDF">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                                        </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-8 text-center text-slate-400">Belum ada konsep surat keluar.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($suratKeluar->hasPages())
            <div class="p-4 border-t border-slate-100">
                {{ $suratKeluar->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
