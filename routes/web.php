<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\UsermanageController;
use App\Http\Controllers\ChartController;
use App\Http\Controllers\AuthenticatedController;
use App\Http\Controllers\ResourceController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\JournalController;
use App\Http\Controllers\DiscussionsController;



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

    Route::get('/adminresourcemanage', function () {
        return view('administrator.adminresourcemanage');
    })->name('adminresourcemanage'); 
    Route::get('/adminresourcemanage', 'App\Http\Controllers\ResourceController@showAdminResourceManage')->name('adminresourcemanage');
    
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

// -------------------------- STUDENT-TEACHER-PROGRAMCOORDINATOR-DEPARTMENTCHAIR-ADMIN --------------------------------//
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
    Route::resource('discussions', 'App\Http\Controllers\DiscussionsController');
    Route::delete('/discussions/{discussion}', [DiscussionsController::class, 'destroy'])->name('discussions.destroy');

    Route::get('/dashboard',[ChartController::class, 'showDashboard'])->name('dashboard');

    Route::get('/download{file}',[ResourceController::class, 'download'])->name('download');

    
    Route::get('/favorites', function () {
        return view('favorites');
    });
    // JOURNAL
    Route::get('/journals', [JournalController::class, 'index'])->name('journals.index');
    Route::get('/journals/create', [JournalController::class, 'create'])->name('journals.create');
    Route::post('/journals', [JournalController::class, 'store'])->name('journals.store');
    Route::get('/journals/{journal}', [JournalController::class, 'show'])->name('journals.show');
    Route::get('/journals/{journal}/edit', [JournalController::class, 'edit'])->name('journals.edit');
    Route::put('/journals/{journal}', [JournalController::class, 'update'])->name('journals.update');
    Route::delete('/journals/{journal}', [JournalController::class, 'destroy'])->name('journals.destroy');
    
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
        Route::get('/teachermanage', 'App\Http\Controllers\ResourceController@showTeacherManage')->name('teacher.manage');
    });
    Route::post('/resources', [ResourceController::class, 'storeResource'])->name('resources.store');

    // Route to get subjects by course ID
    Route::get('/api/subjects/{courseId}', [SubjectController::class, 'getSubjectsByCourse']);
    
    // Route to get courses by college ID
    Route::get('/api/courses/{collegeId}', [CourseController::class, 'getCoursesByCollege']);

    Route::delete('/resources/{resource}', [ResourceController::class, 'destroy'])->name('resources.destroy');
    Route::get('/resources/{resource}/edit', [ResourceController::class, 'edit'])->name('resources.edit');
    Route::put('/resources/{resource}', [ResourceController::class, 'update'])->name('resources.update');
});

// -------------------------- VERIFIER ACCESS --------------------------------//
Route::group(['middleware' => ['auth', 'Authenticated']], function () {
    Route::group(['middleware' => ['role:programcoordinator,departmentchair']], function () {
        Route::get('/resourcemanage', 'App\Http\Controllers\ResourceController@showResourceManage')->name('resourcemanage');
        Route::put('/resources/{resource}/approve', [ResourceController::class, 'approve'])->name('resources.approve');
        Route::put('/resources/{resource}/disapprove', [ResourceController::class, 'disapprove'])->name('resources.disapprove');
    });
});



//ALWAYS! php artisan optimize when modifying something inside this web.php file


