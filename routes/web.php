<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;


use App\Http\Controllers\Admin\DoctorController as AdminDoctorController;
use App\Http\Controllers\Admin\ScheduleController as AdminScheduleController;
use App\Http\Controllers\Admin\PatientController as AdminPatientController;
use App\Http\Controllers\Doctor\ScheduleController as DoctorScheduleController;
use App\Http\Controllers\Doctor\AppointmentController as DoctorAppointmentController;
use App\Http\Controllers\Patient\JadwalController as PatientJadwalController;
use App\Http\Controllers\Patient\AppointmentController as PatientAppointmentController;


use App\Http\Controllers\ChartController;


/*
|--------------------------------------------------------------------------
| Rute Publik & Autentikasi
|--------------------------------------------------------------------------
*/


Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('dashboard');
    }
    return redirect()->route('login');
})->name('home');


Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'loginProcess']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'registerProcess']);
});

/*
|--------------------------------------------------------------------------
| Rute Terproteksi (Wajib Login)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::patch('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');

    Route::get('/chart-data', [ChartController::class, 'getChartData'])
         ->name('api.chart.data'); 

});

/*
|--------------------------------------------------------------------------
| Rute Khusus ADMIN (Dilindungi Middleware)
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {
    
    Route::resource('jadwal', AdminScheduleController::class);
    Route::resource('dokter', AdminDoctorController::class);
    Route::resource('pasien', AdminPatientController::class);


    Route::delete('jadwal/destroy-all-empty', [AdminScheduleController::class, 'destroyAllEmpty'])
         ->name('jadwal.destroyAllEmpty');

});

/*
|--------------------------------------------------------------------------
| Rute Khusus DOKTER (Dilindungi Middleware)
|--------------------------------------------------------------------------
*/
Route::prefix('dokter')->name('dokter.')->middleware(['auth', 'role:doctor'])->group(function () {
    
    Route::get('jadwal-saya', [DoctorScheduleController::class, 'index'])
         ->name('jadwal.index');
         
    Route::get('pasien-saya', [DoctorAppointmentController::class, 'index'])
         ->name('appointment.index');
         
    Route::patch('pasien-saya/{appointment}/complete', [DoctorAppointmentController::class, 'complete'])
         ->name('appointment.complete');
});

/*
|--------------------------------------------------------------------------
| Rute Khusus PASIEN (Dilindungi Middleware)
|--------------------------------------------------------------------------
*/
Route::prefix('pasien')->name('pasien.')->middleware(['auth', 'role:patient'])->group(function () {
    
    Route::get('jadwal', [PatientJadwalController::class, 'index'])
         ->name('jadwal.index');

    Route::get('jadwal/{schedule}/book', [PatientJadwalController::class, 'showBookingForm'])
         ->name('jadwal.book.show');
         
    Route::post('jadwal/{schedule}/book', [PatientJadwalController::class, 'storeBooking'])
         ->name('jadwal.book.store');

    Route::get('janji-temu', [PatientAppointmentController::class, 'index'])
         ->name('appointment.index');
         
    Route::delete('janji-temu/{appointment}', [PatientAppointmentController::class, 'cancel'])
         ->name('appointment.cancel');
});

/*
|--------------------------------------------------------------------------
| Rute Khusus ADMIN (Dilindungi Middleware)
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {
    
    Route::resource('jadwal', AdminScheduleController::class);
    Route::resource('dokter', AdminDoctorController::class);
    
    Route::resource('pasien', AdminPatientController::class);

});