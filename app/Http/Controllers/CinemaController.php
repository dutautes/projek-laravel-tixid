<?php

namespace App\Http\Controllers;

use App\Models\Cinema;
use Illuminate\Http\Request;

class CinemaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cinemas = Cinema::all();
        return view('admin.cinema.index', compact('cinemas'));
        // compact -> argumen pada fungsi akan sama dengan nama variabel yang akan dikirim ke blade
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // validasi
        $request->validate(
            [
                'name' => 'required|min:3',
                'location' => 'required|min:10',
            ],
            [
                'name.required' => 'Nama Bioskop harus diisi',
                'name.min' => 'Nama wajib diisi minimal 3 huruf',
                'location.required' => 'Lokasi bioskop harus diisi',
                'location.min' => 'Lokasi wajib diisi minimal 10 huruf'
            ]
        );

        // kirim data
        $createCinema = Cinema::create([
            'name' => $request->name,
            'location' => $request->location,
        ]);

        // redirect
        if ($createCinema) {
            return redirect()->route('admin.cinemas.index')->with('success', 'Berhasil membuat data bioskop!');
        } else {
            return redirect()->back()->with('failed', 'Gagal membuat data bioskop!');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Cinema $cinema)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $cinema = Cinema::find($id);
        return view('admin.cinema.edit', compact('cinema'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // validasi
        $request->validate([
            'name' => 'required|min:3',
            'location' => 'required|min:10',
        ],  [
            'name.required' => 'Nama Bioskop harus diisi',
            'name.min' => 'Nama wajib diisi minimal 3 huruf',
            'location.required' => 'Lokasi bioskop harus diisi',
            'location.min' => 'Lokasi wajib diisi minimal 10 huruf'
        ]);

        // kirim data
        $updateCinema = Cinema::where('id', $id)->update([
            'name' => $request->name,
            'location' => $request->location
        ]);

        if ($updateCinema) {
            return redirect()->route('admin.cinemas.index')->with('success', 'Berhasil mengubah data bioskop!');
        } else {
            return redirect()->back()->with('failed', 'Gagal mengubah data bioskop!');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $deleteData = Cinema::where('id', $id)->delete();
        if ($deleteData) {
            return redirect()->route('admin.cinemas.index')->with('success', 'Berhasil menghapus data bioskop!');
        } else {
            return redirect()->back()->with('failed', 'Gagal menghapus data bioskop!');
        }
    }
}
