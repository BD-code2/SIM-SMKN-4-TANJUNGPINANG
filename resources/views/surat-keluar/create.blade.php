@extends('layouts.sim')

@section('title', 'Buat Konsep Surat Keluar')
@section('page-title', 'Buat Konsep Surat Keluar')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-8">
        <div class="mb-6 pb-4 border-b border-slate-100 flex items-center justify-between">
            <div>
                <h2 class="text-lg font-bold text-slate-800">Form Konsep Surat Keluar</h2>
                <p class="text-xs text-slate-500">Sesuai alur, surat keluar dapat diajukan ke Kepala Sekolah untuk disetujui & digenerate nomornya.</p>
            </div>
            <a href="{{ route('surat-keluar.index') }}" class="text-xs font-semibold text-slate-500 hover:text-slate-800">&larr; Kembali</a>
        </div>

        <form action="{{ route('surat-keluar.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf

            <!-- Pilihan Alur: Berdasarkan Surat Masuk atau Baru -->
            <div class="p-4 rounded-xl bg-blue-50/50 border border-blue-100">
                <label class="block text-xs font-semibold text-blue-900 mb-1">Referensi Surat Masuk (Bila Ada / Balasan)</label>
                <select name="referensi_surat_masuk_id" class="w-full px-4 py-2.5 rounded-xl border border-blue-200 text-sm focus:ring-2 focus:ring-blue-500 outline-none bg-white">
                    <option value="">-- Tidak Berdasarkan Surat Masuk (Surat Baru) --</option>
                    @foreach($suratMasukList as $sm)
                        <option value="{{ $sm->id }}" {{ (isset($selectedMasukId) && $selectedMasukId == $sm->id) ? 'selected' : '' }}>
                            {{ $sm->no_agenda }} - {{ $sm->pengirim }} ({{ $sm->perihal }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Tujuan Surat Keluar *</label>
                    <input type="text" name="tujuan" value="{{ old('tujuan') }}" required
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-blue-500 outline-none"
                           placeholder="Kepada Yth. Pimpinan PT / Instansi">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Tanggal Surat *</label>
                    <input type="date" name="tanggal_surat" value="{{ old('tanggal_surat', date('Y-m-d')) }}" required
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                </div>

                <div class="sm:col-span-2">
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Perihal / Hal *</label>
                    <input type="text" name="perihal" value="{{ old('perihal') }}" required
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-blue-500 outline-none"
                           placeholder="Surat Pengantar / Permohonan Kerja Sama / Undangan">
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
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Unggah Draf Dokumen (PDF/DOC)</label>
                    <input type="file" name="lampiran"
                           class="w-full px-4 py-2 rounded-xl border border-slate-300 text-sm file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                </div>

                <div class="sm:col-span-2">
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Isi Ringkas / Teks Surat</label>
                    <textarea name="isi_ringkas" rows="4" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-blue-500 outline-none" placeholder="Poin penting atau draf isi surat yang akan diterbitkan...">{{ old('isi_ringkas') }}</textarea>
                </div>
            </div>

            <div class="pt-4 flex items-center justify-end gap-3 border-t border-slate-100">
                <button type="submit" name="action" value="draft" class="px-5 py-2.5 rounded-xl border border-slate-300 text-slate-600 text-sm font-semibold hover:bg-slate-50 transition">
                    Simpan Draf Saja
                </button>
                <button type="submit" name="action" value="ajukan" class="px-6 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-500 text-white text-sm font-semibold shadow-lg shadow-blue-600/30 transition">
                    Ajukan ke Kepala Sekolah &rarr;
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
