@extends('templates.app')

@section('content')
    <div class="container mt-5">
        @if (Session::get('success'))
            <div class="alert alert-success w-100 mt-3">{{ Session::get('success') }}</div>
        @endif
        <div class="d-flex justify-content-end">
            <a href="{{ route('admin.movies.index') }}" class="btn btn-secondary">Kembali</a>
        </div>
        <h5>Data Promo</h5>
        <table class="table table-bordered">
            <tr>
                <th>#</th>
                <th>Kode Promo</th>
                <th>Diskon</th>
                <th>Aksi</th>
            </tr>
            @foreach ($promoTrash as $key => $item)
                <tr>
                    <td class="text-center">{{ $key + 1 }}</td>
                    <td>{{ $item['promo_code'] }}</td>
                    <td>{{ $item['discount'] }}</td>
                    <td class="d-flex justify-content-center gap-2">
                        <form action="{{ route('staff.promos.restore', $item->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-success me-2">Kembalikan</button>
                        </form>
                        <form action="{{ route('staff.promos.delete_permanent', $item->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger"
                                onclick="return confirm('Anda yakin menghapus file ini secara permanen?')">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </table>
    </div>
@endsection
