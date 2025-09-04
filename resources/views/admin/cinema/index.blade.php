@extends('templates.app')

@section('content')
    @if (Session::get('success'))
        <div class="alert alert-success alert-dismissible fade show alert-top-right" role="alert">
            {{ Session::get('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <div class="container">
        <div class="d-flex justify-content-end mb-3 mt-4">
            <a href="{{ route('admin.cinemas.create') }}" class="btn btn-success">Tambah Data</a>
        </div>
        <h5>Data Bioskop</h5>
        <table class="table my-3 table-bordered">

            <tr>
                <th></th>
                <th>Nama Bioskop</th>
                <th>Lokasi</th>
                <th>Aksi</th>
            </tr>
            {{-- looping : mengubah aray multidimensi menjadi array asosiatif --}}
            @foreach ($cinemas as $key => $cinema)
                <tr>
                    <td class="text-center">{{ $key + 1 }}</td>
                    <td>{{ $cinema->name }}</td>
                    <td>{{ $cinema->location }}</td>
                    <td class="d-flex justify-content-center gap-2">
                        <a href="" class="btn btn-info">Edit</a>
                        <button type="button" class="btn btn-danger">Hapus</button>
                    </td>
                </tr>
            @endforeach
        </table>

    </div>
@endsection
