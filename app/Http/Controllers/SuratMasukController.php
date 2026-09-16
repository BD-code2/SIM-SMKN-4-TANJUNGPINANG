<?php

namespace App\Http\Controllers;

use App\Models\SuratMasuk;
use App\Models\Disposisi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SuratMasukController extends Controller
{
    public function index(Request $request)
    {
        $query = SuratMasuk::with(['creator', 'disposisis.kepadaUser'])->latest();

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function($q) use ($s) {
                $q->where('no_surat', 'like', "%{$s}%")
                  ->orWhere('no_agenda', 'like', "%{$s}%")
                  ->orWhere('pengirim', 'like', "%{$s}%")
                  ->orWhere('perihal', 'like', "%{$s}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('sifat')) {
            $query->where('sifat', $request->sifat);
        }

        $suratMasuk = $query->paginate(10)->withQueryString();

        return view('surat-masuk.index', compact('suratMasuk'));
    }

    public function create()
    {
        return view('surat-masuk.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'no_surat' => 'required|string|max:255',
            'tanggal_surat' => 'required|date',
            'tanggal_diterima' => 'required|date',
            'pengirim' => 'required|string|max:255',
            'perihal' => 'required|string|max:255',
            'isi_ringkas' => 'nullable|string',
            'sifat' => 'required|in:biasa,segera,rahasia',
            'lampiran' => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:10240',
        ]);

        $lampiranPath = null;
        if ($request->hasFile('lampiran')) {
            $lampiranPath = $request->file('lampiran')->store('surat-masuk', 'public');
        }

        $surat = SuratMasuk::create([
            'no_surat' => $validated['no_surat'],
            'tanggal_surat' => $validated['tanggal_surat'],
            'tanggal_diterima' => $validated['tanggal_diterima'],
            'pengirim' => $validated['pengirim'],
            'perihal' => $validated['perihal'],
            'isi_ringkas' => $validated['isi_ringkas'] ?? null,
            'sifat' => $validated['sifat'],
            'lampiran_path' => $lampiranPath,
            'status' => 'diterima',
            'created_by' => $request->user()->id,
        ]);

        return redirect()->route('surat-masuk.show', $surat)->with('success', 'Surat masuk berhasil dicatat dengan No. Agenda: ' . $surat->no_agenda);
    }

    public function show(SuratMasuk $suratMasuk)
    {
        $suratMasuk->load(['creator', 'disposisis.dariUser', 'disposisis.kepadaUser', 'suratKeluars']);
        $users = User::where('is_active', true)->whereIn('role', ['kepala_sekolah', 'tu', 'humas', 'guru'])->get();

        return view('surat-masuk.show', compact('suratMasuk', 'users'));
    }

    public function edit(SuratMasuk $suratMasuk)
    {
        return view('surat-masuk.edit', compact('suratMasuk'));
    }

    public function update(Request $request, SuratMasuk $suratMasuk)
    {
        $validated = $request->validate([
            'no_surat' => 'required|string|max:255',
            'tanggal_surat' => 'required|date',
            'tanggal_diterima' => 'required|date',
            'pengirim' => 'required|string|max:255',
            'perihal' => 'required|string|max:255',
            'isi_ringkas' => 'nullable|string',
            'sifat' => 'required|in:biasa,segera,rahasia',
            'status' => 'required|in:diterima,didisposisi,diproses,selesai,diarsipkan',
            'lampiran' => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:10240',
        ]);

        if ($request->hasFile('lampiran')) {
            if ($suratMasuk->lampiran_path && Storage::disk('public')->exists($suratMasuk->lampiran_path)) {
                Storage::disk('public')->delete($suratMasuk->lampiran_path);
            }
            $validated['lampiran_path'] = $request->file('lampiran')->store('surat-masuk', 'public');
        }

        $suratMasuk->update($validated);

        return redirect()->route('surat-masuk.show', $suratMasuk)->with('success', 'Data surat masuk berhasil diperbarui.');
    }

    public function destroy(SuratMasuk $suratMasuk)
    {
        $suratMasuk->delete();
        return redirect()->route('surat-masuk.index')->with('success', 'Surat masuk berhasil dihapus.');
    }
}
