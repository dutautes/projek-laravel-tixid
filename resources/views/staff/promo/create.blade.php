@extends('templates.app')

@section('content')
    {{-- breadcrumbs --}}
    <div class="mt-5 w-75 d-block m-auto">
        @if (Session::get('error'))
            <div class="alert alert-danger">
                {{ Session::get('error') }}
            </div>
        @endif
        <nav data-mdb-navbar-init class="navbar navbar-expand-lg bg-body-tertiary">
            <div class="container-fluid">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('staff.promos.index') }}">Promo</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('staff.promos.index') }}">Data</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><a href="#">Tambah</a></li>
                    </ol>
                </nav>
            </div>
        </nav>
    </div>

    <div class="card my-3 p-4 w-75 mx-auto">
        <h5 class="text-center my-3">Buat Data Promo</h5>
        <form action="{{ route('staff.promos.store') }}" method="post">
            @csrf
            <div class="mb-3">
                <label for="discount" class="form-label">Diskon</label>
                <input type="number" name="discount" id="discount"
                    class="form-control @error('number') is-invalid @enderror">
                @error('discount')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="mb-3">
                <label for="type" class="form-label">Tipe Diskon</label>
                <select class="form-select" name="type" id="type" aria-label="Default select example">
                    <option selected value=" " hidden>Pilih Jenis Diskon</option>
                    <option value="rupiah">Rupiah</option>
                    <option value="percent">Persen</option>
                </select>
                @error('type')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Buat</button>
            <a href="{{ route('staff.promos.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
@endsection
