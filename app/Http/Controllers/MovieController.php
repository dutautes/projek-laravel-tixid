<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $movies = Movie::all();
        return view('admin.movie.index', compact('movies'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.movie.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'title' => 'required',
            'duration' => 'required',
            'genre' => 'required',
            'director' => 'required',
            'age_rating' => 'required|numeric',
            // mimes -> bentuk file yang di izinkan untuk upload
            'poster' => 'required|mimes:jpg,jpeg,png,webp,svg',
            'description' => 'required|min:10'
        ], [
            'title.required' => 'Judul film harus diisi',
            'duration.required' => 'Durasi film harus diisi',
            'genre.required' => 'Genre film harus diisi',
            'director.required' => 'Sutradara wajib diisi',
            'age_rating.required' => 'Usia Minimal penonton harus diisi',
            'age_rating.numeric' => 'Usia Minimal penonton harus diisi dengan angka',
            'poster.required' => 'Poster harus diisi',
            'poster.mimes' => 'Poster harus diisi dengan JPG/JPEG/PNG/WEBP/SVG',
            'description.required' => 'Sinopsis film harus diisi',
            'description.min' => 'Sinopsis film harus diisi minimal 10 karakter',
        ]);
        // ambil file yang di upload = $request->file('nama_input')
        $gambar = $request->file('poster');
        // buat nama baru di filenya, agar menghindari nama file yang sama
        // nama file yg diinginkan = <random>-poster.png
        // getClientOriginalExtension() = mengambil ekstensi file (png/jpg/dll)
        $namaGambar = Str::random(5) . "-poster." . $gambar->getClientOriginalExtension();
        // simpan file ke storage, nama file gunakan nama file baru
        // storeAs('namaFolder', #namafile, 'public')
        $path = $gambar->storeAs('poster', $namaGambar, 'public');

        $createData = Movie::create([
            'title' => $request->title,
            'duration' => $request->duration,
            'genre' => $request->genre,
            'director' => $request->director,
            'age_rating' => $request->age_rating,
            'poster' => $path, // $path beriis lokasi file yg disimpan dr storeAs()
            'description' => $request->description,
            'activated' => 1
        ]);

        if ($createData) {
            return redirect()->route('admin.movies.index')->with('success', 'Berhasil membuat data film');
        } else {
            return redirect()->back()->with('error', 'Gagal! silahkan coba lagi');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Movie $movie)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $movie = Movie::find($id);
        return view('admin.movie.edit', compact('movie'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // dd($request->all());
        $request->validate([
            'title' => 'required',
            'duration' => 'required',
            'genre' => 'required',
            'director' => 'required',
            'age_rating' => 'required|numeric',
            // mimes -> bentuk file yang di izinkan untuk upload
            'poster' => 'mimes:jpg,jpeg,png,webp,svg',
            'description' => 'required|min:10'
        ], [
            'title.required' => 'Judul film harus diisi',
            'duration.required' => 'Durasi film harus diisi',
            'genre.required' => 'Genre film harus diisi',
            'director.required' => 'Sutradara wajib diisi',
            'age_rating.required' => 'Usia Minimal penonton harus diisi',
            'age_rating.numeric' => 'Usia Minimal penonton harus diisi dengan angka',
            'poster.mimes' => 'Poster harus diisi dengan JPG/JPEG/PNG/WEBP/SVG',
            'description.required' => 'Sinopsis film harus diisi',
            'description.min' => 'Sinopsis film harus diisi minimal 10 karakter',
        ]);
        // data sebelumnya
        $movie = Movie::find($id);
        if ($request->file('poster')) {
            // storage_path() : cek apakah file sblmnya ada di folder storage/app/public
            $fileSebelumnya = storage_path('app/public/' . $movie['poster']);
            if ($fileSebelumnya) {
                // hapus file sebelumnya
                unlink($fileSebelumnya);
            }

            // ambil file yang di upload = $request->file('nama_input')
            $gambar = $request->file('poster');
            // buat nama baru di filenya, agar menghindari nama file yang sama
            // nama file yg diinginkan = <random>-poster.png
            // getClientOriginalExtension() = mengambil ekstensi file (png/jpg/dll)
            $namaGambar = Str::random(5) . "-poster." . $gambar->getClientOriginalExtension();
            // simpan file ke storage, nama file gunakan nama file baru
            // storeAs('namaFolder', #namafile, 'public')
            $path = $gambar->storeAs('poster', $namaGambar, 'public');
        }

        $updateData = Movie::where('id', $id)->update([
            'title' => $request->title,
            'duration' => $request->duration,
            'genre' => $request->genre,
            'director' => $request->director,
            'age_rating' => $request->age_rating,
            // ?? : sebelum ?? itu (if) ?? sesudah itu (else)
            // kalau ada $path (poster baru), ambil data baru, kalau
            'poster' => $path ?? $movie['poster'], // $path berisi lokasi file yg disimpan dr storeAs()
            'description' => $request->description,
            'activated' => 1
        ]);

        if ($updateData) {
            return redirect()->route('admin.movies.index')->with('success', 'Berhasil mengganti data film');
        } else {
            return redirect()->back()->with('error', 'Gagal! silahkan coba lagi');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $movie = Movie::find($id);
        if ($movie && $movie->poster) {
            $filePath = storage_path('/app/public/' . $movie['poster']);
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }

        $deleteDataFilm = Movie::where('id', $id)->delete();
        if ($deleteDataFilm) {
            return redirect()->route('admin.movies.index')->with('success', 'Berhasil menghapus data film!');
        } else {
            return redirect()->back()->with('failed', 'Gagal menghapus data film!');
        }
    }

    public function home()
    {
        // where ('field', 'value') -> mencari data
        // get() -> mengambil semua data dari hasil filter
        $movies = Movie::where('activated', 1)->get();
        return view('home', compact('movies'));
    }

    public function nonActivated($id)
    {
        // Non-aktifkan film
        $updateDataFilm = Movie::where('id', $id)->update([
            'activated' => 0
        ]);

        if ($updateDataFilm) {
            return redirect()->route('admin.movies.index')->with('success', 'Berhasil menon-aktifkan film');
        } else {
            return redirect()->back()->with('error', 'Gagal! silahkan coba lagi');
        }
    }

    public function detail($id)
    {
        $movie = Movie::findOrFail($id);
        return view('schedule.detail-film', compact('movie'));
    }
}
