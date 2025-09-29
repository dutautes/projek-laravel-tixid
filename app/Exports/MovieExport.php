<?php

namespace App\Exports;

use App\Models\Movie;
use Maatwebsite\Excel\Concerns\FromCollection;
// class untuk membuat th pd table excel
use Maatwebsite\Excel\Concerns\WithHeadings;
// class untuk membuat td pd table excel
use Maatwebsite\Excel\Concerns\WithMapping;
// memanipulasi tanggal dan waktu
use Carbon\Carbon;


class MovieExport implements FromCollection, WithHeadings, WithMapping
{
    private $key = 0;
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection() // untuk mengambil data apa saja yg ingin di tampilkan
    {
        return Movie::all(); // bisa setting mau ambil data yg mana aja, where()
    }

    // menentukan isi th
    public function headings(): array
    {
        return ['No', 'Judul', 'Durasi', 'Genre', 'Sutradara', 'Usia Minimal', 'Poster', 'Sinopsis', 'Status'];
    }

    // mengisi td
    public function map($movie): array
    {
        return [
            ++$this->key,
            $movie->title,
            // 02:00 jadi 02 jam 00 menit
            // format("H") : ambil jam dari duration, format("i") : ambil menit dari duration
            Carbon::parse($movie->duration)->format("H") . " Jam " . Carbon::parse($movie->duration)->format('i') . " Menit",
            $movie->genre,
            $movie->director,
            $movie->age_rating . "+",
            // poster berupa url public : asset()
            asset('storage') . "/" . $movie->poster,
            $movie->description,
            // jika activated == 1 munculkan aktif, jika tidak non-aktif
            $movie->activated == 1 ? 'Aktif' : "Non-aktif"
        ];
    }
}
