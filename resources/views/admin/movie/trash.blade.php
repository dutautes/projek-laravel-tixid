@extends('templates.app')

@section('content')
    <div class="container mt-5">
        @if (Session::get('success'))
            <div class="alert alert-success w-100 mt-3">{{ Session::get('success') }}</div>
        @endif
        <div class="d-flex justify-content-end">
            <a href="{{ route('admin.movies.index') }}" class="btn btn-secondary">Kembali</a>
        </div>
        <h5 class="mt-3">Data Sampah Film</h5>
        <table class="table table-bordered">
            <tr>
                <th>#</th>
                <th>Poster</th>
                <th>Judul Film</th>
                <th>Aksi</th>
            </tr>

            @foreach ($movieTrash as $key => $item)
                <tr>
                    <td class="text-center">{{ $key + 1 }}</td>
                    <td>
                        {{-- memunculkan gambar yg diupload asset('storage/' . alamat) --}}
                        <img src="{{ asset('storage/' . $item['poster']) }}" alt="{{ $item['title'] }}" width="120">
                    </td>
                    <td>{{ $item['title'] }}</td>
                    <td class="d-flex justify-content-center gap-2">
                        {{-- onclick : menjalankan fungsi javascript ketika komponen di klik --}}
                        <button class="btn btn-secondary" onclick="showModal({{ $item }})">Detail</button>
                        <form action="{{ route('admin.movies.restore', $item['id']) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-success me-2">Kembalikan</button>
                        </form>
                        <form action="{{ route('admin.movies.delete_permanent', $item['id']) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger"
                                onclick="return confirm('Anda yakin menghapus file ini secara permanen?')">Hapus
                                Permanent</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </table>
    </div>
@endsection
