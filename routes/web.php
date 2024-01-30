<?php

use App\Http\Controllers\PetController;
use App\Http\Enums\PetStatus;
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

Route::get('/', function () {
    return redirect()->route('pets.index', ['status' => PetStatus::values()]);
});

Route::resource('pets', PetController::class)->except('show');

Route::get('pets/{pet}/download', [PetController::class, 'download'])->name('pets.download');