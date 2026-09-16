@extends('layouts.sim')

@section('title', 'Agenda Sekolah')
@section('page-title', 'Agenda & Jadwal Kegiatan Sekolah')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <p class="text-sm text-slate-500">Kelola agenda rapat guru, kegiatan supervisi, batas waktu pengumpulan berkas, dsb.</p>
        </div>
        <a href="{{ route('agenda.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-[#0A4DBA] hover:bg-blue-700 text-white text-sm font-semibold shadow-lg shadow-blue-600/30 transition-all">
            <span>+</span> Tambah Agenda Baru
        </a>
    </div>

    <!-- Filter Bar -->
    <div class="bg-white rounded-2xl p-4 border border-slate-200/80 shadow-sm">
        <form method="GET" action="{{ route('agenda.index') }}" class="grid grid-cols-1 sm:grid-cols-3 gap-3">
            <div class="sm:col-span-2">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari judul, kegiatan, atau lokasi agenda..."
                       class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-blue-500 outline-none">
            </div>
            <div class="flex items-center gap-2">
                <select name="tipe" class="flex-1 px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                    <option value="">Semua Kategori</option>
                    <option value="rapat" {{ request('tipe') == 'rapat' ? 'selected' : '' }}>Rapat</option>
                    <option value="kegiatan" {{ request('tipe') == 'kegiatan' ? 'selected' : '' }}>Kegiatan</option>
                    <option value="deadline" {{ request('tipe') == 'deadline' ? 'selected' : '' }}>Deadline / Batas Waktu</option>
                    <option value="lainnya" {{ request('tipe') == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                </select>
                <button type="submit" class="px-5 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-500 text-white text-sm font-semibold transition">
                    Cari
                </button>
            </div>
        </form>
    </div>

    <!-- Grid List Agenda -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
        @forelse($agendas as $agenda)
            <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-sm hover:shadow-md transition flex flex-col justify-between">
                <div>
                    <div class="flex items-start justify-between gap-3 mb-2">
                        <span class="px-2.5 py-1 rounded-lg text-xs font-bold uppercase tracking-wider {{ $agenda->tipe === 'rapat' ? 'bg-blue-100 text-blue-700' : ($agenda->tipe === 'deadline' ? 'bg-rose-100 text-rose-700' : 'bg-emerald-100 text-emerald-700') }}">
                            {{ $agenda->tipe }}
                        </span>
                        @if($agenda->is_penting)
                            <span class="px-2 py-0.5 rounded-full bg-rose-500 text-white text-[10px] font-bold">Penting</span>
                        @endif
                    </div>
                    <h3 class="text-base font-bold text-slate-800">{{ $agenda->judul }}</h3>
                    <p class="text-xs text-slate-600 mt-2 leading-relaxed">{{ $agenda->deskripsi ?? 'Tidak ada keterangan detail.' }}</p>
                </div>

                <div class="pt-4 mt-4 border-t border-slate-100 flex items-center justify-between text-xs text-slate-500">
                    <div>
                        <span class="block font-semibold text-slate-700">📅 {{ $agenda->tanggal_mulai->format('d M Y') }}</span>
                        @if($agenda->waktu)
                            <span class="block text-[11px] text-slate-400">🕒 {{ substr($agenda->waktu, 0, 5) }} WIB</span>
                        @endif
                    </div>
                    <div>
                        @if($agenda->lokasi)
                            <span class="block text-slate-600 font-medium">📍 {{ $agenda->lokasi }}</span>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-2 py-12 text-center text-slate-400 bg-white rounded-2xl border border-slate-200">
                Belum ada agenda kegiatan yang ditambahkan.
            </div>
        @endforelse
    </div>

    @if($agendas->hasPages())
        <div class="p-4 bg-white rounded-2xl border border-slate-200">
            {{ $agendas->links() }}
        </div>
    @endif
</div>
@endsection
