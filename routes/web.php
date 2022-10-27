<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\SurveyController;
use \App\Http\Controllers\DemografiController;
use \App\Http\Controllers\AnalisisController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
/*
Route::get('/', function () {
    return view('welcome');
});
*/
Route::get('/', [SurveyController::class, 'dash']);

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', function() {
    return view('home');
})->name('home')->middleware('auth');

Route::resource('users', \App\Http\Controllers\UserController::class)
	->middleware('auth');
	
Route::resource('surveys', \App\Http\Controllers\SurveyController::class)
	->middleware('auth');
	
Route::get('demografi', [DemografiController::class, 'index'])
	->middleware('auth');
	
Route::get('analisis', [AnalisisController::class, 'index'])
	->middleware('auth');

Route::resource('surveysint', \App\Http\Controllers\InternalController::class)
	->middleware('auth');
	
Route::get('/unit',[App\Http\Controllers\InternalController::class, 'getUnit'])->name('ambil.data');
	
Route::get('/getquestion',[App\Http\Controllers\AnalisisController::class, 'getQuestion'])->name('question.data');

Route::get('/getintsurvey',[App\Http\Controllers\SurveyController::class, 'getUnitInternal'])->name('module1.category.data');

Route::get('/getsurvey',[App\Http\Controllers\SurveyController::class, 'getUnit'])->name('module.category.data');

Route::get('/detailsurvey/{id}',[App\Http\Controllers\SurveyController::class, 'getDetailsUnit'])->name('module.detail.data');

Route::get('/detailintsurvey/{id}',[App\Http\Controllers\SurveyController::class, 'getDetailsUnitInternal'])->name('module1.detail.data');

Route::get('/download-file', [SurveyController::class, 'download'])->name('file.buku.panduan');

Route::get('/find', [AnalisisController::class, 'find'])->name('es1');

Route::get('/findUPT', [AnalisisController::class, 'findUPT'])->name('upt');