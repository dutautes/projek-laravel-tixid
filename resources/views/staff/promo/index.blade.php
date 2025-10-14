@extends('templates.app')

@section('content')
    <div class="container mt-5">
        @if (Session::get('success'))
            <div class="alert alert-success">{{ Session::get('success') }}</div>
        @endif
        <div class="d-flex justify-content-end">
            <a href="{{ route('staff.promos.trash') }}" class="btn btn-secondary me-2">Data Sampah</a>
            <a href="{{ route('staff.promos.export') }}" class="btn btn-secondary me-2">Export (.xlsx)</a>
            <a href="{{ route('staff.promos.create') }}" class="btn btn-success">Tambah Data</a>
        </div>
        <h5>Data Promo</h5>
        <table class="table table-bordered">
            <tr>
                <th>No</th>
                <th>Kode Promo</th>
                <th>Diskon</th>
                <th>Tipe</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
            @foreach ($promos as $key => $item)
                <tr>
                    <td class="text-center">{{ $key + 1 }}</td>
                    <td>{{ $item['promo_code'] }}</td>
                    <td>{{ $item['discount'] }}</td>
                    <td>{{ $item['type'] }}</td>
                    <td>
                        @if ($item['activated'] == 1)
                            <span class="badge badge-success">aktif</span>
                        @else
                            <span class="badge badge-danger">tidak aktif</span>
                        @endif
                    </td>
                    <td class="d-flex justify-content-start gap-2">
                        <a href="{{ route('staff.promos.edit', $item->id) }}" class="btn btn-primary">Edit</a>
                        <form action="{{ route('staff.promos.delete', $item->id) }}" method="post">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Hapus</button>
                        </form>
                        {{-- jika activated true, munculkan opsi untuk non-aktif film --}}
                        @if ($item['activated'] == 1)
                            <a href="{{ route('staff.promos.non-activated', $item->id) }}"
                                class="btn btn-warning">Non-aktif</a>
                        @else
                            {{-- none --}}
                        @endif
                    </td>
                </tr>
            @endforeach
        </table>
    </div>
@endsection
