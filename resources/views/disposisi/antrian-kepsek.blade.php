@extends('layouts.sim')

@section('title', 'Antrean Disposisi & Persetujuan')
@section('page-title', 'Antrean Disposisi & Persetujuan')

@section('content')
<div class="space-y-8">
    <!-- Surat Masuk yang Menunggu Disposisi -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-6">
        <div class="mb-4">
            <h2 class="text-base font-bold text-slate-800">Surat Masuk Menunggu Disposisi</h2>
            <p class="text-xs text-slate-500">Pilih surat masuk untuk memberikan lembar disposisi instruksi kepada jajaran pegawai.</p>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 border-b border-slate-200 text-slate-500 font-semibold uppercase">
                    <tr>
                        <th class="py-3 px-4">No. Agenda</th>
                        <th class="py-3 px-4">Pengirim</th>
                        <th class="py-3 px-4">Perihal</th>
                        <th class="py-3 px-4">Tgl Terima</th>
                        <th class="py-3 px-4 text-center">Status</th>
                        <th class="py-3 px-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse($suratBelumDisposisi as $sm)
                        <tr class="hover:bg-blue-50/30">
                            <td class="py-3 px-4 font-mono font-bold text-blue-600">{{ $sm->no_agenda }}</td>
                            <td class="py-3 px-4 font-medium">{{ $sm->pengirim }}</td>
                            <td class="py-3 px-4">{{ $sm->perihal }}</td>
                            <td class="py-3 px-4">{{ $sm->tanggal_diterima->format('d/m/Y') }}</td>
                            <td class="py-3 px-4 text-center">
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-semibold bg-amber-100 text-amber-700">
                                    {{ ucfirst($sm->status) }}
                                </span>
                            </td>
                            <td class="py-3 px-4 text-center">
                                <a href="{{ route('surat-masuk.show', $sm) }}" class="px-3 py-1.5 rounded-lg bg-blue-600 hover:bg-blue-500 text-white text-[11px] font-semibold transition">
                                    Beri Disposisi &rarr;
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-6 text-center text-slate-400">Tidak ada surat masuk yang menunggu disposisi.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Riwayat Disposisi Surat -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-6">
        <div class="mb-4">
            <h2 class="text-base font-bold text-slate-800">Riwayat Disposisi yang Diterbitkan</h2>
            <p class="text-xs text-slate-500">Daftar instruksi disposisi Kepala Sekolah kepada para staf dan guru.</p>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 border-b border-slate-200 text-slate-500 font-semibold uppercase">
                    <tr>
                        <th class="py-3 px-4">Surat / Agenda</th>
                        <th class="py-3 px-4">Diteruskan Ke</th>
                        <th class="py-3 px-4">Instruksi Disposisi</th>
                        <th class="py-3 px-4 text-center">Status</th>
                        <th class="py-3 px-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse($riwayatDisposisi as $rd)
                        <tr class="hover:bg-slate-50">
                            <td class="py-3 px-4">
                                <span class="font-mono font-semibold text-blue-600 block">{{ $rd->suratMasuk->no_agenda ?? '-' }}</span>
                                <span class="text-[11px] text-slate-500 truncate block max-w-xs">{{ $rd->suratMasuk->perihal ?? '-' }}</span>
                            </td>
                            <td class="py-3 px-4 font-medium text-slate-800">{{ $rd->kepadaUser->name ?? '-' }}</td>
                            <td class="py-3 px-4 text-slate-600 max-w-sm">{{ $rd->instruksi }}</td>
                            <td class="py-3 px-4 text-center">
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold {{ $rd->status === 'selesai' ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700' }}">
                                    {{ ucfirst($rd->status) }}
                                </span>
                            </td>
                            <td class="py-3 px-4 text-center">
                                <a href="{{ route('surat-masuk.show', $rd->surat_masuk_id) }}" class="text-xs font-semibold text-blue-600 hover:underline">
                                    Lihat Surat
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-6 text-center text-slate-400">Belum ada riwayat disposisi.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
