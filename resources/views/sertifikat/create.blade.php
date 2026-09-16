@extends('layouts.sim')

@section('title', 'Tambah Sertifikat PKL')
@section('page-title', 'Catat Data Sertifikat PKL')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-8">
        <div class="mb-6 pb-4 border-b border-slate-100 flex items-center justify-between">
            <div>
                <h2 class="text-lg font-bold text-slate-800">Form Pendataan Sertifikat Siswa PKL</h2>
                <p class="text-xs text-slate-500">Nomor sertifikat akan digenerate otomatis setelah diverifikasi dan diterbitkan.</p>
            </div>
            <a href="{{ route('sertifikat.index') }}" class="text-xs font-semibold text-slate-500 hover:text-slate-800">&larr; Kembali</a>
        </div>

        <form action="{{ route('sertifikat.store') }}" method="POST" class="space-y-5">
            @csrf

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="sm:col-span-2">
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Hubungkan Akun Siswa (Opsional)</label>
                    <select name="siswa_user_id" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                        <option value="">-- Pilih Akun Siswa Terdaftar (Bila Ada) --</option>
                        @foreach($siswas as $userSiswa)
                            <option value="{{ $userSiswa->id }}">{{ $userSiswa->name }} (NISN: {{ $userSiswa->nisn ?? '-' }})</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Nama Lengkap Siswa *</label>
                    <input type="text" name="nama_siswa" value="{{ old('nama_siswa') }}" required
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-blue-500 outline-none"
                           placeholder="Contoh: Bayu Pratama">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">NISN *</label>
                    <input type="text" name="nisn" value="{{ old('nisn') }}" required
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-blue-500 outline-none"
                           placeholder="0051234567">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Kelas *</label>
                    <input type="text" name="kelas" value="{{ old('kelas') }}" required
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-blue-500 outline-none"
                           placeholder="Contoh: XII RPL 1">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Program Keahlian *</label>
                    <input type="text" name="program_keahlian" value="{{ old('program_keahlian') }}" required
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-blue-500 outline-none"
                           placeholder="Rekayasa Perangkat Lunak">
                </div>

                <div class="sm:col-span-2">
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Mitra Industri Tempat PKL *</label>
                    <select name="kerja_sama_industri_id" required class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                        <option value="">-- Pilih Mitra DUDI --</option>
                        @foreach($mitras as $mitra)
                            <option value="{{ $mitra->id }}">{{ $mitra->nama_industri }} ({{ $mitra->program_keahlian }})</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Tanggal Mulai PKL *</label>
                    <input type="date" name="tanggal_mulai_pkl" value="{{ old('tanggal_mulai_pkl') }}" required
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Tanggal Selesai PKL *</label>
                    <input type="date" name="tanggal_selesai_pkl" value="{{ old('tanggal_selesai_pkl') }}" required
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Nilai Akhir (0 - 100)</label>
                    <input type="number" step="0.1" min="0" max="100" name="nilai" value="{{ old('nilai') }}"
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-blue-500 outline-none"
                           placeholder="Contoh: 92.5">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Predikat</label>
                    <input type="text" name="predikat" value="{{ old('predikat') }}"
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-blue-500 outline-none"
                           placeholder="Contoh: Sangat Baik (A)">
                </div>
            </div>

            <div class="pt-4 flex items-center justify-end gap-3 border-t border-slate-100">
                <a href="{{ route('sertifikat.index') }}" class="px-5 py-2.5 rounded-xl border border-slate-300 text-slate-600 text-sm font-semibold hover:bg-slate-50 transition">Batal</a>
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-500 text-white text-sm font-semibold shadow-lg shadow-blue-600/30 transition">Simpan Data Sertifikat</button>
            </div>
        </form>
    </div>
</div>
@endsection
