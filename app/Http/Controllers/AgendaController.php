<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use Illuminate\Http\Request;

class AgendaController extends Controller
{
    public function index(Request $request)
    {
        $query = Agenda::with('creator')->latest('tanggal_mulai');

        if ($request->filled('tipe')) {
            $query->where('tipe', $request->tipe);
        }

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function($q) use ($s) {
                $q->where('judul', 'like', "%{$s}%")
                  ->orWhere('deskripsi', 'like', "%{$s}%")
                  ->orWhere('lokasi', 'like', "%{$s}%");
            });
        }

        $agendas = $query->paginate(10)->withQueryString();

        return view('agenda.index', compact('agendas'));
    }

    public function create()
    {
        return view('agenda.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
            'waktu' => 'nullable',
            'lokasi' => 'nullable|string|max:255',
            'tipe' => 'required|in:rapat,kegiatan,deadline,lainnya',
            'is_penting' => 'nullable|boolean',
        ]);

        Agenda::create([
            'judul' => $validated['judul'],
            'deskripsi' => $validated['deskripsi'] ?? null,
            'tanggal_mulai' => $validated['tanggal_mulai'],
            'tanggal_selesai' => $validated['tanggal_selesai'] ?? null,
            'waktu' => $validated['waktu'] ?? null,
            'lokasi' => $validated['lokasi'] ?? null,
            'tipe' => $validated['tipe'],
            'is_penting' => $request->has('is_penting'),
            'created_by' => $request->user()->id,
        ]);

        return redirect()->route('agenda.index')->with('success', 'Agenda berhasil ditambahkan.');
    }

    public function edit(Agenda $agenda)
    {
        return view('agenda.edit', compact('agenda'));
    }

    public function update(Request $request, Agenda $agenda)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
            'waktu' => 'nullable',
            'lokasi' => 'nullable|string|max:255',
            'tipe' => 'required|in:rapat,kegiatan,deadline,lainnya',
            'is_penting' => 'nullable|boolean',
        ]);

        $agenda->update([
            'judul' => $validated['judul'],
            'deskripsi' => $validated['deskripsi'] ?? null,
            'tanggal_mulai' => $validated['tanggal_mulai'],
            'tanggal_selesai' => $validated['tanggal_selesai'] ?? null,
            'waktu' => $validated['waktu'] ?? null,
            'lokasi' => $validated['lokasi'] ?? null,
            'tipe' => $validated['tipe'],
            'is_penting' => $request->has('is_penting'),
        ]);

        return redirect()->route('agenda.index')->with('success', 'Agenda berhasil diperbarui.');
    }

    public function destroy(Agenda $agenda)
    {
        $agenda->delete();
        return redirect()->route('agenda.index')->with('success', 'Agenda berhasil dihapus.');
    }
}
