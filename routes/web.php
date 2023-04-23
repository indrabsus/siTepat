<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ExamController;
use App\Http\Livewire\Admin\IndexAdmin;
use App\Http\Livewire\Admin\UserMgmt;
use App\Http\Livewire\Petugas\ExamMgmt;
use App\Http\Livewire\Petugas\GroupMgmt;
use App\Http\Livewire\Petugas\LogCurang;
use App\Http\Livewire\Petugas\LogUjian;
use App\Http\Livewire\Petugas\StudentMgmt;
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
Route::get('siswa/getwaktu', [ExamController::class,'getWaktu'])->name('getWaktu');
Route::get('/',[AuthController::class,'index'])->name('index');
Route::get('register',[AuthController::class,'register'])->name('register');
Route::any('/prosesregister', [AuthController::class,'prosesRegister'])->name('prosesRegister');
Route::any('/proseslogin', [AuthController::class,'login'])->name('login');
Route::get('logout',[AuthController::class,'logout'])->name('logout');
Route::get('done',[ExamController::class,'done'])->name('done');
Route::get('cit',[ExamController::class,'logc'])->name('cit');
Route::get('pdf/logc/{id}',[ExamController::class,'printLogc'])->name('printLogc');

Route::group(['middleware' => ['auth']], function(){
    Route::group(['middleware' => ['cekrole:admin']], function(){
        Route::get('admin', IndexAdmin::class)->name('indexadmin');
        Route::get('admin/usermgmt', UserMgmt::class)->name('usermgmt');
        Route::get('admin/groupmgmt', GroupMgmt::class)->name('groupmgmt');
        Route::get('admin/studentmgmt', StudentMgmt::class)->name('studentmgmt');
        Route::get('admin/exammgmt', ExamMgmt::class)->name('exammgmt');
        Route::get('admin/logujian', LogUjian::class)->name('logujian');
        Route::get('admin/logcurang', LogCurang::class)->name('logcurang');
    });
    Route::group(['middleware' => ['cekrole:petugas']], function(){
        Route::get('petugas', IndexAdmin::class)->name('indexpetugas');
        Route::get('petugas/groupmgmt', GroupMgmt::class)->name('groupmgmtpetugas');
        Route::get('petugas/studentmgmt', StudentMgmt::class)->name('studentmgmtpetugas');
        Route::get('petugas/exammgmt', ExamMgmt::class)->name('exammgmtpetugas');
        Route::get('petugas/logujian', LogUjian::class)->name('logujianpetugas');
        Route::get('petugas/logcurang', LogCurang::class)->name('logcurangpetugas');
    });
    Route::group(['middleware' => ['cekrole:siswa']], function(){
        Route::get('siswa', [ExamController::class,'listTest'])->name('indexsiswa');
        Route::any('siswa/token/{id}', [ExamController::class,'token'])->name('token');
        Route::get('siswa/cek', [ExamController::class,'indexsiswa'])->name('cek');
        Route::any('siswa/cektoken', [ExamController::class,'masukUjian'])->name('cektoken');
        

        Route::group(['middleware' => ['test']], function(){
            Route::get('siswa/test', [ExamController::class,'test'])->name('test');
        });
    });
    
});