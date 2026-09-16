<?php

namespace App\Http\Controllers;

use App\Models\SuratKeluar;
use App\Models\SuratMasuk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

class SuratKeluarController extends Controller
{
    public function index(Request $request)
    {
        $query = SuratKeluar::with(['creator', 'approver', 'referensiSuratMasuk'])->latest();

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function($q) use ($s) {
                $q->where('no_surat', 'like', "%{$s}%")
                  ->orWhere('tujuan', 'like', "%{$s}%")
                  ->orWhere('perihal', 'like', "%{$s}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $suratKeluar = $query->paginate(10)->withQueryString();

        return view('surat-keluar.index', compact('suratKeluar'));
    }

    public function create(Request $request)
    {
        $suratMasukList = SuratMasuk::latest()->get();
        $selectedMasukId = $request->query('referensi_id');

        return view('surat-keluar.create', compact('suratMasukList', 'selectedMasukId'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tanggal_surat' => 'required|date',
            'tujuan' => 'required|string|max:255',
            'perihal' => 'required|string|max:255',
            'isi_ringkas' => 'nullable|string',
            'sifat' => 'required|in:biasa,segera,rahasia',
            'referensi_surat_masuk_id' => 'nullable|exists:surat_masuks,id',
            'lampiran' => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:10240',
            'action' => 'required|in:draft,ajukan',
        ]);

        $lampiranPath = null;
        if ($request->hasFile('lampiran')) {
            $lampiranPath = $request->file('lampiran')->store('surat-keluar', 'public');
        }

        $status = $validated['action'] === 'ajukan' ? 'menunggu_persetujuan' : 'draft';

        $surat = SuratKeluar::create([
            'tanggal_surat' => $validated['tanggal_surat'],
            'tujuan' => $validated['tujuan'],
            'perihal' => $validated['perihal'],
            'isi_ringkas' => $validated['isi_ringkas'] ?? null,
            'sifat' => $validated['sifat'],
            'referensi_surat_masuk_id' => $validated['referensi_surat_masuk_id'] ?? null,
            'lampiran_path' => $lampiranPath,
            'status' => $status,
            'created_by' => $request->user()->id,
        ]);

        $msg = $status === 'menunggu_persetujuan' 
            ? 'Konsep surat berhasil dibuat dan diajukan ke Kepala Sekolah untuk persetujuan.' 
            : 'Konsep surat berhasil disimpan sebagai draft.';

        return redirect()->route('surat-keluar.show', $surat)->with('success', $msg);
    }

    public function show(SuratKeluar $suratKeluar)
    {
        $suratKeluar->load(['creator', 'approver', 'referensiSuratMasuk']);
        return view('surat-keluar.show', compact('suratKeluar'));
    }

    public function edit(SuratKeluar $suratKeluar)
    {
        if (!in_array($suratKeluar->status, ['draft', 'ditolak'])) {
            return redirect()->route('surat-keluar.show', $suratKeluar)->with('error', 'Surat yang sedang diajukan atau sudah disetujui tidak dapat diedit langsung.');
        }

        $suratMasukList = SuratMasuk::latest()->get();
        return view('surat-keluar.edit', compact('suratKeluar', 'suratMasukList'));
    }

    public function update(Request $request, SuratKeluar $suratKeluar)
    {
        $validated = $request->validate([
            'tanggal_surat' => 'required|date',
            'tujuan' => 'required|string|max:255',
            'perihal' => 'required|string|max:255',
            'isi_ringkas' => 'nullable|string',
            'sifat' => 'required|in:biasa,segera,rahasia',
            'referensi_surat_masuk_id' => 'nullable|exists:surat_masuks,id',
            'lampiran' => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:10240',
            'action' => 'nullable|in:draft,ajukan',
        ]);

        if ($request->hasFile('lampiran')) {
            if ($suratKeluar->lampiran_path && Storage::disk('public')->exists($suratKeluar->lampiran_path)) {
                Storage::disk('public')->delete($suratKeluar->lampiran_path);
            }
            $validated['lampiran_path'] = $request->file('lampiran')->store('surat-keluar', 'public');
        }

        if (isset($validated['action']) && $validated['action'] === 'ajukan') {
            $validated['status'] = 'menunggu_persetujuan';
        }

        unset($validated['action']);
        $suratKeluar->update($validated);

        return redirect()->route('surat-keluar.show', $suratKeluar)->with('success', 'Konsep surat berhasil diperbarui.');
    }

    public function destroy(SuratKeluar $suratKeluar)
    {
        $suratKeluar->delete();
        return redirect()->route('surat-keluar.index')->with('success', 'Surat keluar berhasil dihapus.');
    }

    // Persetujuan oleh Kepala Sekolah
    public function approve(Request $request, SuratKeluar $suratKeluar)
    {
        $request->validate([
            'decision' => 'required|in:setujui,tolak',
            'catatan_revisi' => 'nullable|string',
        ]);

        if ($request->decision === 'setujui') {
            // Generate nomor surat jika belum ada
            if (!$suratKeluar->no_surat) {
                $month = str_pad(now()->month, 2, '0', STR_PAD_LEFT);
                $year = now()->year;
                $count = SuratKeluar::whereNotNull('no_surat')->count() + 1;
                $urut = str_pad($count, 4, '0', STR_PAD_LEFT);
                $suratKeluar->no_surat = "421.5/SMKN4/{$month}/{$year}/{$urut}";
            }

            $suratKeluar->update([
                'status' => 'disetujui',
                'approved_by' => $request->user()->id,
                'approved_at' => now(),
                'catatan_revisi' => $request->catatan_revisi,
            ]);

            return back()->with('success', "Surat keluar telah disetujui dengan No. Surat: {$suratKeluar->no_surat}");
        } else {
            $suratKeluar->update([
                'status' => 'ditolak',
                'catatan_revisi' => $request->catatan_revisi,
            ]);

            return back()->with('warning', 'Konsep surat ditolak dengan catatan revisi.');
        }
    }

    // Ubah status kirim / arsip
    public function updateStatus(Request $request, SuratKeluar $suratKeluar)
    {
        $request->validate([
            'status' => 'required|in:dikirim,diarsipkan',
        ]);

        $suratKeluar->update(['status' => $request->status]);

        return back()->with('success', 'Status surat berhasil diperbarui menjadi ' . ucfirst($request->status));
    }

    // Export PDF Cetak Surat
    public function cetakPdf(SuratKeluar $suratKeluar)
    {
        $suratKeluar->load(['creator', 'approver']);
        $pdf = Pdf::loadView('surat-keluar.pdf', compact('suratKeluar'));
        return $pdf->stream("surat-keluar-{$suratKeluar->id}.pdf");
    }
}
