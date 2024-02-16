<?php

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
//Modulo de Registro
Route::apiResource('users', 'UserController');

//Modulo de autenticación
Route::post('/auth/login', [App\Http\Controllers\AuthController::class, 'login']);

//Modulo de activar la Cuenta

Route::post('/validate/cuenta',[App\Http\Controllers\UserController::class, 'validateCode']);

//listar configuraciones y carroceria

Route::get('list/options',[App\Http\Controllers\SettingController::class, 'index']);

// listar vehiculos del usuario

Route::get('/list/vehicles/{id}',[App\Http\Controllers\VehicleController::class, 'index']);

//Crear Vehiculos asociados a un usuario

Route::post('/create/vehicle',[App\Http\Controllers\VehicleController::class, 'store']);
