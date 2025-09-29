<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
// class untuk membuat th pd table excel
use Maatwebsite\Excel\Concerns\WithHeadings;
// class untuk membuat td pd table excel
use Maatwebsite\Excel\Concerns\WithMapping;
// memanipulasi tanggal dan waktu
use Carbon\Carbon;

class UserExport implements FromCollection, WithHeadings, WithMapping
{
    private $key = 0;
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection() // ngambil data user
    {
        return User::orderBy('role', 'ASC')->get();
    }

    // th
    public function headings(): array
    {
        return ['No', 'Nama', 'Email', 'Role', 'Tanggal Bergabung'];
    }

    // td
    public function map($staffs): array
    {
        return [
            ++$this->key,
            $staffs->name,
            $staffs->email,
            $staffs->role,
            Carbon::parse($staffs->created_at)->format('d-m-y')
        ];
    }
}
