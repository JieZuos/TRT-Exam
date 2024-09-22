<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Mail\NewRegistedAccount;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

Route::get('/', [UserController::class, 'index']);
Route::get('/check-if-exist', [UserController::class, 'checkIfExist']);
Route::get('/fetch-google-api', function () {
    return response()->json([
        'api_key' => config('google_api.google_map_api') 
    ]);
});
Route::get('/dashboard', [UserController::class, 'index'])->name('dashboard');

Route::post('/sign-up', [UserController::class, 'signUp']);
Route::post('/login', [UserController::class, 'login'])->name('login');
Route::post('/logout', [UserController::class, 'logout'])->name('logout');
