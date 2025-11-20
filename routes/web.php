<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ChartController;

use App\Http\Controllers\Admin\DoctorController as AdminDoctorController;
use App\Http\Controllers\Admin\ScheduleController as AdminScheduleController;
use App\Http\Controllers\Admin\PatientController as AdminPatientController;
use App\Http\Controllers\Admin\PaymentController as AdminPaymentController; 

use App\Http\Controllers\Doctor\ScheduleController as DoctorScheduleController;
use App\Http\Controllers\Doctor\AppointmentController as DoctorAppointmentController;
use App\Http\Controllers\Doctor\CertificateController as DoctorCertificateController; 

use App\Http\Controllers\Patient\JadwalController as PatientJadwalController;
use App\Http\Controllers\Patient\AppointmentController as PatientAppointmentController;

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

    Route::get('/chart-data', [ChartController::class, 'getChartData'])->name('api.chart.data'); 
});

/*
|--------------------------------------------------------------------------
| Rute ADMIN (Hanya Pantau & Manajemen User)
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('jadwal', AdminScheduleController::class);
    Route::delete('jadwal/destroy-all-empty', [AdminScheduleController::class, 'destroyAllEmpty'])->name('jadwal.destroyAllEmpty');
    Route::resource('dokter', AdminDoctorController::class);
    Route::resource('pasien', AdminPatientController::class);

    Route::get('pembayaran', [AdminPaymentController::class, 'index'])->name('payment.index');
    Route::get('pembayaran/{payment}/print', [AdminPaymentController::class, 'show'])->name('payment.show');
});

/*
|--------------------------------------------------------------------------
| Rute DOKTER (Input Diagnosa & Biaya)
|--------------------------------------------------------------------------
*/
Route::prefix('dokter')->name('dokter.')->middleware(['auth', 'role:doctor'])->group(function () {
    
    Route::get('jadwal-saya', [DoctorScheduleController::class, 'index'])->name('jadwal.index');
    Route::get('pasien-saya', [DoctorAppointmentController::class, 'index'])->name('appointment.index');
    
    Route::post('pasien-saya/{appointment}/process', [DoctorAppointmentController::class, 'processAndBill'])
         ->name('appointment.process');

    Route::get('surat/{appointment}/create', [DoctorCertificateController::class, 'create'])->name('certificate.create');
    Route::post('surat/{appointment}', [DoctorCertificateController::class, 'store'])->name('certificate.store');
    Route::get('surat/{certificate}/print', [DoctorCertificateController::class, 'print'])->name('certificate.print');


    Route::get('pembayaran/{payment}/print', [AdminPaymentController::class, 'show'])->name('payment.print');
});

/*
|--------------------------------------------------------------------------
| Rute PASIEN
|--------------------------------------------------------------------------
*/
Route::prefix('pasien')->name('pasien.')->middleware(['auth', 'role:patient'])->group(function () {
    Route::get('jadwal', [PatientJadwalController::class, 'index'])->name('jadwal.index');
    Route::get('jadwal/{schedule}/book', [PatientJadwalController::class, 'showBookingForm'])->name('jadwal.book.show');
    Route::post('jadwal/{schedule}/book', [PatientJadwalController::class, 'storeBooking'])->name('jadwal.book.store');
    Route::get('janji-temu', [PatientAppointmentController::class, 'index'])->name('appointment.index');
    Route::delete('janji-temu/{appointment}', [PatientAppointmentController::class, 'cancel'])->name('appointment.cancel');
});


/*
|--------------------------------------------------------------------------
| Rute ADMIN
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('jadwal', AdminScheduleController::class);
    Route::delete('jadwal/destroy-all-empty', [AdminScheduleController::class, 'destroyAllEmpty'])->name('jadwal.destroyAllEmpty');
    Route::resource('dokter', AdminDoctorController::class);
    Route::resource('pasien', AdminPatientController::class);

    Route::get('pembayaran', [AdminPaymentController::class, 'index'])->name('payment.index');
    Route::get('pembayaran/{payment}/print', [AdminPaymentController::class, 'show'])->name('payment.show');
    
    Route::patch('pembayaran/{payment}/lunas', [AdminPaymentController::class, 'markAsPaid'])->name('payment.lunas');
});