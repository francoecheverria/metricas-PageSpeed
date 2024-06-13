<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MetricsController;
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
})->name('welcome');

Route::get('/about-metrics', function () {
    return view('about.index');
})->name('about.metrics');

Route::resource('metrics', MetricsController::class);
Route::get('/get-metrics', [MetricsController::class, 'getMetrics'])->name('metrics.get');
Route::get('/datatable-metrics', [MetricsController::class, 'historyMetrics'])->name('metrics.datatable');


Auth::routes();