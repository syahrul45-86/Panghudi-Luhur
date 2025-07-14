<?php

use App\Http\Controllers\Admin\CertificateController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Frontend\ArisanController;
use App\Http\Controllers\BendaharaController;
use App\Http\Controllers\DendaController;
use App\Http\Controllers\Frontend\BlogController;
use App\Http\Controllers\Frontend\CartController;

use App\Http\Controllers\Frontend\CourseController;
use App\Http\Controllers\Frontend\CoursePageController;
use App\Http\Controllers\Frontend\EnrolledCourseController;
use App\Http\Controllers\Frontend\FrontendContactController;
use App\Http\Controllers\Frontend\FrontendController;
use App\Http\Controllers\Frontend\HeroController;
use App\Http\Controllers\Frontend\InstructorDashboardController;
use App\Http\Controllers\Frontend\ProfileController;
use App\Http\Controllers\Frontend\StudentDashboardController;
use App\Http\Controllers\Frontend\PengumumanAnggotaController;
use App\Http\Controllers\ArisanInput;
use App\Http\Controllers\IDAnggotacontroller;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SpinController;

/**
 * ------------------------------------------------------
 * Frontend Routes
 * ------------------------------------------------------
 */

 Route::get('/', [FrontendController::class, 'index'])->name('home');
 Route::get('/kegiatan', [CoursePageController::class, 'index'])->name('kegiatan.index');
 Route::get('/kegiatan/{slug}', [CoursePageController::class, 'show'])->name('kegiatan.show');
Route::get('/about', [FrontendController::class, 'about'])->name('about.index');

 /** Cart routes */
 Route::get('cart', [CartController::class, 'index'])->name('cart.index')->middleware('auth');
 Route::get('remove-from-cart/{id}', [CartController::class, 'removeFromCart'])->name('remove-from-cart')->middleware('auth');



 /** Contact route */
 Route::get('contact', [FrontendContactController::class, 'index'])->name('contact.index');
 Route::post('contact', [FrontendContactController::class, 'sendMail'])->name('send.contact');

 /** Review Routes */
 Route::post('review', [CoursePageController::class, 'storeReview'])->name('review.store');

 /** Custom page Routes */
 Route::get('page/{slug}', [FrontendController::class, 'customPage'])->name('custom-page');

 /** Blog Routes */
 Route::get('blog', [BlogController::class, 'index'])->name('blog.index');
 Route::get('blog/{slug}', [BlogController::class, 'show'])->name('blog.show');
 Route::post('blog/comment/{id}', [BlogController::class, 'storeComment'])->name('blog.comment.store');

 Route::get('cardAnggota', [IDAnggotacontroller::class, 'index'])->name('cardanggota.index');

     Route::get('pengumuman', [PengumumanAnggotaController::class, 'index'])->name('pengumuman.index');
Route::get('/pengumuman/cetak/{id}', [PengumumanAnggotaController::class, 'cetak'])->name('pengumuman.cetak');


/**
 * ------------------------------------------------------
 * Student Routes
 * ------------------------------------------------------
 */
    // penguguman.


Route::group(['middleware' => ['auth:web', 'verified', 'check_role:anggota'], 'prefix' => 'anggota', 'as' => 'student.'], function() {
   Route::get('/dashboard', [StudentDashboardController::class, 'index'])->name('dashboard');
   Route::get('/become-instructor', [StudentDashboardController::class, 'becomeInstructor'])->name('become-instructor');
   Route::post('/become-instructor/{user}', [StudentDashboardController::class, 'becomeInstructorUpdate'])->name('become-instructor.update');

   /** Profile Routes */
   Route::get('profile', [ProfileController::class, 'index'])->name('profile.index');
   Route::post('profile/update', [ProfileController::class, 'profileUpdate'])->name('profile.update');
   Route::post('profile/update-password', [ProfileController::class, 'updatePassword'])->name('profile.update-password');
   Route::post('profile/update-social', [ProfileController::class, 'updateSocial'])->name('profile.update-social');

   /** Enroll Courses Routes */
//    Route::get('enrolled-courses', [EnrolledCourseController::class, 'index'])->name('enrolled-courses.index');
//    Route::get('course-player/{slug}', [EnrolledCourseController::class, 'payerIndex'])->name('course-player.index');
//    Route::get('get-lesson-content', [EnrolledCourseController::class, 'getLessonContent'])->name('get-lesson-content');
//    Route::post('update-watch-history', [EnrolledCourseController::class, 'updateWatchHistory'])->name('update-watch-history');
//    Route::post('update-lesson-completion', [EnrolledCourseController::class, 'updateLessonCompletion'])->name('update-lesson-completion');
//    Route::get('file-download/{id}', [EnrolledCourseController::class, 'fileDownload'])->name('file-download');


//    /** Certificate Routes */
//    Route::get('certificate/{id}/download', [CertificateController::class, 'download'])->name('certificate.download');

   /** Review Routes */
   Route::get('review', [StudentDashboardController::class, 'review'])->name('review.index');
   Route::delete('review/{id}', [StudentDashboardController::class, 'reviewDestroy'])->name('review.destroy');



//    card

});

