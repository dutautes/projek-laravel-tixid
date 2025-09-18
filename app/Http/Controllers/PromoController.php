<?php

namespace App\Http\Controllers;

use App\Models\Promo;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PromoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $promos = Promo::all();
        return view('staff.promo.index', compact('promos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('staff.promo.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'discount' => 'required',
            'type' => 'required'
        ], [
            'discount.required' => 'Diskon harus diisi',
            'type.required' => 'Tipe diskon harus diisi'
        ]);
        $promoCode = Str::random(8);

        $createData = Promo::create([
            'promo_code' => $promoCode,
            'discount' => $request->discount,
            'type' => $request->type,
            'activated' => 1,
        ]);

        if ($createData) {
            return redirect()->route('staff.promos.index')->with('success', 'Data promo berhasil ditambahkan');
        } else {
            return redirect()->back()->with('error', 'Data promo gagal ditambahkan');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Promo $promo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $promo = Promo::find($id);
        return view('staff.promo.edit', compact('promo'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'discount' => 'required',
            'type' => 'required'
        ], [
            'discount.required' => 'Diskon harus diisi',
            'type.required' => 'Tipe diskon harus diisi'
        ]);
        $promoCode = Str::random(8);

        $updateData = Promo::where('id', $id)->update([
            'promo_code' => $promoCode,
            'discount' => $request->discount,
            'type' => $request->type,
            'activated' => 1,
        ]);

        if ($updateData) {
            return redirect()->route('staff.promos.index')->with('success', 'Data promo berhasil ditambahkan');
        } else {
            return redirect()->back()->with('error', 'Data promo gagal ditambahkan');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $deletePromo = Promo::where('id', $id)->delete();
        if ($deletePromo) {
            return redirect()->route('staff.promos.index')->with('success', 'Berhasil menghapus data film!');
        } else {
            return redirect()->back()->with('failed', 'Gagal menghapus data film!');
        }
    }

    public function nonActivated($id)
    {
        $promoData = Promo::where('id', $id)->update([
            'activated' => 0
        ]);

        if ($promoData) {
            return redirect()->route('staff.promos.index')->with('success', 'Data promo berhasil di non-aktifkan');
        } else {
            return redirect()->back()->with('error', 'Data promo gagal di non-aktifkan');
        }
    }
}
