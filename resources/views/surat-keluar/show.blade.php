@extends('layouts.sim')

@section('title', 'Detail Surat Keluar')
@section('page-title', 'Detail Surat Keluar & Persetujuan')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <a href="{{ route('surat-keluar.index') }}" class="text-sm font-semibold text-blue-600 hover:text-blue-700">&larr; Kembali ke Buku Surat Keluar</a>
        <div class="flex items-center gap-2">
            @if(in_array($suratKeluar->status, ['disetujui', 'dikirim', 'diarsipkan']))
                <a href="{{ route('surat-keluar.pdf', $suratKeluar) }}" target="_blank" class="px-4 py-2 rounded-xl bg-rose-600 hover:bg-rose-700 text-white text-xs font-semibold shadow-sm transition inline-flex items-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                    Cetak Surat PDF
                </a>
            @endif
        </div>
    </div>

    <!-- Informasi Surat Keluar -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-6">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-4 border-b border-slate-100 gap-4">
            <div>
                <span class="font-mono text-sm font-bold text-blue-600 bg-blue-50 px-3 py-1 rounded-lg">
                    {{ $suratKeluar->no_surat ?? 'Draf (Belum Terbit)' }}
                </span>
                <h1 class="text-xl font-bold text-slate-800 mt-2">{{ $suratKeluar->perihal }}</h1>
            </div>
            <div>
                @if($suratKeluar->status === 'disetujui')
                    <span class="px-3 py-1.5 rounded-full text-xs font-bold bg-emerald-100 text-emerald-700">Disetujui Kepala Sekolah</span>
                @elseif($suratKeluar->status === 'menunggu_persetujuan')
                    <span class="px-3 py-1.5 rounded-full text-xs font-bold bg-amber-100 text-amber-700">Menunggu Persetujuan</span>
                @elseif($suratKeluar->status === 'ditolak')
                    <span class="px-3 py-1.5 rounded-full text-xs font-bold bg-rose-100 text-rose-700">Ditolak (Perlu Revisi)</span>
                @else
                    <span class="px-3 py-1.5 rounded-full text-xs font-bold bg-slate-100 text-slate-600">{{ ucfirst($suratKeluar->status) }}</span>
                @endif
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6 text-sm">
            <div class="space-y-3">
                <div>
                    <span class="text-xs text-slate-400 block">Tujuan Surat</span>
                    <span class="font-semibold text-slate-800">{{ $suratKeluar->tujuan }}</span>
                </div>
                <div>
                    <span class="text-xs text-slate-400 block">Tanggal Surat</span>
                    <span class="font-semibold text-slate-800">{{ $suratKeluar->tanggal_surat->format('d F Y') }}</span>
                </div>
                <div>
                    <span class="text-xs text-slate-400 block">Sifat Surat</span>
                    <span class="capitalize font-semibold text-slate-800">{{ $suratKeluar->sifat }}</span>
                </div>
            </div>

            <div class="space-y-3">
                <div>
                    <span class="text-xs text-slate-400 block">Dibuat Oleh</span>
                    <span class="font-semibold text-slate-800">{{ $suratKeluar->creator->name ?? 'TU' }}</span>
                </div>
                <div>
                    <span class="text-xs text-slate-400 block">Referensi Surat Masuk</span>
                    @if($suratKeluar->referensiSuratMasuk)
                        <a href="{{ route('surat-masuk.show', $suratKeluar->referensiSuratMasuk) }}" class="text-blue-600 font-semibold hover:underline">
                            {{ $suratKeluar->referensiSuratMasuk->no_agenda }} ({{ $suratKeluar->referensiSuratMasuk->pengirim }})
                        </a>
                    @else
                        <span class="text-slate-400">Tanpa referensi surat masuk</span>
                    @endif
                </div>
                <div>
                    <span class="text-xs text-slate-400 block">Berkas Terlampir</span>
                    @if($suratKeluar->lampiran_path)
                        <a href="{{ asset('storage/' . $suratKeluar->lampiran_path) }}" target="_blank" class="text-blue-600 font-semibold hover:underline inline-flex items-center gap-1">
                            Lihat Berkas &rarr;
                        </a>
                    @else
                        <span class="text-slate-400">Tidak ada lampiran</span>
                    @endif
                </div>
            </div>

            @if($suratKeluar->isi_ringkas)
            <div class="md:col-span-2 pt-3 border-t border-slate-100">
                <span class="text-xs text-slate-400 block mb-1">Isi Surat</span>
                <p class="text-xs text-slate-700 bg-slate-50 p-4 rounded-xl leading-relaxed whitespace-pre-line">{{ $suratKeluar->isi_ringkas }}</p>
            </div>
            @endif

            @if($suratKeluar->catatan_revisi)
            <div class="md:col-span-2 pt-2">
                <span class="text-xs font-semibold text-rose-500 block mb-1">Catatan Persetujuan / Revisi:</span>
                <p class="text-xs text-rose-800 bg-rose-50 border border-rose-200 p-3 rounded-xl">{{ $suratKeluar->catatan_revisi }}</p>
            </div>
            @endif
        </div>
    </div>

    <!-- Panel Persetujuan Khusus Kepala Sekolah Sesuai Flowchart -->
    @if((auth()->user()->isKepalaSekolah() || auth()->user()->isAdmin()) && $suratKeluar->status === 'menunggu_persetujuan')
    <div class="bg-white rounded-2xl border border-blue-200 shadow-sm p-6 bg-blue-50/30">
        <h2 class="text-base font-bold text-slate-800 mb-1">Persetujuan Kepala Sekolah</h2>
        <p class="text-xs text-slate-500 mb-4">Setujui konsep surat untuk menerbitkan nomor surat resmi secara otomatis, atau kembalikan dengan catatan revisi.</p>

        <form action="{{ route('surat-keluar.approve', $suratKeluar) }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Catatan / Arahan (Opsional)</label>
                <textarea name="catatan_revisi" rows="2" placeholder="Tuliskan catatan bila memerlukan revisi atau instruksi tambahan..."
                          class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-blue-500 outline-none bg-white"></textarea>
            </div>

            <div class="flex items-center justify-end gap-3">
                <button type="submit" name="decision" value="tolak" class="px-5 py-2.5 rounded-xl bg-rose-600 hover:bg-rose-700 text-white text-xs font-semibold shadow transition">
                    Kembalikan / Revisi
                </button>
                <button type="submit" name="decision" value="setujui" class="px-6 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold shadow-lg shadow-emerald-600/30 transition">
                    Setujui & Terbitkan No. Surat
                </button>
            </div>
        </form>
    </div>
    @endif

    <!-- Update Status Pengiriman / Arsip untuk TU -->
    @if(in_array($suratKeluar->status, ['disetujui', 'dikirim']))
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h3 class="text-sm font-bold text-slate-800">Tindak Lanjut Surat Keluar</h3>
            <p class="text-xs text-slate-500">Ubah status setelah dicetak dan dikirimkan ke alamat tujuan, lalu arsipkan.</p>
        </div>
        <div class="flex items-center gap-2">
            @if($suratKeluar->status === 'disetujui')
                <form action="{{ route('surat-keluar.status', $suratKeluar) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="status" value="dikirim">
                    <button type="submit" class="px-4 py-2 rounded-xl bg-blue-600 hover:bg-blue-500 text-white text-xs font-semibold shadow-sm transition">
                        Tandai Sudah Dikirim
                    </button>
                </form>
            @endif

            @if($suratKeluar->status === 'dikirim')
                <form action="{{ route('surat-keluar.status', $suratKeluar) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="status" value="diarsipkan">
                    <button type="submit" class="px-4 py-2 rounded-xl bg-slate-800 hover:bg-slate-700 text-white text-xs font-semibold shadow-sm transition">
                        Simpan di Arsip
                    </button>
                </form>
            @endif
        </div>
    </div>
    @endif
</div>
@endsection
