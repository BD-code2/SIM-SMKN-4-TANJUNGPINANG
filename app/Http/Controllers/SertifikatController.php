<?php

namespace App\Http\Controllers;

use App\Models\SertifikatSiswa;
use App\Models\KerjaSamaIndustri;
use App\Models\User;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class SertifikatController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $query = SertifikatSiswa::with(['siswa', 'industri', 'penerbit'])->latest();

        if ($user->isSiswa()) {
            $query->where('siswa_user_id', $user->id);
        }

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function($q) use ($s) {
                $q->where('nama_siswa', 'like', "%{$s}%")
                  ->orWhere('nisn', 'like', "%{$s}%")
                  ->orWhere('no_sertifikat', 'like', "%{$s}%")
                  ->orWhere('kelas', 'like', "%{$s}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $sertifikats = $query->paginate(10)->withQueryString();

        return view('sertifikat.index', compact('sertifikats'));
    }

    public function create()
    {
        $mitras = KerjaSamaIndustri::where('status', 'aktif')->get();
        $siswas = User::where('role', 'siswa')->where('is_active', true)->get();

        return view('sertifikat.create', compact('mitras', 'siswas'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'siswa_user_id' => 'nullable|exists:users,id',
            'nama_siswa' => 'required|string|max:255',
            'nisn' => 'required|string|max:30',
            'kelas' => 'required|string|max:50',
            'program_keahlian' => 'required|string|max:100',
            'kerja_sama_industri_id' => 'required|exists:kerja_sama_industris,id',
            'tanggal_mulai_pkl' => 'required|date',
            'tanggal_selesai_pkl' => 'required|date|after:tanggal_mulai_pkl',
            'nilai' => 'nullable|numeric|min:0|max:100',
            'predikat' => 'nullable|string|max:50',
        ]);

        $sertifikat = SertifikatSiswa::create($validated + ['status' => 'draft']);

        return redirect()->route('sertifikat.show', $sertifikat)->with('success', 'Data sertifikat PKL berhasil dicatat dalam status draft.');
    }

    public function show(SertifikatSiswa $sertifikat)
    {
        $sertifikat->load(['siswa', 'industri', 'penerbit']);
        return view('sertifikat.show', compact('sertifikat'));
    }

    public function edit(SertifikatSiswa $sertifikat)
    {
        $mitras = KerjaSamaIndustri::all();
        $siswas = User::where('role', 'siswa')->where('is_active', true)->get();

        return view('sertifikat.edit', compact('sertifikat', 'mitras', 'siswas'));
    }

    public function update(Request $request, SertifikatSiswa $sertifikat)
    {
        $validated = $request->validate([
            'siswa_user_id' => 'nullable|exists:users,id',
            'nama_siswa' => 'required|string|max:255',
            'nisn' => 'required|string|max:30',
            'kelas' => 'required|string|max:50',
            'program_keahlian' => 'required|string|max:100',
            'kerja_sama_industri_id' => 'required|exists:kerja_sama_industris,id',
            'tanggal_mulai_pkl' => 'required|date',
            'tanggal_selesai_pkl' => 'required|date|after:tanggal_mulai_pkl',
            'nilai' => 'nullable|numeric|min:0|max:100',
            'predikat' => 'nullable|string|max:50',
            'status' => 'required|in:draft,terverifikasi,diterbitkan',
        ]);

        $sertifikat->update($validated);

        return redirect()->route('sertifikat.show', $sertifikat)->with('success', 'Data sertifikat PKL berhasil diperbarui.');
    }

    // Verifikasi dan Terbitkan Sertifikat
    public function updateStatus(Request $request, SertifikatSiswa $sertifikat)
    {
        $request->validate([
            'status' => 'required|in:terverifikasi,diterbitkan',
        ]);

        $data = ['status' => $request->status];

        if ($request->status === 'diterbitkan') {
            $data['diterbitkan_oleh'] = $request->user()->id;
            $data['diterbitkan_pada'] = now();
        }

        $sertifikat->update($data);

        return back()->with('success', 'Status sertifikat PKL berhasil diubah menjadi ' . ucfirst($request->status));
    }

    public function destroy(SertifikatSiswa $sertifikat)
    {
        $sertifikat->delete();
        return redirect()->route('sertifikat.index')->with('success', 'Data sertifikat berhasil dihapus.');
    }

    // Cetak PDF Sertifikat PKL
    public function cetakPdf(SertifikatSiswa $sertifikat)
    {
        $sertifikat->load(['siswa', 'industri', 'penerbit']);
        $pdf = Pdf::loadView('sertifikat.pdf', compact('sertifikat'))->setPaper('a4', 'landscape');
        return $pdf->stream("sertifikat-pkl-{$sertifikat->nisn}.pdf");
    }
}
