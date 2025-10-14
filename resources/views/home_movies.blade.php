@extends('templates.app')

@section('content')
    <div class="container my-5">
        {{-- search --}}
        <form action="" method="GET"> {{-- form search menggunakan method="get" karna formnya manggil data bukan nyimpen data, actionnya kosong untuk diarahkan ke proses yang sama (tetap disini) --}}
            @csrf
            <div class="row">
                <div class="col-10">
                    <input type="text" name="search_movie" placeholder="Cari judul film..." class="form-control">
                </div>
                <div class="col-2">
                    <button type="submit" class="btn btn-primary">Cari</button>
                </div>
            </div>
        </form>
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
