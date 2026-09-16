@extends('layouts.sim')

@section('title', 'Tambah Pengguna')
@section('page-title', 'Tambah Pengguna Baru')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-8">
        <div class="mb-6 pb-4 border-b border-slate-100 flex items-center justify-between">
            <h2 class="text-lg font-bold text-slate-800">Form Pengguna Baru</h2>
            <a href="{{ route('pengaturan.users.index') }}" class="text-xs font-semibold text-slate-500 hover:text-slate-800">&larr; Kembali</a>
        </div>

        <form action="{{ route('pengaturan.users.store') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Nama Lengkap & Gelar *</label>
                <input type="text" name="name" value="{{ old('name') }}" required
                       class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-blue-500 outline-none"
                       placeholder="Contoh: Ahmad Yani, S.Pd.">
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Alamat Email *</label>
                <input type="email" name="email" value="{{ old('email') }}" required
                       class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-blue-500 outline-none"
                       placeholder="nama@smkn4tanjungpinang.sch.id">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Kata Sandi *</label>
                    <input type="password" name="password" required
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-blue-500 outline-none"
                           placeholder="••••••••">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Konfirmasi Kata Sandi *</label>
                    <input type="password" name="password_confirmation" required
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-blue-500 outline-none"
                           placeholder="••••••••">
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Peran / Hak Akses *</label>
                <select name="role" required class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                    <option value="guru">Guru / Staf Pendidik</option>
                    <option value="tu">Tata Usaha (TU)</option>
                    <option value="humas">Humas & Hubungan Industri</option>
                    <option value="kepala_sekolah">Kepala Sekolah</option>
                    <option value="siswa">Siswa</option>
                    <option value="admin">Administrator SIM</option>
                </select>
            </div>

            <div class="pt-2">
                <label class="flex items-center gap-2 cursor-pointer text-xs font-semibold text-slate-700">
                    <input type="checkbox" name="is_active" value="1" checked class="rounded border-slate-300 text-blue-600 focus:ring-blue-500">
                    <span>Akun Aktif (Dapat Login ke Sistem)</span>
                </label>
            </div>

            <div class="pt-4 flex items-center justify-end gap-3 border-t border-slate-100">
                <a href="{{ route('pengaturan.users.index') }}" class="px-5 py-2.5 rounded-xl border border-slate-300 text-slate-600 text-sm font-semibold hover:bg-slate-50 transition">Batal</a>
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-500 text-white text-sm font-semibold shadow-lg shadow-blue-600/30 transition">Simpan Pengguna</button>
            </div>
        </form>
    </div>
</div>
@endsection
