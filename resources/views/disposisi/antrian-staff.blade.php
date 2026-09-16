@extends('layouts.sim')

@section('title', 'Tugas Disposisi Saya')
@section('page-title', 'Tugas Disposisi Masuk')

@section('content')
<div class="space-y-6">
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-6">
        <div class="mb-4">
            <h2 class="text-base font-bold text-slate-800">Daftar Disposisi yang Ditugaskan Kepada Anda</h2>
            <p class="text-xs text-slate-500">Tindak lanjuti instruksi dari Kepala Sekolah dan perbarui status pengerjaan.</p>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 border-b border-slate-200 text-slate-500 font-semibold uppercase">
                    <tr>
                        <th class="py-3 px-4">Surat / Agenda</th>
                        <th class="py-3 px-4">Instruksi Kepala Sekolah</th>
                        <th class="py-3 px-4">Catatan</th>
                        <th class="py-3 px-4 text-center">Status</th>
                        <th class="py-3 px-4 text-center">Tindak Lanjut</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse($disposisiSaya as $disp)
                        <tr class="hover:bg-slate-50">
                            <td class="py-3.5 px-4">
                                <span class="font-mono font-bold text-blue-600 block">{{ $disp->suratMasuk->no_agenda ?? '-' }}</span>
                                <span class="text-xs font-semibold text-slate-800">{{ $disp->suratMasuk->perihal ?? '-' }}</span>
                                <span class="text-[11px] text-slate-400 block">Dari: {{ $disp->suratMasuk->pengirim ?? '-' }}</span>
                            </td>
                            <td class="py-3.5 px-4 font-medium text-slate-800 max-w-xs">{{ $disp->instruksi }}</td>
                            <td class="py-3.5 px-4 text-slate-500 max-w-xs">{{ $disp->catatan ?? '-' }}</td>
                            <td class="py-3.5 px-4 text-center">
                                <form action="{{ route('disposisi.status', $disp) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <select name="status" onchange="this.form.submit()" class="text-xs rounded-lg border-slate-300 py-1 px-2.5 font-semibold focus:ring-blue-500">
                                        <option value="menunggu" {{ $disp->status === 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                                        <option value="diproses" {{ $disp->status === 'diproses' ? 'selected' : '' }}>Diproses</option>
                                        <option value="selesai" {{ $disp->status === 'selesai' ? 'selected' : '' }}>Selesai</option>
                                    </select>
                                </form>
                            </td>
                            <td class="py-3.5 px-4 text-center">
                                <a href="{{ route('surat-masuk.show', $disp->surat_masuk_id) }}" class="px-3 py-1.5 rounded-lg bg-blue-50 hover:bg-blue-100 text-blue-600 text-xs font-semibold">
                                    Buka Surat &rarr;
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-8 text-center text-slate-400">Belum ada tugas disposisi yang ditujukan kepada Anda.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
