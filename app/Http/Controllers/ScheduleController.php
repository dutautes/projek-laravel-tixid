<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\Cinema;
use App\Models\Movie;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables; // class laravel yajra " datatables

class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // data untuk select
        $cinemas = Cinema::all();
        $movies = Movie::all();

        // with() : mengambil fungsi relasi dari model, untuk mengakses detail relasi ga cuman primary aja
        $schedules = Schedule::with(['cinema', 'movie'])->get();

        return view('staff.schedule.index', compact('cinemas', 'movies', 'schedules'));
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
        $request->validate([
            'cinema_id' => 'required',
            'movie_id' => 'required',
            'price' => 'required|numeric',
            // karena hours array, jd yg divalidasi itemnya -> 'hours.*'
            'hours.*' => 'required'
        ], [
            'cinema_id.required' => 'Bioskop harus dipilih.',
            'movie_id.required' => 'Film harus dipilih.',
            'price.required' => 'Harga harus diisi.',
            'price.numeric' => 'Harga harus berupa angka.',
            'hours.*.required' => 'Jam harus diisi minimal satu data jam.',
        ]);

        // ambil data jika sudah ada berdasarkan bioskop dan film yg sama
        $schedule = Schedule::where('cinema_id', $request->cinema_id)->where('movie_id', $request->movie_id)->first();
        // jika ada data yg bioskop dan filmnya sama
        if ($schedule) {
            // ambil data jam yg sebelumnya
            $hours = $schedule['hours'];
        } else {
            // kalau belum ada data, hours dibuat kosong dulu
            $hours = [];
        }
        // gabungkan hours sebelumnya dengan hours baru dr input ($request->hours)
        $mergeHours = array_merge($hours, $request->hours);
        // jika ada jam yg sama, hilangkan duplikasi data
        // gunakan data jam ini untuk database
        $newHours = array_unique($mergeHours);

        // updateOrCreate : mengubah data kalau uda ada, tambah kalo blm ada
        $createData = Schedule::updateOrCreate([
            // acuan update berdasarkan data bioskop dan fulm yg sama
            'cinema_id' => $request->cinema_id,
            'movie_id' => $request->movie_id
        ], [
            'price' => $request->price,
            'hours' => $newHours,
        ]);

        if ($createData) {
            return redirect()->route('staff.schedules.index')->with('success', 'Jadwal berhasil ditambahkan.');
        } else {
            return redirect()->back()->with('error', 'Jadwal gagal ditambahkan.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Schedule $schedule)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Schedule $schedule, $id)
    {
        $schedule = Schedule::where('id', $id)->with(['cinema', 'movie'])->first();

        return view('staff.schedule.edit', compact('schedule'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Schedule $schedule, $id)
    {
        $request->validate([
            'price' => 'required|numeric',
            // karena hours array, jd yg divalidasi itemnya -> 'hours.*'
            'hours.*' => 'required|date_format:H:i'
        ], [
            'price.required' => 'Harga harus diisi.',
            'price.numeric' => 'Harga harus berupa angka.',
            'hours.*.required' => 'Jam harus diisi minimal satu data jam.',
            'hours.*.date_format' => 'Format jam tidak valid. Gunakan format jam:menit.',
        ]);

        $updateData = Schedule::where('id', $id)->update([
            'price' => $request->price,
            'hours' => $request->hours
        ]);

        if ($updateData) {
            return redirect()->route('staff.schedules.index')->with('success', 'Berhasil mengubah data!');
        } else {
            return redirect()->back()->with('error', 'Jadwal gagal diubah.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Schedule $schedule, $id)
    {
        Schedule::where('id', $id)->delete();
        return redirect()->route('staff.schedules.index')->with('success', 'Berhasil menghapus data!');
    }

    public function trash()
    {
        // ORM yang digunakan terkait sodfdeletes
        // onlyTrashed() -> filter data yang sudah dihapus, delete_at BUKAN NULL
        // restore() -> mengembalikan data yang sudah dihapus (menghapus nilai tanggal pada deleted_at)
        // forceDelete() -> menghapus data secara permanen, data dihilangkan bahkan dari databasenya
        $scheduleTrash = Schedule::with(['cinema', 'movie'])->onlyTrashed()->get();
        return view('staff.schedule.trash', compact('scheduleTrash'));
    }

    public function restore($id)
    {
        $schedule = Schedule::onlyTrashed()->find($id);
        $schedule->restore();
        return redirect()->route('staff.schedules.index')->with('success', 'Berhasil mengembalikan data!');
    }

    public function deletePermanent($id)
    {
        $schedule = Schedule::onlyTrashed()->find($id);
        $schedule->forceDelete();
        return redirect()->back()->with('success', 'Berhasil menghapus data secara permanen!');
    }

    public function datatables()
    {
        $schedules = Schedule::with(['cinema', 'movie']);
        return DataTables::of($schedules)
            ->addIndexColumn()
            ->addColumn('price', function ($schedule) {
                return 'Rp. ' . number_format($schedule['price'], 0, ',', '.');
            })
            ->addColumn('hours_lists', function ($schedule) {
                $html = '<ul>';
                foreach ($schedule['hours'] as $hour) {
                    $html .= '<li>' . $hour . '</li>';
                }
                $html .= '</ul>';

                return $html;
            })
            ->addColumn('action', function ($schedule) {
                $btnEdit = '<a href="' . route('staff.schedules.edit', $schedule->id) . '" class="btn btn-primary">Edit</a>';
                $btnDelete = '<form action="' . route('staff.schedules.delete', $schedule->id) . '" method="POST" style="display:inline-block">
                            ' . csrf_field() . method_field('DELETE') . '
                            <button type="submit" class="btn btn-danger">Hapus</button>
                          </form>';

                return '<div class="d-flex justify-content-center align-items-center gap-2">' . $btnEdit . $btnDelete . '</div>';
            })
            ->rawColumns(['action', 'hours_lists'])
            ->make(true);
    }
}
