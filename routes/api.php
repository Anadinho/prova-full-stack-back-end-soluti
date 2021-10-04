<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EnderecoController;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('login', [AuthController::class, 'login']);
Route::post('/createUsers', [\App\Http\Controllers\UserController::class, 'store']);
Route::apiResource('certificados','\App\Http\Controllers\CertificadoController');

Route::middleware(['apiJWT'])->group(function () {
    /** Informações do usuário logado */
    Route::get('me', [AuthController::class, 'me']); 
    /** Encerra o acesso */
    Route::get('/logout', [AuthController::class, 'logout']); 
    /** Atualiza o token */
    Route::get('refresh', [AuthController::class, 'refresh']); 
    /** Listagem dos usuarios cadastrados, este rota serve de teste para verificar a proteção feita pelo jwt */
    Route::get('users','\App\Http\Controllers\UserController@index');
    Route::get('/users/{user}', [\App\Http\Controllers\UserController::class, 'show']);
    // Daqui para baixo você pode ir adiciondo todas as rotas que deverão estar protegidas em sua API
});


// Route::apiResource('enderecos','\App\Http\Controllers\EnderecoController');