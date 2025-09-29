@extends('templates.app')

@section('content')
    @if (Session::get('success'))
        <div class="alert alert-success alert-dismissible fade show alert-top-right" role="alert">
            {{ Session::get('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if (Session::get('failed'))
        <div class="alert alert-danger my-3">{{ Session::get('failed') }}</div>
    @endif
    <div class="container mt-3">
        <div class="d-flex justify-content-end mb-3 mt-4">
            <a href="{{ route('admin.staffs.export') }}" class="btn btn-secondary me-2">Export (.xlsx)</a>
            <a href="{{ route('admin.staffs.create') }}" class="btn btn-success">Tambah Data</a>
        </div>
        <h5>Data Pengguna</h5>
        <table class="table my-3 table-bordered">
            <tr>
                <th></th>
                <th>Nama </th>
                <th>Email</th>
                <th>Role</th>
                <th>Aksi</th>
            </tr>
            {{-- looping : mengubah aray multidimensi menjadi array asosiatif --}}
            @foreach ($staffs as $key => $staff)
                <tr>
                    <td class="text-center">{{ $key + 1 }}</td>
                    <td>{{ $staff['name'] }}</td>
                    <td>{{ $staff['email'] }}</td>
                    @if ($staff['role'] == 'admin')
                        <td>
                            <span class="badge bg-primary">{{ $staff['role'] }}</span>
                        </td>
                    @endif
                    @if ($staff['role'] == 'staff')
                        <td>
                            <span class="badge bg-success">{{ $staff['role'] }}</span>
                        </td>
                    @endif
                    @if ($staff['role'] == 'user')
                        <td>
                            <span class="badge bg-secondary">{{ $staff['role'] }}</span>
                        </td>
                    @endif
                    <td class="d-flex justify-content-center gap-2">
                        <a href="{{ route('admin.staffs.edit', $staff['id']) }}" class="btn btn-info">Edit</a>
                        <form action="{{ route('admin.staffs.delete', $staff['id']) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </table>
    </div>
@endsection
