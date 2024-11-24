<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FesController;
use App\Http\Controllers\ProfileController;
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
Route::get('/dashboard', function (){
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::controller(FesController::class)->middleware(['auth'])->group(function(){
    Route::get('/', 'index')->name('fes.index');
    Route::post('/fes', 'store')->name('fes.store');
    Route::get('/fes/create', 'create')->name('fes.create');
    Route::get('/fes/{fes}', 'show')->name('fes.show');
    Route::put('/fes/{fes}', 'update')->name('fes.update');
    Route::delete('/fes/{fes}', 'delete')->name('fes.delete');
    Route::get('/fes/{fes}/edit', 'edit')->name('fes.edit');
});
Route::middleware('auth')->group(function (){
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');

});

require __DIR__.'/auth.php';