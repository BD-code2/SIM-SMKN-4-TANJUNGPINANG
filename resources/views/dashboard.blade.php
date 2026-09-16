@extends('layouts.sim')

@section('title', 'Beranda & Agenda')
@section('page-title', 'Dashboard SIM Sekolah')

@section('content')
<div class="space-y-8">
    <!-- Header Sambutan -->
    <div class="bg-gradient-to-r from-blue-700 via-blue-600 to-indigo-700 rounded-3xl p-8 text-white shadow-xl shadow-blue-700/20 relative overflow-hidden">
        <div class="relative z-10 max-w-2xl">
            <span class="inline-block px-3 py-1 rounded-full bg-white/20 text-xs font-semibold text-blue-100 mb-3">Selamat Datang</span>
            <h1 class="text-2xl sm:text-3xl font-bold tracking-tight mb-2">{{ auth()->user()->name }}</h1>
            <p class="text-blue-100 text-sm leading-relaxed">
                Anda masuk sebagai <strong class="text-white">{{ auth()->user()->role_label }}</strong>. Kelola tata administrasi persuratan, agenda kegiatan sekolah, kemitraan DUDI, dan sertifikasi siswa dalam satu dashboard terintegrasi.
            </p>
        </div>
        <div class="absolute -right-8 -bottom-10 w-64 h-64 bg-white/10 rounded-full blur-2xl"></div>
    </div>

    <!-- 4 Kartu Statistik Ringkasan -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Surat Masuk -->
        <div class="bg-white rounded-2xl p-6 border border-slate-200/80 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Surat Masuk</p>
                <h3 class="text-3xl font-bold text-slate-800 mt-2">{{ $stats['total_surat_masuk'] }}</h3>
                <p class="text-xs text-blue-600 font-medium mt-1">{{ $stats['surat_masuk_baru'] }} menunggu disposisi</p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
            </div>
        </div>

        <!-- Surat Keluar -->
        <div class="bg-white rounded-2xl p-6 border border-slate-200/80 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Surat Keluar</p>
                <h3 class="text-3xl font-bold text-slate-800 mt-2">{{ $stats['total_surat_keluar'] }}</h3>
                <p class="text-xs text-amber-600 font-medium mt-1">{{ $stats['surat_keluar_menunggu'] }} menunggu approval</p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
            </div>
        </div>

        <!-- Kerja Sama Industri -->
        <div class="bg-white rounded-2xl p-6 border border-slate-200/80 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Mitra Industri</p>
                <h3 class="text-3xl font-bold text-slate-800 mt-2">{{ $stats['total_kerja_sama'] }}</h3>
                <p class="text-xs text-emerald-600 font-medium mt-1">{{ $stats['kerja_sama_aktif'] }} MoU aktif</p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
            </div>
        </div>

        <!-- Sertifikat Siswa -->
        <div class="bg-white rounded-2xl p-6 border border-slate-200/80 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Sertifikat PKL</p>
                <h3 class="text-3xl font-bold text-slate-800 mt-2">{{ $stats['total_sertifikat'] }}</h3>
                <p class="text-xs text-indigo-600 font-medium mt-1">Tersimpan di sistem</p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            </div>
        </div>
    </div>

    <!-- Grid 2 Kolom: Agenda Sekolah & Disposisi / Surat Masuk -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Kolom Kiri (2 Span): Agenda Sekolah -->
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-2xl p-6 border border-slate-200/80 shadow-sm">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h2 class="text-lg font-bold text-slate-800">Beranda Agenda Sekolah</h2>
                        <p class="text-xs text-slate-500">Jadwal kegiatan, agenda rapat, dan tenggat waktu SMKN 4</p>
                    </div>
                    <a href="{{ route('agenda.create') }}" class="px-4 py-2 rounded-xl bg-blue-600 hover:bg-blue-500 text-white text-xs font-semibold shadow-sm transition">
                        + Tambah Agenda
                    </a>
                </div>

                <!-- Agenda Hari Ini -->
                <div class="mb-6">
                    <h3 class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-3">Agenda Hari Ini</h3>
                    @if($agendaHariIni->count() > 0)
                        <div class="space-y-3">
                            @foreach($agendaHariIni as $agd)
                                <div class="p-4 rounded-xl border border-blue-100 bg-blue-50/50 flex items-start gap-4">
                                    <div class="w-12 h-12 rounded-xl bg-blue-600 text-white flex flex-col items-center justify-center flex-shrink-0 font-bold">
                                        <span class="text-xs leading-none">{{ $agd->tanggal_mulai->format('M') }}</span>
                                        <span class="text-base leading-none mt-0.5">{{ $agd->tanggal_mulai->format('d') }}</span>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-center gap-2">
                                            <h4 class="text-sm font-semibold text-slate-800 truncate">{{ $agd->judul }}</h4>
                                            @if($agd->is_penting)
                                                <span class="px-2 py-0.5 rounded-full bg-rose-100 text-rose-700 text-[10px] font-bold">Penting</span>
                                            @endif
                                        </div>
                                        <p class="text-xs text-slate-500 mt-1 line-clamp-2">{{ $agd->deskripsi }}</p>
                                        <div class="flex items-center gap-4 text-xs text-slate-400 mt-2">
                                            @if($agd->waktu)
                                                <span>🕒 {{ substr($agd->waktu, 0, 5) }} WIB</span>
                                            @endif
                                            @if($agd->lokasi)
                                                <span>📍 {{ $agd->lokasi }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="p-6 text-center rounded-xl bg-slate-50 border border-dashed border-slate-200 text-xs text-slate-400">
                            Tidak ada agenda terjadwal untuk hari ini.
                        </div>
                    @endif
                </div>

                <!-- Agenda Mendatang -->
                <div>
                    <h3 class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-3">Agenda Mendatang</h3>
                    @if($agendaMendatang->count() > 0)
                        <div class="space-y-2">
                            @foreach($agendaMendatang as $agd)
                                <div class="p-3.5 rounded-xl border border-slate-200/70 hover:bg-slate-50 transition flex items-center justify-between">
                                    <div class="flex items-center gap-3 min-w-0">
                                        <span class="px-2.5 py-1 rounded-lg bg-slate-100 text-slate-600 text-xs font-semibold">
                                            {{ $agd->tanggal_mulai->format('d M Y') }}
                                        </span>
                                        <p class="text-sm font-medium text-slate-800 truncate">{{ $agd->judul }}</p>
                                    </div>
                                    <span class="text-xs text-slate-400 font-medium capitalize">{{ $agd->tipe }}</span>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="p-4 text-center text-xs text-slate-400">Belum ada agenda mendatang lainnya.</div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Kolom Kanan (1 Span): Disposisi Saya & Surat Terbaru -->
        <div class="space-y-6">
            <!-- Disposisi Saya -->
            <div class="bg-white rounded-2xl p-6 border border-slate-200/80 shadow-sm">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-base font-bold text-slate-800">Disposisi Masuk</h2>
                    <span class="px-2.5 py-0.5 rounded-full bg-blue-100 text-blue-700 text-xs font-semibold">
                        {{ $disposisiSaya->count() }} Tugas
                    </span>
                </div>

                @if($disposisiSaya->count() > 0)
                    <div class="space-y-3">
                        @foreach($disposisiSaya as $disp)
                            <div class="p-3 rounded-xl border border-slate-200 bg-slate-50/50">
                                <div class="flex items-center justify-between text-xs mb-1">
                                    <span class="font-semibold text-blue-600">{{ $disp->suratMasuk->no_agenda ?? 'Disposisi' }}</span>
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold {{ $disp->status === 'selesai' ? 'bg-emerald-100 text-emerald-700' : ($disp->status === 'diproses' ? 'bg-amber-100 text-amber-700' : 'bg-slate-200 text-slate-700') }}">
                                        {{ ucfirst($disp->status) }}
                                    </span>
                                </div>
                                <p class="text-xs font-medium text-slate-800">{{ $disp->instruksi }}</p>
                                <p class="text-[11px] text-slate-500 mt-1">Perihal: {{ $disp->suratMasuk->perihal ?? '-' }}</p>
                                <div class="mt-2 text-right">
                                    <a href="{{ route('surat-masuk.show', $disp->surat_masuk_id) }}" class="text-xs font-semibold text-blue-600 hover:text-blue-700">
                                        Tindak Lanjut &rarr;
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-xs text-slate-400 text-center py-4">Belum ada disposisi yang ditugaskan ke Anda.</p>
                @endif
            </div>

            <!-- Surat Masuk Terbaru -->
            <div class="bg-white rounded-2xl p-6 border border-slate-200/80 shadow-sm">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-base font-bold text-slate-800">Surat Masuk Terbaru</h2>
                    <a href="{{ route('surat-masuk.index') }}" class="text-xs font-semibold text-blue-600 hover:text-blue-700">Lihat Semua</a>
                </div>

                <div class="space-y-3">
                    @foreach($suratMasukTerbaru as $sm)
                        <div class="text-xs border-b border-slate-100 pb-2.5 last:border-0 last:pb-0">
                            <div class="flex items-center justify-between text-slate-400 mb-0.5">
                                <span>{{ $sm->no_agenda }}</span>
                                <span>{{ $sm->tanggal_diterima->format('d/m/Y') }}</span>
                            </div>
                            <p class="font-medium text-slate-800 truncate">{{ $sm->perihal }}</p>
                            <p class="text-[11px] text-slate-500">Pengirim: {{ $sm->pengirim }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
