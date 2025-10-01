@extends('templates.app')

@section('content')
    @if (Session::get('success'))
        {{-- Auth::user() : mengambil data pengguna yang login --}}
        {{-- format : Auth:user()->column_di_fillable --}}
        <div class="alert alert-success w-100">{{ Session::get('success') }} <b>Selamat datang, {{ Auth::user()->name }}</b>
        </div>
    @endif
    <div class="container mt-5">
        <h5>Dashboard Petugas</h5>
    </div>
@endsection
