@extends('layouts.sim')

@section('title', 'Tambah Kerja Sama Industri')
@section('page-title', 'Tambah Kerja Sama Industri')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-8">
        <div class="mb-6 pb-4 border-b border-slate-100 flex items-center justify-between">
            <div>
                <h2 class="text-lg font-bold text-slate-800">Form Kemitraan Industri Baru</h2>
                <p class="text-xs text-slate-500">Catat MoU atau kemitraan DUDI untuk kegiatan PKL dan rekrutmen.</p>
            </div>
            <a href="{{ route('kerja-sama.index') }}" class="text-xs font-semibold text-slate-500 hover:text-slate-800">&larr; Kembali</a>
        </div>

        @if ($errors->any())
            <div class="mb-6 p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-700 text-xs">
                <ul class="list-disc pl-4 space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('kerja-sama.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="sm:col-span-2">
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Nama Perusahaan / Industri *</label>
                    <input type="text" name="nama_industri" value="{{ old('nama_industri') }}" required
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-blue-500 outline-none"
                           placeholder="Contoh: PT. Teknologi Maju">
                </div>

                <div class="sm:col-span-2">
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Alamat Perusahaan *</label>
                    <textarea name="alamat" rows="2" required
                              class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-blue-500 outline-none"
                              placeholder="Jl. Ahmad Yani No. 10, Tanjungpinang">{{ old('alamat') }}</textarea>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Kontak Person / Telepon</label>
                    <input type="text" name="kontak" value="{{ old('kontak') }}"
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-blue-500 outline-none"
                           placeholder="0812-XXXX-XXXX">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Email Kemitraan</label>
                    <input type="email" name="email" value="{{ old('email') }}"
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-blue-500 outline-none"
                           placeholder="hrd@perusahaan.com">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Program Keahlian Terkait *</label>
                    <select name="program_keahlian" required class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                        <option value="TKJ">Teknik Komputer & Jaringan (TKJ)</option>
                        <option value="RPL">Rekayasa Perangkat Lunak (RPL)</option>
                        <option value="Akuntansi">Akuntansi</option>
                        <option value="Nautika">Nautika Kapal Niaga</option>
                        <option value="Semua Jurusan">Semua Jurusan</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Status Kemitraan *</label>
                    <select name="status" required class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                        <option value="aktif">Aktif</option>
                        <option value="akan_berakhir">Akan Berakhir</option>
                        <option value="berakhir">Berakhir</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Tanggal Mulai Berlaku *</label>
                    <input type="date" name="tanggal_mulai" value="{{ old('tanggal_mulai', date('Y-m-d')) }}" required
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Tanggal Berakhir *</label>
                    <input type="date" name="tanggal_berakhir" value="{{ old('tanggal_berakhir', date('Y-m-d', strtotime('+1 year'))) }}" required
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                </div>

                <div class="sm:col-span-2">
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Unggah Dokumen MoU / Perjanjian (PDF/DOC)</label>
                    <input type="file" name="dokumen_mou"
                           class="w-full px-4 py-2 rounded-xl border border-slate-300 text-sm file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                </div>

                <div class="sm:col-span-2">
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Catatan Kemitraan</label>
                    <textarea name="catatan" rows="2" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-blue-500 outline-none" placeholder="Ruang lingkup kerja sama, kuota siswa PKL, dsb.">{{ old('catatan') }}</textarea>
                </div>
            </div>

            <div class="pt-4 flex items-center justify-end gap-3 border-t border-slate-100">
                <a href="{{ route('kerja-sama.index') }}" class="px-5 py-2.5 rounded-xl border border-slate-300 text-slate-600 text-sm font-semibold hover:bg-slate-50 transition">Batal</a>
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-500 text-white text-sm font-semibold shadow-lg shadow-blue-600/30 transition">Simpan Kemitraan</button>
            </div>
        </form>
    </div>
</div>
@endsection
