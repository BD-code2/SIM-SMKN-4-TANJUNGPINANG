@extends('layouts.sim')

@section('title', 'Catat Surat Masuk')
@section('page-title', 'Catat Surat Masuk Baru')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-8">
        <div class="mb-6 pb-4 border-b border-slate-100 flex items-center justify-between">
            <div>
                <h2 class="text-lg font-bold text-slate-800">Form Surat Masuk</h2>
                <p class="text-xs text-slate-500">Nomor agenda akan otomatis digenerate oleh sistem.</p>
            </div>
            <a href="{{ route('surat-masuk.index') }}" class="text-xs font-semibold text-slate-500 hover:text-slate-800">&larr; Kembali</a>
        </div>

        <form action="{{ route('surat-masuk.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Nomor Surat Masuk *</label>
                    <input type="text" name="no_surat" value="{{ old('no_surat') }}" required
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-blue-500 outline-none"
                           placeholder="Contoh: 421/DISDIK/IX/2026">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Pengirim Surat *</label>
                    <input type="text" name="pengirim" value="{{ old('pengirim') }}" required
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-blue-500 outline-none"
                           placeholder="Instansi / Pengirim">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Tanggal Surat *</label>
                    <input type="date" name="tanggal_surat" value="{{ old('tanggal_surat', date('Y-m-d')) }}" required
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Tanggal Diterima *</label>
                    <input type="date" name="tanggal_diterima" value="{{ old('tanggal_diterima', date('Y-m-d')) }}" required
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                </div>

                <div class="sm:col-span-2">
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Perihal / Hal *</label>
                    <input type="text" name="perihal" value="{{ old('perihal') }}" required
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-blue-500 outline-none"
                           placeholder="Undangan / Pemberitahuan / Permohonan">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Sifat Surat *</label>
                    <select name="sifat" required class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                        <option value="biasa">Biasa</option>
                        <option value="segera">Segera / Penting</option>
                        <option value="rahasia">Rahasia</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Unggah Lampiran Surat (PDF/Foto)</label>
                    <input type="file" name="lampiran"
                           class="w-full px-4 py-2 rounded-xl border border-slate-300 text-sm file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                </div>

                <div class="sm:col-span-2">
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Isi Ringkas Surat</label>
                    <textarea name="isi_ringkas" rows="3" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-blue-500 outline-none" placeholder="Ringkasan poin isi surat masuk...">{{ old('isi_ringkas') }}</textarea>
                </div>
            </div>

            <div class="pt-4 flex items-center justify-end gap-3 border-t border-slate-100">
                <a href="{{ route('surat-masuk.index') }}" class="px-5 py-2.5 rounded-xl border border-slate-300 text-slate-600 text-sm font-semibold hover:bg-slate-50 transition">Batal</a>
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-500 text-white text-sm font-semibold shadow-lg shadow-blue-600/30 transition">Simpan & Buat Agenda</button>
            </div>
        </form>
    </div>
</div>
@endsection
