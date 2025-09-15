@extends('templates.app')

@section('content')
    @if (Session::get('failed'))
        <div class="alert alert-danger">
            {{ Session::get('failed') }}
        </div>
    @endif
    <div class="mt-5 w-75 d-block m-auto">
        <nav data-mdb-navbar-init class="navbar navbar-expand-lg bg-body-tertiary">
            <div class="container-fluid">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.staffs.index') }}">Staff</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.staffs.index') }}">Data</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><a href="#">Tambah</a></li>
                    </ol>
                </nav>
            </div>
        </nav>
    </div>

    <div class="card w-75 mx-auto my-3 p-4">
        <h5 class="text-center my-3">Buat Data Pengguna</h5>
        <form action="{{ route('admin.staffs.update', $staff->id) }}" method="post">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="name" class="form-label ">Nama
                    Lengkap</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                    value="{{ $staff['name'] }}" id="name">
            </div>
            @error('name')
                <small class="text-danger">{{ $message }}</small>
            @enderror
            <div class="mb-3">
                <label for="email" class="form-label ">Email</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" name="email"
                    value="{{ $staff['email'] }}" id="email">
            </div>
            @error('email')
                <small class="text-danger">{{ $message }}</small>
            @enderror
            <div class="mb-3">
                <label for="password">Password</label>
                <input type="password" class="form-control" name="password" id="password" value="{{ $staff['password'] }}">
            </div>
            <button type="submit" class="btn btn-primary">Buat</button>
        </form>
    </div>
@endsection
