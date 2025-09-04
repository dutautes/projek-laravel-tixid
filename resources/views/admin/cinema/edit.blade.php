@extends('templates.app')

@section('content')
    {{-- breadcrumbs --}}
    <div class="mt-5 w-75 d-block m-auto">
        @if (Session::get('failed'))
            <div class="alert alert-danger">
                {{ Session::get('failed') }}
            </div>
        @endif
        <nav data-mdb-navbar-init class="navbar navbar-expand-lg bg-body-tertiary">
            <div class="container-fluid">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.cinemas.index') }}">Cinema</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.cinemas.index') }}">Data</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><a href="#">Edit</a></li>
                    </ol>
                </nav>
            </div>
        </nav>
    </div>

    <div class="card w-75 mx-auto my-3 p-4">
        <h5 class="text-center my-3">Edit Data Bioskop</h5>
        <form action="{{ route('admin.cinemas.update', $cinema->id) }}" method="post">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="name" class="form-label">Nama Bioskop</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name"
                    value="{{ $cinema->name }}">
                @error('name')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="mb-3">
                <label for="location" class="form-label">Detail Lokasi</label>
                <textarea class="form-control @error('location') is-invalid @enderror" name="location" id="location" cols="30"
                    rows="5">{{ $cinema->location }}</textarea>
                @error('location')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Buat</button>
        </form>
    </div>
@endsection
