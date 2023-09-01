<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LeaveController;
use App\Http\Controllers\ManagerLeaveController;
use App\Http\Controllers\MooooController;
use App\Http\Controllers\MyContorller;
use App\Http\Controllers\UserContorller;

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

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');




/* ========================================
after creating manager turn off this routes
============================================*/
// Create a new manager (GET and POST) 
Route::get('/manager-create', [UserContorller::class, 'create'])->name('managers.create');
Route::post('/manager-create', [UserContorller::class, 'store'])->name('managers.store');



Route::middleware(['auth'])->group(function () {
    Route::get('/leaves', [LeaveController::class, 'index'])->name('leaves.index');
    Route::get('/leaves/create', [LeaveController::class, 'create'])->name('leaves.create');
    Route::post('/leaves', [LeaveController::class, 'store'])->name('leaves.store');
    Route::delete('/leaves/{leave}', [LeaveController::class, 'destroy'])->name('leaves.destroy');
});




Route::middleware(['auth','manager'])->group(function () {
    // List all leaves for a manager
    Route::get('/manager/leaves', [ManagerLeaveController::class, 'index'])->name('manager.leaves.index');

    // Edit a leave status
    Route::get('/manager/leaves/{leave}/edit', [ManagerLeaveController::class, 'edit'])->name('manager.leaves.edit');
    Route::put('/manager/leaves/{leave}', [ManagerLeaveController::class, 'update'])->name('manager.leaves.update');

    // Delete a leave
    Route::delete('/manager/leaves/{leave}', [ManagerLeaveController::class, 'destroy'])->name('manager.leaves.destroy');
});
