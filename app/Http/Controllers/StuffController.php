<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StuffModel;
use Illuminate\View\View;

class StuffController extends Controller
{
    public function index(): View
    {
        $data = StuffModel::all(); // Mengambil semua data dari tabel stuffs
        return view('stuff.index', compact('data'));
    }

    public function create()
    {
         return view('stuff.create');
    }

    public function store(Request $request)
    {
        // Validasi input dari request
        $request->validate([
            'code' => 'required|unique:stuff', // Pastikan code unik di tabel stuffs
            'name' => 'required'
        ]);

        // Buat instance model StuffModel
        $stuff = new StuffModel();
        $stuff->code = $request->code;
        $stuff->name = $request->name;
        $stuff->save(); // Simpan data ke database

        // Redirect ke halaman utama dengan pesan sukses
        return redirect('/stuffs')->with('success', 'Stuff created successfully');
    }

    public function show($id)
    {
        $stuff = StuffModel::findOrFail($id);

        // Kirim data ke view
        return view('stuff.show', compact('stuff'));
    }

    public function edit($id) {
        $stuff = StuffModel::findOrFail($id);
        return view('stuff.edit', compact('stuff'));
    }

    public function update(Request $request, $id) {
        // Validasi input dari request
        $request->validate([
            'code' => 'required',
            'name' => 'required'
        ]);

        // Ambil data dari database berdasarkan ID
        $stuff = \App\Models\StuffModel::findOrFail($id);

        // Perbarui data
        $stuff->code = $request->code;
        $stuff->name = $request->name;
        $stuff->save(); // Simpan perubahan ke database

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('stuff.index')->with('success', 'Stuff updated successfully');
    }

    public function delete($id) {
        // Ambil data dari database berdasarkan ID
        $stuff = \App\Models\StuffModel::findOrFail($id);

        // Hapus data
        $stuff->delete();

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('stuff.index')->with('success', 'Stuff deleted successfully');
    }
}