/**
 * ------------------------------------------------------
 * Instructor Routes
 * ------------------------------------------------------
 */
Route::group(['middleware' => ['auth:web', 'verified', 'check_role:bendahara'], 'prefix' => 'bendahara', 'as' => 'instructor.'], function() {
   Route::get('/dashboard', [InstructorDashboardController::class, 'index'])->name('dashboard');

   /** Profile Routes */
   Route::get('profile', [ProfileController::class, 'instructorIndex'])->name('profile.index');
   Route::post('profile/update', [ProfileController::class, 'profileUpdate'])->name('profile.update');
   Route::post('profile/update-password', [ProfileController::class, 'updatePassword'])->name('profile.update-password');
   Route::post('profile/update-social', [ProfileController::class, 'updateSocial'])->name('profile.update-social');
   Route::post('profile/update-gateway-info', [ProfileController::class, 'updateGatewayInfo'])->name('profile.update-gateway-info');

 // denda
 Route::get('denda', [DendaController::class, 'index'])->name('denda.index');
 Route::get('denda/create', [DendaController::class, 'create'])->name('denda.create');
 Route::post('denda/store', [DendaController::class, 'store'])->name('denda.store');
 Route::get('denda/{id}/edit', [DendaController::class, 'edit'])->name('denda.edit');
 Route::put('denda/{id}', [DendaController::class, 'update'])->name('denda.update');
 Route::delete('denda/{id}', [DendaController::class, 'destroy'])->name('denda.destroy');
 Route::put('denda/update-status/{id}', [DendaController::class, 'updateStatus'])->name('denda.updateStatus');
 Route::get('denda/search', [DendaController::class, 'search'])->name('denda.search');
 Route::get('denda/print-unpaid', [DendaController::class, 'printUnpaid'])->name('denda.print_unpaid');

// catatan_arisan
Route::get('arisan', [ArisanInput::class, 'index'])->name('arisan.index');
Route::post('arisan/tahun', [ArisanInput::class, 'storeTahun'])->name('arisan.storeTahun');
Route::post('arisan/tanggal', [ArisanInput::class, 'storeTanggal'])->name('arisan.storeTanggal');
Route::post('arisan/toggleChecklist', [ArisanInput::class, 'toggleChecklist'])->name('arisan.toggleChecklist');
Route::get('arisan/showTahun', [ArisanInput::class, 'showTahun'])->name('arisan.showTahun');
Route::get('/instructor/arisan/create', [ArisanInput::class, 'create'])->name('arisan.create');
Route::post('arisan/storeAnggota', [ArisanInput::class, 'storeAnggota'])->name('arisan.storeAnggota');
Route::delete('arisan/deleteTanggal/{id}', [ArisanInput::class, 'deleteTanggal'])->name('arisan.deleteTanggal');

//

    // end
//    Bendahara
    Route::get('/bendahara/edit-saldo-awal', [BendaharaController::class, 'editSaldoAwal'])
    ->name('bendahara.edit_saldo_awal');

    Route::put('/bendahara/update-saldo-awal', [BendaharaController::class, 'updateSaldoAwal'])
    ->name('bendahara.update_saldo_awal');

    Route::post('/bendahara/saldo-awal', [BendaharaController::class, 'storeSaldoAwal'])->name('bendahara.storeSaldoAwal');
    Route::post('/bendahara/keuangan', [BendaharaController::class, 'storeKeuangan'])->name('bendahara.storeKeuangan');

    Route::get('dashboard', [InstructorDashboardController::class, 'index'])->name('dashboard');
    Route::get('bendahara', [BendaharaController::class, 'index'])->name('bendahara.index');
    Route::get('bendahara/create', [BendaharaController::class, 'create'])->name('bendahara.create');
    Route::post('bendahara/store', [BendaharaController::class, 'store'])->name('bendahara.store');
    Route::get('bendahara/{id}/edit', [BendaharaController::class, 'edit'])->name('bendahara.edit');
    Route::put('bendahara/{id}', [BendaharaController::class, 'update'])->name('bendahara.update');
    Route::delete('bendahara/{id}', [BendaharaController::class, 'destroy'])->name('bendahara.destroy');
//
   /** Orders Routes */
   Route::get('denda', [DendaController::class, 'index'])->name('denda.index');

 // spin


 Route::get('spin', [ArisanController::class, 'index'])->name('spins.index');
 Route::post('spin', [ArisanController::class, 'spin'])->name('spins.spin');

 // end
Route::post('arisan/tambah-anggota', [ArisanInput::class, 'addAnggota'])->name('arisan.addAnggota');
Route::delete('arisan/hapus-anggota', [ArisanInput::class, 'removeAnggota'])->name('arisan.removeAnggota');




   /** lfm Routes */
   Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth']], function () {
         \UniSharp\LaravelFilemanager\Lfm::routes();
   });

});




require __DIR__.'/auth.php';

require __DIR__.'/admin.php';
