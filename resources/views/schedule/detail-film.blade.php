@extends('templates.app')

@section('content')
    <div class="container pt-5">
        <div class="w-75 d-block m-auto">
            {{-- Poster + Detail Film --}}
            <div class="d-flex">
                <div style="width: 150px; height: 200px;">
                    <img src="{{ asset('storage/' . $movie->poster) }}" alt="{{ $movie->title }}" class="w-100 rounded">
                </div>
                <div class="ms-5 mt-4">
                    <h5 class="fw-bold">{{ $movie->title }}</h5>
                    <table class="table table-borderless table-sm">
                        <tr>
                            <td><b class="text-secondary">Genre</b></td>
                            <td class="ps-3">{{ $movie->genre }}</td>
                        </tr>
                        <tr>
                            <td><b class="text-secondary">Durasi</b></td>
                            <td class="ps-3">{{ $movie->duration }}</td>
                        </tr>
                        <tr>
                            <td><b class="text-secondary">Sutradara</b></td>
                            <td class="ps-3">{{ $movie->director }}</td>
                        </tr>
                        <tr>
                            <td><b class="text-secondary">Rating Usia</b></td>
                            <td class="ps-3"><span class="badge bg-danger">{{ $movie->age_rating }}+</span></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-center flex-column align-items-center">
            <ul class="nav nav-underline">
                <li class="nav-item">
                    <button class="nav-link active" aria-current="page" data-bs-toggle="tab"
                        data-bs-target="#sinopsis-tab-pane">Sinopsis</button>
                </li>
                <li class="nav-item">
                    <button class="nav-link"data-bs-toggle="tab" data-bs-target="#jadwal-tab-pane">Jadwal</button>
                </li>
            </ul>
            {{-- tab-content --}}
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="sinopsis-tab-pane" role="tabpanel" aria-labelledby="home-tab"
                    tabindex="0">
                    <div class="mt-3 w-75 d-block mx-auto" style="text-align: justify">
                        {{ $movie['description'] }}
                    </div>
                </div>
                <div class="tab-pane fade" id="jadwal-tab-pane" role="tabpanel" aria-labelledby="profile-tab"
                    tabindex="0">
                    {{-- ambil schedules dari relasi movie --}}
                    @foreach ($movie['schedules'] as $schedule)
                        <div class="p-2">
                            <div class="w-100 d-flex align-items-center gap-2z">
                                {{-- ambil nama cinema dari relasi schedule --}}
                                <i class="fa-solid fa-building"></i> <b>{{ $schedule['cinema']['name'] }}</b>
                            </div>
                            <small class="ms-3">{{ $schedule['cinema']['location'] }}</small>
                            <br>
                            <div class="d-flex flex-wrap">
                                {{-- looping hours dari schedule --}}
                                @foreach ($schedule['hours'] as $hours)
                                    <button class="btn btn-outline-secondary me-2">{{ $hours }}</button>
                                @endforeach
                            </div>
                        </div>
                        <hr>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
