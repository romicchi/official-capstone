<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\UsermanageController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\ChartController;
use App\Http\Controllers\AuthenticatedController;
use App\Http\Controllers\ResourceController;


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

//ALWAYS! php artisan optimize when modifying something inside this web.php file

Route::get('/', function () {
    return view('welcome');
});

Route::get('/homenav', function () {
    return view('layout.homenav');
});

// LOGIN/REGISTER/ADMIN/MAIN PAGE
// -------------------------- LOGIN --------------------------------//
Route::get('/loginform', [AuthController::class, 'login'])->name('login'); //second 'login' -> function
Route::post('/loginform', [AuthController::class, 'loginPost'])->name('login.post');

// -------------------------- REGISTER --------------------------------//
Route::get('/register', [AuthController::class, 'registration'])->name('register');
Route::post('/register', [AuthController::class, 'registerPost'])->name('register.post');

// -------------------------- LOG-OUT --------------------------------//
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

// If you are admin then only you can access this page
// -------------------------- ADMIN ACCESS --------------------------------//
Route::prefix('admin')->middleware(['auth', 'isAdmin'])->group(function(){
    // -------------------------- ADMIN PAGES --------------------------------//
    Route::get('/adminpage', function () {
        return view('administrator.adminpage');
    })->name('adminpage');
    
    Route::get('/resourcemanage', function () {
        return view('administrator.resourcemanage');
    })->name('resourcemanage'); 
    
    Route::get('usermanage',[UsermanageController::class, 'show'])->name('usermanage');
    Route::get('usermanage/verify-users',[UsermanageController::class, 'verifyUsers'])->name('verify-users');
    Route::post('usermanage/verify-users',[UsermanageController::class, 'postVerifyUsers'])->name('verify-users.post');

    // -------------------------- ADD-UPDATE-DELETE-SEARCH --------------------------------//
    Route::get('delete/{id}',[UsermanageController::class, 'delete'])->name('delete');
    Route::get('adminedit/{id}',[UsermanageController::class, 'showadminedit'])->name('adminedit');
    Route::post('adminedit',[UsermanageController::class, 'update'])->name('update');
    Route::get('search',[UsermanageController::class, 'search'])->name('search');
    Route::get('adminadd',[UsermanageController::class, 'showadminadd'])->name('adminadd');
    Route::post('/add.user', [UsermanageController::class, 'addUser'])->name('add.user');
});

// -------------------------- STUDENT-TEACHER-ADMIN --------------------------------//
Route::group(['middleware' => 'auth', 'Authenticated'], function() { //if the user is login only he/she can see this 
    
    Route::resource('discussions', 'App\Http\Controllers\DiscussionsController');
    // discussion-discussionid-replies: This means that the replies will depend to discussions
    Route::resource('discussions/{discussion}/replies', 'App\Http\Controllers\RepliesController');
    
    Route::get('/create', function () {
        return view('discussions.create');
    })->name('create');

    Route::get('/forum', function () {
        return view('forum');
    })->name('forum');

    Route::get('/dashboard',[ChartController::class, 'showDashboard'])->name('dashboard');

    Route::get('/download{file}',[ResourceController::class, 'download'])->name('download');

    
    Route::get('/favorites', function () {
        return view('favorites');
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



}); 

// Special Route for Teacher Role only
// -------------------------- TEACHER ACCESS --------------------------------//
Route::group(['middleware' => ['auth', 'Authenticated']], function () {
    Route::group(['middleware' => ['role:teacher']], function () {
        Route::get('/teachermanage', function () {
            return view('teachermanage');
        });

    // -------------------------- TEACHER UPLOAD --------------------------------//
        Route::get('/teachermanage', [ImageController::class, 'manage'])->name('teachermanage');
        Route::post('/teachermanage/upload', [ImageController::class, 'upload'])->name('teachermanage.upload');
        Route::delete('/delete/{id}', [ImageController::class, 'delete'])->name('file.delete');
        Route::get('/teachermanage',[ResourceController::class, 'showTeacherManage'])->name('teachermanage');
    });
});

// -------------------------- VERIFIER ACCESS --------------------------------//
Route::group(['middleware' => ['auth', 'Authenticated']], function () {
    Route::group(['middleware' => ['role:programcoordinator,departmentchair']], function () {
        Route::get('/resmanage', function () {
            return view('resmanage');
        })->name('resmanage');
    });
});







//ALWAYS! php artisan optimize when modifying something inside this web.php file


