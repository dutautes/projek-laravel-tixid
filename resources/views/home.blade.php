{{-- memanggil file templates --}}
@extends('templates.app')

{{-- mengisi yield --}}
@section('content')
    @if (Session::get('success'))
        {{-- Auth::user() : mengambil data pengguna yang login --}}
        {{-- format : Auth:user()->column_di_fillable --}}
        <div class="alert alert-success w-100">{{ Session::get('success') }} <b>Selamat datang, {{ Auth::user()->name }}</b>
        </div>
    @endif
    @if (Session::get('logout'))
        <div class="alert alert-warning w-100">{{ Session::get('logout') }}</div>
    @endif
    <div class="dropdown">
        <button class="btn btn-light dropdown-toggle w-100 d-flex align-items-center" type="button" id="dropdownMenuButton"
            data-mdb-dropdown-init data-mdb-ripple-init aria-expanded="false">
            <i class="fa-solid fa-location-dot me-2"></i>Bogor
        </button>
        <ul class="dropdown-menu w-100" aria-labelledby="dropdownMenuButton">
            <li><a class="dropdown-item" href="#">Action</a></li>
            <li><a class="dropdown-item" href="#">Another action</a></li>
            <li><a class="dropdown-item" href="#">Something else here</a></li>
        </ul>
    </div>

    <div id="carouselExampleIndicators" class="carousel slide" data-mdb-ride="carousel" data-mdb-carousel-init>
        <div class="carousel-indicators">
            <button type="button" data-mdb-target="#carouselExampleIndicators" data-mdb-slide-to="0" class="active"
                aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-mdb-target="#carouselExampleIndicators" data-mdb-slide-to="1"
                aria-label="Slide 2"></button>
            <button type="button" data-mdb-target="#carouselExampleIndicators" data-mdb-slide-to="2"
                aria-label="Slide 3"></button>
        </div>
        <div class="carousel-inner">
            <div class="carousel-item  active" style="height: 500px;">
                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSP_7XPHnlyLTwN8C7MsJ1vuP8Ba5xorRCJWA&s"
                    class="d-block w-100" alt="The Land of Mine" />
            </div>
            <div class="carousel-item " style="height: 500px;">
                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSxvRtqxx_fopfddJwCyPm9UDK8yauZy8frIg&s"
                    class="d-block w-100" alt="Thanksgiving" />
            </div>
            <div class="carousel-item " style="height: 500px;">
                <img src="https://www.showtimenepal.com/storage/uploads/movies/2138-h.jpg" class="d-block w-100"
                    alt="Exotic Fruits" />
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-mdb-target="#carouselExampleIndicators"
            data-mdb-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-mdb-target="#carouselExampleIndicators"
            data-mdb-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>

    <div class="d-flex justify-content-between container mt-4">
        <div class="d-flex align-items-center gap-2">
            <i class="fa-solid fa-clapperboard"></i>
            <h5 class="mt-2">Sedang Tayang</h5>
        </div>
        <div>
            <a href="{{ route('home.movies') }}" class="btn btn-warning rounded-pill">Semua <i
                    class="fa-solid fa-angle-right"></i></a>
        </div>
    </div>

    <div class="d-flex gap-2 container">
        <button type="button" class="btn btn-outline-primary rounded-pill" data-mdb-ripple-init
            data-mdb-ripple-color="dark">Semua Film</button>
        <button type="button" class="btn btn-outline-secondary rounded-pill" data-mdb-ripple-init
            data-mdb-ripple-color="dark">XXI</button>
        <button type="button" class="btn btn-outline-secondary rounded-pill" data-mdb-ripple-init
            data-mdb-ripple-color="dark">Cinepolis
            <button type="button" class="btn btn-outline-secondary rounded-pill" data-mdb-ripple-init
                data-mdb-ripple-color="dark">Imax</button>
    </div>

    {{-- card film --}}
    <div class="mt-3 d-flex justify-content-center container gap-2">
        @foreach ($movies as $movie)
            <div class="card shadow-sm" style="width: 15rem;">
                <img src="{{ asset('storage/' . $movie['poster']) }}" alt="{{ $movie['title'] }}"
                    style="height: 300px; abject-fit: cover;" />
                {{-- !important : memprioritaskan, jika ada style padding dr bootstrap akan dibaca yang di style (diutamakan)  --}}
                <div class="card-body p-2" style="padding:0 !important ">
                    <p class="card-text text-center bg-primary py-2">
                        <a href="{{ route('schedule.detail', $movie->id) }}" class="text-warning"><b>Beli Tiket</b></a>
                    </p>
                </div>
            </div>
        @endforeach
    </div>

    <footer class="bg-body-tertiary text-center text-lg-start mt-4">
        <!-- Copyright -->
        <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.05);">
            © 2025 TixID:
            <a class="text-body" href="https://mdbootstrap.com/">tixid.com</a>
        </div>
        <!-- Copyright -->
    </footer>
@endsection
