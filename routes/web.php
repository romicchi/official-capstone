<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AcademicsController;
use App\Http\Controllers\UsermanageController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\ChartController;
use App\Http\Controllers\AuthenticatedController;
use App\Http\Controllers\ResourceController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\JournalController;
use App\Http\Controllers\DiscussionsController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\BackupRestoreController;
use App\Http\Controllers\FavoriteController;


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

// -------------------------- LOGIN --------------------------------//
Route::get('/login', [AuthController::class, 'login'])->name('login'); //second 'login' -> function
Route::post('/loginform', [AuthController::class, 'loginPost'])->name('login.post');

// -------------------------- REGISTER --------------------------------//
Route::get('/register', [AuthController::class, 'registration'])->name('register');
Route::post('/register/upload', [AuthController::class, 'registerPost'])->name('register.post');

// -------------------------- LOG-OUT --------------------------------//
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');



// If you are admin then only you can access this page
// -------------------------- ADMIN ACCESS --------------------------------//
Route::prefix('admin')->middleware(['auth', 'isAdmin'])->group(function(){
    // -------------------------- ADMIN PAGES --------------------------------//

    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('adminpage');
    Route::get('/get-chart-data', [AdminController::class, 'getChartData'])->name('get.chart.data');
    Route::get('/adminnavlayout', [AdminController::class, 'adminnav'])->name('adminnavlayout');
    Route::get('/generate-report', [AdminController::class, 'generateReport'])->name('generate.report');
    Route::post('/generate-pdf-report', [AdminController::class, 'generatePDFReport'])->name('generate.pdf.report');

    Route::get('/adminresourcemanage', 'App\Http\Controllers\ResourceController@showAdminResourceManage')->name('adminresourcemanage');
    Route::put('/resources/{resource}/approve', [ResourceController::class, 'adminapprove'])->name('adminresources.approve');
    Route::put('/resources/{resource}/disapprove', [ResourceController::class, 'admindisapprove'])->name('adminresources.disapprove');
    Route::get('/resources/search', [ResourceController::class, 'adminsearchResources'])->name('adminresources.search');

    Route::get('usermanage',[UsermanageController::class, 'show'])->name('usermanage');
    Route::get('usermanage/verify-users',[UsermanageController::class, 'verifyUsers'])->name('verify-users');
    Route::post('usermanage/verify-users',[UsermanageController::class, 'postVerifyUsers'])->name('verify-users.post');
    Route::get('/usermanage/filterByRole',[UsermanageController::class, 'filterByRole'])->name('filterByRole');
    Route::get('/usermanage/filterPendingByRole', [UsermanageController::class, 'filterPendingByRole'])->name('filterPendingByRole');
    Route::get('/usermanage/filterArchiveByRole', [UsermanageController::class, 'filterArchiveByRole'])->name('filterArchiveByRole');
    Route::get('/usermanage/sortarchive', [UsermanageController::class, 'sortArchive'])->name('sortArchive');
    Route::get('/usermanage/sortexisting', [UsermanageController::class, 'sortExisting'])->name('sortExisting');
    Route::get('/usermanage/sortpending', [UsermanageController::class, 'sortPending'])->name('sortPending');


    // -------------------------- USER: ADD-UPDATE-DELETE-SEARCH-ARCHIVE --------------------------------//
    Route::get('delete/{id}',[UsermanageController::class, 'delete'])->name('delete');
    Route::get('adminedit/{id}',[UsermanageController::class, 'showadminedit'])->name('adminedit');
    Route::post('adminedit',[UsermanageController::class, 'update'])->name('update');
    Route::get('search',[UsermanageController::class, 'search'])->name('search');
    Route::get('/search-archive',[UsermanageController::class, 'searchArchive'])->name('searchArchive');
    Route::get('/search-pending',[UsermanageController::class, 'searchPending'])->name('searchPending');
    Route::get('adminadd',[UsermanageController::class, 'showadminadd'])->name('adminadd');
    Route::post('/add.user', [UsermanageController::class, 'addUser'])->name('add.user');
    Route::get('/usermanage/archiveviewable', [UsermanageController::class, 'archiveViewable'])->name('archiveViewable');
    Route::get('/archive/{id}', [UsermanageController::class, 'archive'])->name('archive');
    Route::get('/reactivate/{id}', [UsermanageController::class, 'reactivate'])->name('reactivate');
    Route::get('/delete-archive/{id}', [UsermanageController::class, 'deleteArchive'])->name('delete-archive');


    // -------------------------- ACADEMICS: ADD-UPDATE-DELETE-SEARCH --------------------------------//
    Route::get('/academics', [AcademicsController::class, 'index'])->name('academics.index');
    Route::get('/academics/create/college', [AcademicsController::class, 'createCollege'])->name('academics.createCollege');
    Route::post('/academics/store/college', [AcademicsController::class, 'storeCollege'])->name('academics.storeCollege');
    Route::get('/academics/edit/college/{id}', [AcademicsController::class, 'editCollege'])->name('academics.editCollege');
    Route::put('/academics/update/college/{id}', [AcademicsController::class, 'updateCollege'])->name('academics.updateCollege');
    Route::delete('/academics/delete/college/{id}', [AcademicsController::class, 'destroyCollege'])->name('academics.destroyCollege');
    
    Route::get('/academics/create/course', [AcademicsController::class, 'createCourse'])->name('academics.createCourse');
    Route::post('/academics/store/course', [AcademicsController::class, 'storeCourse'])->name('academics.storeCourse');
    Route::get('/academics/edit/course/{id}', [AcademicsController::class, 'editCourse'])->name('academics.editCourse');
    Route::put('/academics/update/course/{id}', [AcademicsController::class, 'updateCourse'])->name('academics.updateCourse');
    Route::delete('/academics/delete/course/{id}', [AcademicsController::class, 'destroyCourse'])->name('academics.destroyCourse');
    
    Route::get('/academics/create/subject', [AcademicsController::class, 'createSubject'])->name('academics.createSubject');
    Route::post('/academics/store/subject', [AcademicsController::class, 'storeSubject'])->name('academics.storeSubject');
    Route::get('/academics/edit/subject/{id}', [AcademicsController::class, 'editSubject'])->name('academics.editSubject');
    Route::put('/academics/update/subject/{id}', [AcademicsController::class, 'updateSubject'])->name('academics.updateSubject');
    Route::delete('/academics/delete/subject/{id}', [AcademicsController::class, 'destroySubject'])->name('academics.destroySubject');

    Route::get('/academics/search/course', [AcademicsController::class, 'searchCourse'])->name('academics.searchCourse');
    Route::get('/academics/search/subject', [AcademicsController::class, 'searchSubject'])->name('academics.searchSubject');

    Route::get('academics/filter-courses', [AcademicsController::class, 'filterCourses'])->name('academics.filterCourses');
    Route::get('academics/filter-subjects', [AcademicsController::class, 'filterSubjects'])->name('academics.filterSubjects');

    Route::get('/backup-restore/login', [BackupRestoreController::class, 'showLoginForm'])->name('administrator.login');
    Route::post('/backup-restore/login', [BackupRestoreController::class, 'login'])->name('administrator.login.submit');
    Route::post('/backup-restore/backup', [BackupRestoreController::class, 'backup'])->name('administrator.backup');
    Route::post('/backup-restore/restore', [BackupRestoreController::class, 'restore'])->name('administrator.restore');
    
    Route::middleware(['auth', 'role:4'])->group(function () {
        Route::get('backup-restore/dashboard', [BackupRestoreController::class, 'dashboard'])->name('administrator.dashboard');
        Route::post('/backup-restore/backup', [BackupRestoreController::class, 'backup'])->name('administrator.backup');
        Route::post('/backup-restore/restore', [BackupRestoreController::class, 'restore'])->name('administrator.restore');
    });

});

