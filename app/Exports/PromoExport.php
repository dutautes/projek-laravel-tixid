<?php

namespace App\Exports;

use App\Models\Promo;
use Maatwebsite\Excel\Concerns\FromCollection;
// class untuk membuat th pd table excel
use Maatwebsite\Excel\Concerns\WithHeadings;
// class untuk membuat td pd table excel
use Maatwebsite\Excel\Concerns\WithMapping;
// memanipulasi tanggal dan waktu
use Carbon\Carbon;

class PromoExport implements FromCollection, WithHeadings, WithMapping
{
    private $key = 0; // buat nomor baris
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection() // buat ngambil dari
    {
        return Promo::all();
    }

    // th
    public function headings(): array
    {
        return ['No', 'Kode Promo', 'Total Potongan'];
    }

    // td
    public function map($promos): array
    {
        return [
            ++$this->key,
            $promos->promo_code,
            // jika percent maka % jika tidak Rp.
            $promos->type == 'percent' ? $promos->discount . '%' : 'Rp. ' . number_format($promos->discount, 0, ',', '.')
        ];
    }
}
