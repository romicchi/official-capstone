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

// LOGIN/REGISTER/ADMIN/MAIN PAGE
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

Route::get('/landingpage', function () {
    return view('landingpage');
});

Route::get('/dashboard', function () {
    return view('dashboard');
});

Route::get('/favorites', function () {
    return view('favorites');
});

// LAYOUTS
Route::get('/subjectlayout', function () {
    return view('layout.subjectlayout');
});

Route::get('/resourcelayout', function () {
    return view('layout.resourcelayout');
});

// COURSES
Route::get('/bsit', function () {
    return view('courses.bsit');
});

Route::get('/bacomm', function () {
    return view('courses.bacomm');
});

// SUBJECTS
Route::get('/quantitative', function () {
    return view('subjects.quantitative');
});


//POST
// to get the data in the table to update
Route::post('/users/{id}/update', 'UserController@update');



