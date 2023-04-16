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

Route::get('/adminaccess', function () {
    return view('adminaccess');
});

<<<<<<< Updated upstream
Route::get('/register', function () {
    return view('register');
=======
// LOGIN/REGISTER/ADMIN/MAIN PAGE
Route::get('/loginform', [AuthController::class, 'login'])->name('login'); //second 'login' -> function
Route::post('/loginform', [AuthController::class, 'loginPost'])->name('login.post');
Route::get('/register', [AuthController::class, 'registration'])->name('register');
Route::post('/register', [AuthController::class, 'registerPost'])->name('register.post');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

// If you are admin then only you can access this page
Route::prefix('admin')->middleware(['auth', 'isAdmin'])->group(function(){

    Route::get('/adminpage', function () {
        return view('administrator.adminpage');
    })->name('adminpage');
    
    Route::get('/resourcemanage', function () {
        return view('administrator.resourcemanage');
    })->name('resourcemanage'); 
    
    Route::get('usermanage',[UsermanageController::class, 'show'])->name('usermanage');
    //Update, Delete, and Search userdata
    Route::get('delete/{id}',[UsermanageController::class, 'delete'])->name('delete');
    Route::get('adminedit/{id}',[UsermanageController::class, 'showadminedit'])->name('adminedit');
    Route::post('adminedit',[UsermanageController::class, 'update'])->name('update');
    Route::get('search',[UsermanageController::class, 'search'])->name('search');
>>>>>>> Stashed changes
});

// If you are student/teacher then only you can access this page
Route::group(['middleware' => 'auth'], function() { //if the user is login only he/she can see this 
    
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
    
    Route::get('/landingpage', function () {
        return view('landingpage');
    })->name('landingpage');
    
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


//ALWAYS! php artisan optimize when modifying something inside this web.php file




















// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->name('dashboard');

// Route::get('/adminaccess', function () {
//     return view('adminaccess');
// });

// Route::get('/admin', function () {
//     return view('admin');
// });

// Route::get('/usermanage', function () {
//     return view('usermanage');
// });

// Route::get('/resourcemanage', function () {
//     return view('resourcemanage');
// });

// Route::get('/landingpage', function () {
//     return view('landingpage');
// });

// Route::get('/favorites', function () {
//     return view('favorites');
// });

// // LAYOUTS
// Route::get('/subjectlayout', function () {
//     return view('layout.subjectlayout');
// });

// Route::get('/resourcelayout', function () {
//     return view('layout.resourcelayout');
// });

// // COURSES
// Route::get('/bsit', function () {
//     return view('courses.bsit');
// });

// Route::get('/bacomm', function () {
//     return view('courses.bacomm');
// });

// // SUBJECTS
// Route::get('/quantitative', function () {
//     return view('subjects.quantitative');
// });


// //POST
// // to get the data in the table to update
// Route::post('/users/{id}/update', 'UserController@update');



    // Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
    // Route::get('/adminaccess', [AuthController::class, 'adminaccess'])->name('adminaccess');
    // Route::get('/admin', [AuthController::class, 'admin'])->name('admin');
    // Route::get('/usermanage', [AuthController::class, 'usermanage'])->name('usermanage');
    // Route::get('/resourcemanage', [AuthController::class, 'resourcemanage'])->name('resourcemanage');
    // Route::get('/landingpage', [AuthController::class, 'landingpage'])->name('landingpage');
    // Route::get('/favorites', [AuthController::class, 'favorites'])->name('favorites');


