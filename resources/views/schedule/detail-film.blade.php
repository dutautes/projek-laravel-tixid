@extends('templates.app')

@section('content')
    <div class="container pt-5">
        <div class="w-75 d-block m-auto">
            {{-- Poster + Detail Film --}}
            <div class="d-flex">
                <div style="width: 150px; height: 200px;">
                    <img src="https://i.pinimg.com/736x/a4/a8/d0/a4a8d0d99024be1f0d01be00aa3c3118.jpg" alt="Demon Slayer"
                        class="w-100 rounded">
                </div>
                <div class="ms-5 mt-4">
                    <h5 class="fw-bold">Demon Slayer</h5>
                    <table class="table table-borderless table-sm">
                        <tr>
                            <td><b class="text-secondary">Genre</b></td>
                            <td class="ps-3">Action, Adventure, Comedy</td>
                        </tr>
                        <tr>
                            <td><b class="text-secondary">Durasi</b></td>
                            <td class="ps-3">2 Jam 35 Menit</td>
                        </tr>
                        <tr>
                            <td><b class="text-secondary">Sutradara</b></td>
                            <td class="ps-3">Haruo Sotozaki</td>
                        </tr>
                        <tr>
                            <td><b class="text-secondary">Rating Usia</b></td>
                            <td class="ps-3"><span class="badge bg-danger">17+</span></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