// -------------------------- STUDENT-TEACHER-ADMIN --------------------------------//
Route::middleware(['profanity'])->group(function () {
Route::group(['middleware' => 'auth', 'Authenticated'], function() { //if the user is login only he/she can see this 

    Route::get('/usernav', [AdminController::class, 'usernav'])->name('usernav');
    
    //FORUM/DISCUSSION
    Route::get('/create', function () {
        return view('discussions.create');
    })->name('create');
    
    Route::resource('discussions', 'App\Http\Controllers\DiscussionsController');
    Route::delete('/discussions/{discussion}', [DiscussionsController::class, 'destroy'])->name('discussions.destroy');

    // Add the route for updating discussions
    Route::get('/discussions/{discussion}/edit', [DiscussionsController::class, 'edit'])->name('discussions.edit');
    Route::patch('/discussions/{discussion}', [DiscussionsController::class, 'update'])->name('discussions.update');    

    // discussion-discussionid-replies: This means that the replies will depend to discussions
    Route::resource('discussions/{discussion}/replies', 'App\Http\Controllers\RepliesController');
    Route::get('/get-courses/{channel}', [DiscussionsController::class, 'getCoursesByChannel'])->name('get-courses');

    
    Route::get('/dashboard',[ChartController::class, 'showDashboard'])->name('dashboard');
    
    // JOURNAL
    Route::get('/journals', [JournalController::class, 'index'])->name('journals.index');
    Route::get('/journals/create', [JournalController::class, 'create'])->name('journals.create');
    Route::post('/journals', [JournalController::class, 'store'])->name('journals.store');
    Route::get('/journals/{journal}', [JournalController::class, 'show'])->name('journals.show');
    Route::get('/journals/{journal}/edit', [JournalController::class, 'edit'])->name('journals.edit');
    Route::put('/journals/{journal}', [JournalController::class, 'update'])->name('journals.update');
    Route::delete('/journals/{journal}', [JournalController::class, 'destroy'])->name('journals.destroy');

    // FAVORITES
    Route::get('/favorites',[FavoriteController::class, 'showFavorites'])->name('favorites');
    Route::post('resource/toggle-favorite', [ResourceController::class, 'toggleFavorite'])->name('resource.toggleFavorite');

    // SETTINGS
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings');
    Route::post('/settings/update-profile', [SettingsController::class, 'updateProfile'])->name('update-profile');
    Route::post('/settings/change-password', [SettingsController::class, 'changePassword'])->name('changePassword');
    Route::get('/settings/password', [SettingsController::class, 'updatePassword'])->name('user.updatePassword');
    
    // SUBJECTS & RESOURCES
    Route::get('/subjects', [ResourceController::class, 'subjects'])->name('show.subjects');
    Route::get('/resources', [ResourceController::class, 'resources'])->name('show.resources');
    
    Route::get('/download{file}',[ResourceController::class, 'download'])->name('download');
    Route::get('/resource/show/{resource}', [ResourceController::class, 'show'])->name('resource.show');
}); 

// Special Route for Teacher Role only
// -------------------------- TEACHER ACCESS --------------------------------//
Route::group(['middleware' => ['auth', 'Authenticated']], function () {
    Route::group(['middleware' => ['role:2']], function () {
        Route::get('/teachermanage', 'App\Http\Controllers\ResourceController@showTeacherManage')->name('teacher.manage');

    // -------------------------- TEACHER UPLOAD --------------------------------//
   
    });
    Route::post('/teachermanage/upload', [ResourceController::class, 'storeResource'])->name('resources.store');

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
    Route::group(['middleware' => ['role:3']], function () {
        Route::get('/resourcemanage', 'App\Http\Controllers\ResourceController@showResourceManage')->name('resourcemanage');
        Route::put('/resources/{resource}/approve', [ResourceController::class, 'approve'])->name('resources.approve');
        Route::put('/resources/{resource}/disapprove', [ResourceController::class, 'disapprove'])->name('resources.disapprove');
        Route::get('/resources/search', [ResourceController::class, 'searchResources'])->name('resources.search');
    });
});

Route::get('/embed/{resource}', [ResourceController::class, 'showEmbed'])->name('embed');

});





//ALWAYS! php artisan optimize when modifying something inside this web.php file


