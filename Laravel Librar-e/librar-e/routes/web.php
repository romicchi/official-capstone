<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/loginform', function () {
    return view('loginform');
});

Route::get('/adminaccess', function () {
    return view('adminaccess');
});

Route::get('/register', function () {
    return view('register');
});

Route::get('/admin', function () {
    return view('admin');
});

Route::get('/usermanage', function () {
    return view('usermanage');
});

Route::get('/resourcemanage', function () {
    return view('resourcemanage');
});

Route::get('/dashboard', function () {
    return view('dashboard');
});

Route::get('/landingpage', function () {
    return view('landingpage');
});

Route::get('/bsit', function () {
    return view('bsit');
});

// sample
Route::get('/bsit2', function () {
    return view('bsit2');
});

Route::get('/subjectlayout', function () {
    return view('layout.subjectlayout');
});

Route::get('/quantitative', function () {
    return view('subjects.quantitative');
});


