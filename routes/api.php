<?php

use App\Http\Controllers\AuthController;

use App\Http\Controllers\AccountController;
use App\Http\Controllers\WalletController;
use App\Models\AccountModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// Public routes
// Route::post('/register',[AuthController::class ,'register']);
Route::post('/signup',[AuthController::class ,'signup']);
Route::get('/tests',function(){
    return ['name'=>'mohammad'];
});
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);

Route::middleware('auth.api')->get('/user', [AuthController::class, 'user']);
Route::middleware('auth.api')->post('/createAccount', [AccountController::class, 'post']);
Route::middleware('auth.api')->post('/wallet', [WalletController::class, 'post']);


// gi
