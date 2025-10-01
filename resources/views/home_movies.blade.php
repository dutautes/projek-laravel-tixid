@extends('templates.app')

@section('content')
    <div class="container my-5">
        {{-- card film --}}
        <div class="mt-3 d-flex justify-content-center flex-wrap container gap-3">
            @foreach ($movies as $movie)
                <div class="card shadow-sm" style="width: 15rem;">
                    <img src="{{ asset('storage/' . $movie['poster']) }}" alt="{{ $movie['title'] }}";
                        style="height: 300px; abject-fit: cover;" />
                    {{-- !important : memprioritaskan, jika ada style padding dr bootstrap akan dibaca yang di style (diutamakan)  --}}
                    <div class="card-body text-center p-2" style="padding:0 !important ">
                        <p class="card-text text-center bg-primary py-2">
                            <a href="{{ route('schedule.detail', $movie->id) }}" class="text-warning"><b>Beli Tiket</b></a>
                        </p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
