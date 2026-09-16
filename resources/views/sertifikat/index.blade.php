@extends('layouts.sim')

@section('title', 'Sertifikat Siswa PKL')
@section('page-title', 'Sertifikat Praktik Kerja Lapangan (PKL)')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <p class="text-sm text-slate-500">Penerbitan, verifikasi kelulusan PKL, dan cetak sertifikat resmi siswa.</p>
        </div>
        @if(!auth()->user()->isSiswa())
        <a href="{{ route('sertifikat.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-[#0A4DBA] hover:bg-blue-700 text-white text-sm font-semibold shadow-lg shadow-blue-600/30 transition-all">
            <span>+</span> Terbitkan Data Sertifikat
        </a>
        @endif
    </div>

    <!-- Filter & Search -->
    <div class="bg-white rounded-2xl p-4 border border-slate-200/80 shadow-sm">
        <form method="GET" action="{{ route('sertifikat.index') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 items-center">
            <div class="lg:col-span-2">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari Nama Siswa, NISN, atau No. Sertifikat..."
                       class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-blue-500 outline-none">
            </div>

            <div>
                <select name="status" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                    <option value="">Semua Status</option>
                    <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                    <option value="terverifikasi" {{ request('status') == 'terverifikasi' ? 'selected' : '' }}>Terverifikasi</option>
                    <option value="diterbitkan" {{ request('status') == 'diterbitkan' ? 'selected' : '' }}>Diterbitkan</option>
                </select>
            </div>

            <div class="flex items-center gap-2">
                <button type="submit" class="flex-1 py-2.5 px-4 rounded-xl bg-blue-600 hover:bg-blue-500 text-white text-sm font-semibold transition">
                    Filter
                </button>
                <a href="{{ route('sertifikat.index') }}" class="p-2.5 rounded-xl border border-slate-200 hover:bg-slate-50 text-slate-500">Reset</a>
            </div>
        </form>
    </div>

    <!-- Tabel Data Sertifikat -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50/80 border-b border-slate-200 text-slate-500 uppercase tracking-wider font-semibold">
                    <tr>
                        <th class="py-3.5 px-4">No. Sertifikat</th>
                        <th class="py-3.5 px-4">Nama Siswa / NISN</th>
                        <th class="py-3.5 px-4">Kelas & Jurusan</th>
                        <th class="py-3.5 px-4">Mitra DUDI</th>
                        <th class="py-3.5 px-4 text-center">Nilai</th>
                        <th class="py-3.5 px-4 text-center">Status</th>
                        <th class="py-3.5 px-4 text-center w-28">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse($sertifikats as $s)
                        <tr class="hover:bg-blue-50/30 transition">
                            <td class="py-3.5 px-4 font-mono font-semibold text-blue-600">
                                {{ $s->no_sertifikat ?? '-' }}
                            </td>
                            <td class="py-3.5 px-4">
                                <div class="font-bold text-slate-800">{{ $s->nama_siswa }}</div>
                                <div class="text-[11px] text-slate-400">NISN: {{ $s->nisn }}</div>
                            </td>
                            <td class="py-3.5 px-4">
                                <span class="font-medium text-slate-700">{{ $s->kelas }}</span>
                                <span class="text-[11px] text-slate-400 block">{{ $s->program_keahlian }}</span>
                            </td>
                            <td class="py-3.5 px-4 font-medium text-slate-800">
                                {{ $s->industri->nama_industri ?? '-' }}
                            </td>
                            <td class="py-3.5 px-4 text-center">
                                <span class="font-bold text-slate-800">{{ $s->nilai ?? '-' }}</span>
                                <span class="text-[10px] text-slate-400 block">{{ $s->predikat ?? '' }}</span>
                            </td>
                            <td class="py-3.5 px-4 text-center">
                                @if($s->status === 'diterbitkan')
                                    <span class="px-2.5 py-1 rounded-full text-[11px] font-semibold bg-emerald-100 text-emerald-700">Diterbitkan</span>
                                @elseif($s->status === 'terverifikasi')
                                    <span class="px-2.5 py-1 rounded-full text-[11px] font-semibold bg-blue-100 text-blue-700">Terverifikasi</span>
                                @else
                                    <span class="px-2.5 py-1 rounded-full text-[11px] font-semibold bg-slate-100 text-slate-600">Draft</span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 text-center">
                                <div class="flex items-center justify-center gap-1.5">
                                    <a href="{{ route('sertifikat.show', $s) }}" class="p-1.5 rounded-lg bg-blue-50 text-blue-600 hover:bg-blue-100" title="Detail">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    </a>
                                    @if($s->status === 'diterbitkan')
                                        <a href="{{ route('sertifikat.pdf', $s) }}" target="_blank" class="p-1.5 rounded-lg bg-rose-50 text-rose-600 hover:bg-rose-100" title="Unduh Cetak PDF">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                                        </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-8 text-center text-slate-400">Belum ada data sertifikat siswa.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($sertifikats->hasPages())
            <div class="p-4 border-t border-slate-100">
                {{ $sertifikats->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
