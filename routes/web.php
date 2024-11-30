<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KaryawanController;
use Illuminate\Support\Facades\DB;

Route::get('/welcome', function () {
    return view('welcome');
});

Route::get('/login-manager', function(){
    return view('login-form-manager');
});


Route::apiResource('karyawan', KaryawanController::class);

Route::get('/cek-koneksi-db', function () {
    try {
        DB::connection()->getPdo();
        return "Database terhubung!";
    } catch (\Exception $e) {
        return "Tidak dapat terhubung ke database: " . $e->getMessage();
    }
});


Route::get('about', function(){
    return view('about')
    ->with('name', 'Victoria')
    ->with('occupation', 'Astronaut')
    ->with('addr', 'simo kwagean kuburan no 26')
    ->with('campus', 'politeknik Elektronika negeri surabaya ')
    ->with('shoeSize', '45')
    ->with('title', 'about');


});

Route::get('home', function(){
    return view('home', ['title' => 'Home']);
});

Route::get('blog', function(){
    return view('blog', ['title' => 'Blog']);


});

Route::get('contact', function(){
    return view('contact', ['title' => 'Contact']);
});

Route::get('layout', function(){
    return view('layout', ['title' => 'layout']);
});
