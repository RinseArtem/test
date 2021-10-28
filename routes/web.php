<?php

use App\Http\Controllers\MainController;
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

Route::get('/{date?}', [MainController::class, 'index'])->name('index');

Route::get('/order/new', [MainController::class, 'new'])->name('order.new');
Route::post('/order/save', [MainController::class, 'save'])->name('order.save');
