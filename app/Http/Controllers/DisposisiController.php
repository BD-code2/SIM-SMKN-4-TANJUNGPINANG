<?php

namespace App\Http\Controllers;

use App\Models\Disposisi;
use App\Models\SuratMasuk;
use Illuminate\Http\Request;

class DisposisiController extends Controller
{
    // Antrean disposisi untuk Kepala Sekolah & Guru/TU/Humas
    public function antrian(Request $request)
    {
        $user = $request->user();

        if ($user->isKepalaSekolah() || $user->isAdmin()) {
            // Kepala sekolah melihat surat masuk yang belum didisposisi & riwayat disposisi
            $suratBelumDisposisi = SuratMasuk::whereIn('status', ['diterima', 'diproses'])->latest()->get();
            $riwayatDisposisi = Disposisi::with('suratMasuk', 'kepadaUser')->latest()->paginate(10);
            return view('disposisi.antrian-kepsek', compact('suratBelumDisposisi', 'riwayatDisposisi'));
        } else {
            // Guru/TU/Humas melihat disposisi yang ditujukan ke mereka
            $disposisiSaya = Disposisi::with('suratMasuk', 'dariUser')
                ->where('kepada_user_id', $user->id)
                ->latest()
                ->paginate(10);
            return view('disposisi.antrian-staff', compact('disposisiSaya'));
        }
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'surat_masuk_id' => 'required|exists:surat_masuks,id',
            'kepada_user_id' => 'required|exists:users,id',
            'instruksi' => 'required|string',
            'catatan' => 'nullable|string',
        ]);

        $disposisi = Disposisi::create([
            'surat_masuk_id' => $validated['surat_masuk_id'],
            'dari_user_id' => $request->user()->id,
            'kepada_user_id' => $validated['kepada_user_id'],
            'instruksi' => $validated['instruksi'],
            'catatan' => $validated['catatan'] ?? null,
            'status' => 'menunggu',
        ]);

        // Update status surat masuk
        $suratMasuk = SuratMasuk::find($validated['surat_masuk_id']);
        if ($suratMasuk) {
            $suratMasuk->update(['status' => 'didisposisi']);
        }

        return back()->with('success', 'Disposisi berhasil diteruskan kepada pegawai terkait.');
    }

    public function updateStatus(Request $request, Disposisi $disposisi)
    {
        $request->validate([
            'status' => 'required|in:menunggu,diproses,selesai',
        ]);

        $disposisi->update(['status' => $request->status]);

        // Bila disposisi selesai, periksa apakah surat masuk bisa ditandai selesai
        if ($request->status === 'selesai') {
            $disposisi->suratMasuk->update(['status' => 'selesai']);
        } elseif ($request->status === 'diproses') {
            $disposisi->suratMasuk->update(['status' => 'diproses']);
        }

        return back()->with('success', 'Status tindak lanjut disposisi berhasil diperbarui.');
    }

    public function destroy(Disposisi $disposisi)
    {
        $disposisi->delete();
        return back()->with('success', 'Disposisi berhasil dihapus.');
    }
}
