@extends('layouts.sim')

@section('title', 'Notifikasi Sistem')
@section('page-title', 'Pusat Notifikasi')

@section('content')
<div class="max-w-3xl mx-auto space-y-4">
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-6">
        <div class="mb-4">
            <h2 class="text-base font-bold text-slate-800">Notifikasi Masuk</h2>
            <p class="text-xs text-slate-500">Pemberitahuan surat masuk baru, persetujuan surat keluar, disposisi, dan masa kontrak kemitraan DUDI.</p>
        </div>

        <div class="space-y-3">
            @forelse($notifikasis as $notif)
                <a href="{{ $notif['link'] }}" class="p-4 rounded-xl border border-slate-100 bg-slate-50/60 hover:bg-blue-50/50 hover:border-blue-200 transition flex items-start gap-4 group">
                    <div class="w-10 h-10 rounded-xl bg-blue-600 text-white flex items-center justify-center flex-shrink-0 shadow-sm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center justify-between gap-2 mb-1">
                            <h4 class="text-sm font-semibold text-slate-800 group-hover:text-blue-600 transition">{{ $notif['judul'] }}</h4>
                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-blue-100 text-blue-700">{{ $notif['badge'] }}</span>
                        </div>
                        <p class="text-xs text-slate-600">{{ $notif['pesan'] }}</p>
                        <span class="text-[10px] text-slate-400 block mt-2">{{ $notif['waktu'] ? $notif['waktu']->diffForHumans() : 'Baru saja' }}</span>
                    </div>
                </a>
            @empty
                <div class="py-12 text-center text-slate-400 text-xs">
                    Tidak ada notifikasi baru saat ini.
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
