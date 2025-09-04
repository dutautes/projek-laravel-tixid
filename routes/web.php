<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\CinemaController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () { // home
    return view('home');
})->name('home');
// memberi nama untuk route agar bisa dipanggiil
// path : kebab, name : snake

// route - controller - model - view : memerlukan data
// route - view : tanpa data

Route::get('/schedules', function () { // schedule
    return view('schedule.detail-film');
})->name('schedules.detail');

Route::middleware('isGuest')->group(function () {
    // Authentication
    Route::get('/login', function () { // login
        return view('login');
    })->name('login');

    Route::post('/login', [UserController::class, 'loginAuth'])->name('login.auth');

    Route::get('/sign-up', function () { // signup
        return view('signup');
    })->name('sign_up');

    Route::post('/sign-up', [UserController::class, 'signUp'])->name('sign_up.add');
});


// http method Route::
// 1. get -> menampilkan halmaman
// 2. post -> mengambil data/menambahkan data
// 3. patch/put -> mengubah data
// 4. delete -> menghapus data

Route::get('/logout', [UserController::class, 'logout'])->name('logout');

// prefix() : awalan, menulis /admin satu kali untuk 16 route CRUD (beberapa route)
// name('admin.') : biar diawali dengan admin. untuk name nya. pake titik karna nanti akan digabungkan (admin.dashboard / admin.cinemas)
// middleware('isAdmin') : memanggil middleware yg akan digunakan
// middleware : Authorization, pengaturan hak akses pengguna
Route::middleware('isAdmin')->prefix('/admin')->name('admin.')->group(function () {

    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard'); // admin dashboard
    // bioskop
    Route::prefix('/cinemas')->name('cinemas.')->group(function () {

        Route::get('/', [CinemaController::class, 'index'])->name('index');

        Route::get('create', function () {
            return view('admin.cinema.create');
        })->name('create');

        Route::post('/store', [CinemaController::class, 'store'])->name('store');

        Route::get('/edit/{id}', [CinemaController::class, 'edit'])->name('edit');
        Route::put('/updated/{id}', [CinemaController::class, 'update'])->name('edit');
    });
});
