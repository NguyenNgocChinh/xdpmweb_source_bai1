<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\v1\UserController;

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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::prefix('v1')->group(function () {
    Route::prefix('users')->group(function () {
        Route::get('/', [UserController::class,'listUser']);
        Route::get('/{id}', [UserController::class,'findUserByID'])->where('id', '[0-9]+');
        Route::get('/search/{name}', [UserController::class,'findUserByName']);

        //C-E-D
        Route::post('/', [UserController::class,'createUser']);
        Route::put('/', [UserController::class,'updateUser'])->where('id', '[0-9]+');
        Route::delete('/{id}', [UserController::class,'deleteUser'])->where('id', '[0-9]+');
    });
});

