@extends('layouts.sim')

@section('title', 'Detail Surat Masuk')
@section('page-title', 'Detail Surat Masuk & Disposisi')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <a href="{{ route('surat-masuk.index') }}" class="text-sm font-semibold text-blue-600 hover:text-blue-700">&larr; Kembali ke Buku Agenda</a>
        <div class="flex items-center gap-2">
            <a href="{{ route('surat-keluar.create', ['referensi_id' => $suratMasuk->id]) }}" class="px-4 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold shadow-sm transition">
                + Buat Surat Balasan Keluar
            </a>
        </div>
    </div>

    <!-- Info Detail Surat Masuk -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-6">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-4 border-b border-slate-100 gap-4">
            <div>
                <span class="font-mono text-sm font-bold text-blue-600 bg-blue-50 px-3 py-1 rounded-lg">{{ $suratMasuk->no_agenda }}</span>
                <h1 class="text-xl font-bold text-slate-800 mt-2">{{ $suratMasuk->perihal }}</h1>
            </div>
            <div class="flex items-center gap-2">
                <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $suratMasuk->status === 'selesai' ? 'bg-emerald-100 text-emerald-700' : 'bg-blue-100 text-blue-700' }}">
                    Status: {{ ucfirst($suratMasuk->status) }}
                </span>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6 text-sm">
            <div class="space-y-3">
                <div>
                    <span class="text-xs text-slate-400 block">Nomor Surat Asli</span>
                    <span class="font-semibold text-slate-800">{{ $suratMasuk->no_surat }}</span>
                </div>
                <div>
                    <span class="text-xs text-slate-400 block">Instansi Pengirim</span>
                    <span class="font-semibold text-slate-800">{{ $suratMasuk->pengirim }}</span>
                </div>
                <div>
                    <span class="text-xs text-slate-400 block">Sifat Surat</span>
                    <span class="capitalize font-semibold text-slate-800">{{ $suratMasuk->sifat }}</span>
                </div>
            </div>

            <div class="space-y-3">
                <div>
                    <span class="text-xs text-slate-400 block">Tanggal Surat</span>
                    <span class="font-semibold text-slate-800">{{ $suratMasuk->tanggal_surat->format('d F Y') }}</span>
                </div>
                <div>
                    <span class="text-xs text-slate-400 block">Tanggal Diterima TU</span>
                    <span class="font-semibold text-slate-800">{{ $suratMasuk->tanggal_diterima->format('d F Y') }}</span>
                </div>
                <div>
                    <span class="text-xs text-slate-400 block">Berkas Lampiran</span>
                    @if($suratMasuk->lampiran_path)
                        <a href="{{ asset('storage/' . $suratMasuk->lampiran_path) }}" target="_blank" class="text-blue-600 font-semibold hover:underline inline-flex items-center gap-1">
                            Lihat Dokumen Terlampir &rarr;
                        </a>
                    @else
                        <span class="text-slate-400">Tidak ada lampiran</span>
                    @endif
                </div>
            </div>

            @if($suratMasuk->isi_ringkas)
            <div class="md:col-span-2 pt-3 border-t border-slate-100">
                <span class="text-xs text-slate-400 block mb-1">Isi Ringkas Surat</span>
                <p class="text-xs text-slate-700 bg-slate-50 p-4 rounded-xl leading-relaxed">{{ $suratMasuk->isi_ringkas }}</p>
            </div>
            @endif
        </div>
    </div>

    <!-- Bagian Form Disposisi (Khusus Kepala Sekolah / Admin) -->
    @if(auth()->user()->isKepalaSekolah() || auth()->user()->isAdmin())
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-6">
        <h2 class="text-base font-bold text-slate-800 mb-1">Lembar Disposisi Kepala Sekolah</h2>
        <p class="text-xs text-slate-500 mb-4">Teruskan instruksi atau tindak lanjut surat ini ke Guru, TU, atau Humas.</p>

        <form action="{{ route('disposisi.store') }}" method="POST" class="space-y-4">
            @csrf
            <input type="hidden" name="surat_masuk_id" value="{{ $suratMasuk->id }}">

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Diteruskan Kepada *</label>
                    <select name="kepada_user_id" required class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                        @foreach($users as $u)
                            <option value="{{ $u->id }}">{{ $u->name }} ({{ $u->role_label }})</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Instruksi Disposisi *</label>
                    <input type="text" name="instruksi" required placeholder="Contoh: Tindak lanjuti dan siapkan laporan"
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                </div>

                <div class="sm:col-span-2">
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Catatan Tambahan</label>
                    <textarea name="catatan" rows="2" placeholder="Catatan khusus dari Kepala Sekolah..."
                              class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-blue-500 outline-none"></textarea>
                </div>
            </div>

            <div class="text-right">
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-500 text-white text-xs font-semibold shadow-md shadow-blue-600/30 transition">
                    Kirim Disposisi
                </button>
            </div>
        </form>
    </div>
    @endif

    <!-- Riwayat Disposisi Surat -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-6">
        <h2 class="text-base font-bold text-slate-800 mb-4">Riwayat & Status Disposisi</h2>

        @if($suratMasuk->disposisis->count() > 0)
            <div class="space-y-4">
                @foreach($suratMasuk->disposisis as $disp)
                    <div class="p-4 rounded-xl border border-slate-200 bg-slate-50/50 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                        <div>
                            <div class="flex items-center gap-2 mb-1">
                                <span class="text-xs font-bold text-slate-800">{{ $disp->kepadaUser->name ?? 'Pegawai' }}</span>
                                <span class="text-[11px] text-slate-500">({{ $disp->kepadaUser->role_label ?? '-' }})</span>
                            </div>
                            <p class="text-xs font-medium text-blue-700">Instruksi: {{ $disp->instruksi }}</p>
                            @if($disp->catatan)
                                <p class="text-[11px] text-slate-500 mt-0.5">Catatan: {{ $disp->catatan }}</p>
                            @endif
                        </div>

                        <div class="flex items-center gap-3">
                            <!-- Ubah Status jika yang login adalah penerima disposisi atau Kepsek -->
                            @if(auth()->id() === $disp->kepada_user_id || auth()->user()->isKepalaSekolah() || auth()->user()->isAdmin())
                                <form action="{{ route('disposisi.status', $disp) }}" method="POST" class="flex items-center gap-2">
                                    @csrf
                                    @method('PATCH')
                                    <select name="status" onchange="this.form.submit()" class="text-xs rounded-lg border-slate-300 py-1 px-2.5 font-semibold focus:ring-blue-500">
                                        <option value="menunggu" {{ $disp->status === 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                                        <option value="diproses" {{ $disp->status === 'diproses' ? 'selected' : '' }}>Diproses</option>
                                        <option value="selesai" {{ $disp->status === 'selesai' ? 'selected' : '' }}>Selesai</option>
                                    </select>
                                </form>
                            @else
                                <span class="px-2.5 py-1 rounded-full text-xs font-semibold {{ $disp->status === 'selesai' ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700' }}">
                                    {{ ucfirst($disp->status) }}
                                </span>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-xs text-slate-400 py-4 text-center">Surat ini belum memiliki catatan disposisi.</p>
        @endif
    </div>
</div>
@endsection
