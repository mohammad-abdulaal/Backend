<?php

use App\Http\Controllers\AuthController;
use App\Models\User;

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

Route::get('/getall',[AuthController::class, 'get']);
Route::get('/tests',function(){
    return ['name'=>'mohammad ali'];
});
Route::post('/approve', [AuthController::class, 'approve']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);
Route::middleware('auth.api')->get('/user', [AuthController::class, 'user']);
// Route::middleware('auth.api')->post('/approve', [AuthController::class, 'approve']);
Route::middleware('auth.api')->post('/createAccount', [AccountController::class, 'post']);
Route::middleware('auth.api')->post('/wallet', [WalletController::class, 'post']);
Route::middleware('auth.api')->get('/getbyid/{id}', [WalletController::class, 'getById']);
Route::middleware('auth.api')->post('/transfer', [WalletController::class, 'transfer']);
Route::middleware('auth.api')->put('/pay', [WalletController::class, 'put']);

// gi


