<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\CinemaController;
use App\Http\Controllers\MovieController;
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

//logout
Route::get('/logout', [UserController::class, 'logout'])->name('logout');

// Beranda
Route::get('/', [MovieController::class, 'home'])->name('home');

// http method Route::
// 1. get -> menampilkan halmaman
// 2. post -> mengambil data/menambahkan data
// 3. patch/put -> mengubah data
// 4. delete -> menghapus data


// prefix() : awalan, menulis /admin satu kali untuk 16 route CRUD (beberapa route)
// name('admin.') : biar diawali dengan admin. untuk name nya. pake titik karna nanti akan digabungkan (admin.dashboard / admin.cinemas)
// middleware('isAdmin') : memanggil middleware yg akan digunakan
// middleware : Authorization, pengaturan hak akses pengguna
Route::middleware('isAdmin')->prefix('/admin')->name('admin.')->group(function () {

    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard'); // admin dashboard

    // data bioskop
    Route::prefix('/cinemas')->name('cinemas.')->group(function () {
        // index (/)
        Route::get('/', [CinemaController::class, 'index'])->name('index');
        // create.blade.php
        Route::get('/create', function () {
            return view('admin.cinema.create');
        })->name('create');

        Route::post('/store', [CinemaController::class, 'store'])->name('store');
        // route edit
        Route::get('/edit/{id}', [CinemaController::class, 'edit'])->name('edit');
        // route update
        Route::put('/update/{id}', [CinemaController::class, 'update'])->name('update');
        // route delete
        Route::delete('/delete/{id}', [CinemaController::class, 'destroy'])->name('delete');
    });

    // data pengguna
    Route::prefix('/staffs')->name('staffs.')->group(function () {
        // index (/)
        Route::get('/', [UserController::class, 'index'])->name('index');
        // create.blade.php
        Route::get('/create', function () {
            return view('admin.staff.create');
        })->name('create');

        // store
        Route::post('/store', [UserController::class, 'store'])->name('store');
        // route edit
        Route::get('/edit/{id}', [UserController::class, 'edit'])->name('edit');
        // route update
        Route::put('/update/{id}', [UserController::class, 'update'])->name('update');
        // route delete
        Route::delete('/delete/{id}', [UserController::class, 'destroy'])->name('delete');
    });

    // data movie
    Route::prefix('/movies')->name('movies.')->group(function () {
        // index
        Route::get('/', [MovieController::class, 'index'])->name('index');
        // create
        Route::get('/create', [MovieController::class, 'create'])->name('create');
        // store
        Route::post('/store', [MovieController::class, 'store'])->name('store');
        // edit
        Route::get('/edit/{id}', [MovieController::class, 'edit'])->name('edit');
        // update
        Route::put('/update/{id}', [MovieController::class, 'update'])->name('update');
        // non-aktif button
        Route::get('/non-activated/{id}', [MovieController::class, 'nonActivated'])->name('non-activated');
        // delete
        Route::delete('/delete/{id}', [MovieController::class, 'destroy'])->name('delete');
    });
});
