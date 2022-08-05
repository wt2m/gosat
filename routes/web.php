<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CheckCredit;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/consultaCredito/{cpf}',[CheckCredit::class,'getCreditOptions'])->middleware(\App\Http\Middleware\ValidateCPF::class);
Route::post('/consultaCredito', [CheckCredit::class,'getCreditOptions'])->middleware(\App\Http\Middleware\ValidateCPF::class);