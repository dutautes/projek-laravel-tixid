<?php

namespace App\Exports;

use App\Models\Cinema;
use Maatwebsite\Excel\Concerns\FromCollection;
// class untuk membuat th pd table excel
use Maatwebsite\Excel\Concerns\WithHeadings;
// class untuk membuat td pd table excel
use Maatwebsite\Excel\Concerns\WithMapping;
// memanipulasi tanggal dan waktu
use Carbon\Carbon;

class CinemaExport implements FromCollection, WithHeadings, WithMapping
{
    private $key = 0;
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Cinema::all();
    }

    // th
    public function headings(): array
    {
        return ['No', 'Nama Bioskop', 'Lokasi'];
    }

    // td
    public function map($cinemas): array
    {
        return [
            ++$this->key,
            $cinemas->name,
            $cinemas->location
        ];
    }
}
