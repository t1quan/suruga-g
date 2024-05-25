<?php

use App\Http\Controllers\Ajax\LatestJobController;
use App\Http\Controllers\Ajax\SameAreaJobController;
use App\Http\Controllers\Ajax\RecommendJobController;
use App\Http\Controllers\Ajax\FormController;
use App\Http\Controllers\ApplyConfirmController;
use App\Http\Controllers\ApplyController;
use App\Http\Controllers\ApplyThanksController;
use App\Http\Controllers\WebRegistController;
use App\Http\Controllers\WebRegistConfirmController;
use App\Http\Controllers\WebRegistThanksController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\ContentController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\TopController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', [TopController::class, 'show'])->name('top');

Route::get('/search', [SearchController::class, 'show'])->name('search');
Route::get('/search/custom', [SearchController::class, 'querySearch'])->name('search.query'); // queryParams /?job=9999&ss=1 //
Route::get('/search/{params}', [SearchController::class, 'dirSearch'])->where(['params' => '.*']);

Route::get('/job/{id}', [JobController::class, 'show'])->where('id', '[0-9]+')->name('job');

Route::get('/apply/{id}', [ApplyController::class, 'show'])->where('id', '[0-9]+');
Route::post('/apply/{id}', [ApplyController::class, 'store'])->where('id', '[0-9]+');

Route::post('/apply/confirm/{id}', [ApplyConfirmController::class, 'show'])->where('id', '[0-9]+')->name('apply.confirm');
Route::post('/apply/thanks/{id}', [ApplyThanksController::class, 'store'])->where('id', '[0-9]+')->name('apply.thanks');

// GET is not supported method redirect to prev page
Route::get('/apply/confirm/{id}', [ApplyConfirmController::class, 'create'])->where('id', '[0-9]+');
Route::get('/apply/thanks/{id}', [ApplyThanksController::class, 'create'])->where('id', '[0-9]{1,8}');
Route::get('/apply/thanks/{id}/{obosyaId}', [ApplyThanksController::class, 'create'])->where('id', '[0-9]{1,8}')->where('obosyaId', '[0-9]{1,8}');
Route::get('/apply/thanks/{id}/{obosyaId}', [ApplyThanksController::class, 'create'])->where('id', '[0-9]+')->where('obosyaId', '[0-9]+');

Route::get('/favorite', [FavoriteController::class, 'create'])->name('favorite');
Route::get('/favorite/p_{p}', [FavoriteController::class, 'store'])->where('p', '[0-9]+');


Route::get('/entry', [WebRegistController::class, 'show'])->defaults('path', 'entry')->name('entry');
Route::post('/entry', [WebRegistController::class, 'store'])->defaults('path', 'entry')->name('entry');

Route::post('/entry/confirm', [WebRegistConfirmController::class, 'show'])->defaults('path', 'entry')->name('entry.confirm');
Route::post('/entry/thanks', [WebRegistThanksController::class, 'store'])->defaults('path', 'entry')->name('entry.thanks');
Route::get('/entry/thanks/{obosyaId}', [WebRegistThanksController::class, 'show'])->where('obosyaId', '[0-9]+')->defaults('path', 'entry');

// GET is not supported method redirect to prev page
Route::get('/entry/confirm', [WebRegistConfirmController::class, 'create'])->defaults('path', 'entry');
Route::get('/entry/thanks', [WebRegistThanksController::class, 'create'])->defaults('path', 'entry');

//content pages
//Route::get('/name', [ContentController::class, 'show'])->defaults('path', 'name')->name('name');
Route::get('/work', [ContentController::class, 'show'])->defaults('path', 'work')->name('work');
Route::get('/oneday', [ContentController::class, 'show'])->defaults('path', 'oneday')->name('oneday');
Route::get('/welfare', [ContentController::class, 'show'])->defaults('path', 'welfare')->name('welfare');

// Ajax
Route::post('/latestJobs', [LatestJobController::class, 'store'])->name('ajax.latestJobs');
Route::post('/sameAreaJobs', [sameAreaJobController::class, 'store'])->name('ajax.sameAreaJobs');
Route::post('/recommendJobs', [RecommendJobController::class, 'store'])->name('ajax.recommendJobs');
Route::post('/form/selectZip', [FormController::class, 'selectZip'])->name('ajax.form.selectZip');
Route::post('/form/selectPref', [FormController::class, 'selectPref'])->name('ajax.form.selectPref');

Route::get('/xxxx', [ContentController::class, 'show'])->defaults('path', 'xxxx')->name('xxxx');
