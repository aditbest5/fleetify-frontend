<?php

use App\Http\Controllers\AbsentController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\auth\AuthController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\EmployeeController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Spatie\FlareClient\View;

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
Route::middleware(['check.session'])->group(function () {
    Route::get('login',function(){
        return view('auth.login');
    })->name('login');
    Route::get('signup',function(){
        return view('auth.signup');
    })->name('signup');
    Route::post('/dologin', [AuthController::class, 'login'])->name('dologin');
    Route::post('/dosignup', [AuthController::class, 'signup'])->name('dosignup');
});

Route::middleware(['check.auth'])->group(function () {
    Route::get('/dashboard', function(){
        return view('pages.dashboard');
    })->name('dashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/profile', [AccountController::class, 'profile'])->name('profile');
    Route::get('/change-password', [AccountController::class, 'change_password'])->name('change-password');

    Route::get('/employee-list', [EmployeeController::class, 'index'])->name('employee-list');
    Route::get('/edit-employee/{id}', [EmployeeController::class, 'edit'])->name('edit-employee');
    Route::get('/form-employee', [EmployeeController::class, 'create'])->name('form-employee');
    Route::get('/form-department', [DepartmentController::class, 'create'])->name('form-department');
    Route::get('/edit-department/{id}', [DepartmentController::class, 'edit'])->name('edit-department');

    Route::get('/department-list', [DepartmentController::class, 'index'])->name('department-list');
    Route::get('/absent-in', [AbsentController::class, 'absent_in'])->name('absent-in');
    Route::get('/absent-out', [AbsentController::class, 'absent_out'])->name('absent-out');
    Route::get('/list-absent', [AbsentController::class, 'absent_list'])->name('list-absent');
    Route::get('/history-absent', [AbsentController::class, 'history_absent'])->name('history-absent');

});

