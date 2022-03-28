<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TicketController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});




Route::post('login', [AuthController::class, 'apiLogin'])->name('users.login');


Route::middleware(['auth:api'])->group(function () {
    Route::get('my', [UserController::class, 'profile'])->name('myprofile');
});


Route::prefix('users')->middleware(['auth:api'])->group(function () {

    Route::get('/', [UserController::class, 'apiGetAll'])->name('users.getAll');

    Route::get('/{id}', [UserController::class, 'apiGetOne'])->name('users.getOne');

    Route::post('/', [UserController::class, 'apiCreateUser'])->name('users.CreateUser');

    Route::put('/{id}', [UserController::class, 'apiUpdateUser'])->name('users.UpdateUser');

    Route::delete('/{id}', [UserController::class, 'apiDestroy'])->name('users.Destroy');

});


Route::prefix('tickets')->middleware(['auth:api'])->group(function () {

    Route::get('/', [TicketController::class, 'apiGetAll'])->name('tickets.getAll');

    Route::get('/{id}', [TicketController::class, 'apiGetOne'])->name('tickets.getOne');

    Route::post('/', [TicketController::class, 'apiCreateTicket'])->name('tickets.CreateTicket');

    Route::put('/{id}', [TicketController::class, 'apiUpdateTicket'])->name('tickets.UpdateTicket');

    Route::delete('/{id}', [TicketController::class, 'apiDestroy'])->name('tickets.Destroy');

});
