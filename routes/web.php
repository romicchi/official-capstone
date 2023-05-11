<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\UsermanageController;


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

    // -------------------------- ADD-UPDATE-DELETE-SEARCH --------------------------------//
    Route::get('delete/{id}',[UsermanageController::class, 'delete'])->name('delete');
    Route::get('adminedit/{id}',[UsermanageController::class, 'showadminedit'])->name('adminedit');
    Route::post('adminedit',[UsermanageController::class, 'update'])->name('update');
    Route::get('search',[UsermanageController::class, 'search'])->name('search');
    Route::get('adminadd',[UsermanageController::class, 'showadminadd'])->name('adminadd');
    Route::post('/add.user', [UsermanageController::class, 'addUser'])->name('add.user');
});

// -------------------------- STUDENT-TEACHER-ADMIN --------------------------------//
Route::group(['middleware' => 'auth', 'student_teacher'], function() { //if the user is login only he/she can see this 
    
    Route::resource('discussions', 'App\Http\Controllers\DiscussionsController');
    // discussion-discussionid-replies: This means that the replies will depend to discussions
    Route::resource('discussions/{discussion}/replies', 'App\Http\Controllers\RepliesController');
    
    Route::get('/create', function () {
        return view('discussions.create');
    })->name('create');

    Route::get('/forum', function () {
        return view('forum');
    })->name('forum');

    // Route::get('/index', function () {
    //     return view('discussions.index');
    // })->name('index');

    // Route::get('/show', function () {
    //     return view('discussions.show');
    // })->name('show');

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    
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



}); 

// Special Route for Teacher Role only
// -------------------------- TEACHER ACCESS --------------------------------//
Route::group(['middleware' => ['auth', 'student_teacher']], function () {
    Route::group(['middleware' => ['role:teacher']], function () {
        Route::get('/teachermanage', function () {
            return view('teachermanage');
        });
    });
});

// -------------------------- VERIFIER ACCESS --------------------------------//
Route::group(['middleware' => ['auth', 'student_teacher']], function () {
    Route::group(['middleware' => ['role:programcoordinator']], function () {
        Route::get('/teachermanage', function () {
            return view('teachermanage');
        });
    });
});

Route::group(['middleware' => ['auth', 'student_teacher']], function () {
    Route::group(['middleware' => ['role:departmentchair']], function () {
        Route::get('/teachermanage', function () {
            return view('teachermanage');
        });
    });
});







//ALWAYS! php artisan optimize when modifying something inside this web.php file


