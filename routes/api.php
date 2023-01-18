<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\UsuarioController;
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

Route::prefix('/app')->group(function () {
    Route::prefix('/login')->group(function () {
        Route::post('/professor', [AuthController::class, 'loginProfessor'])->name('api.app.login.professor');
        Route::post('/aluno', [AuthController::class, 'loginAluno'])->name('api.app.login.aluno');
    });

    Route::prefix('/usuarios')->group(function () {
        Route::post('/cadastro-professor', [UsuarioController::class, 'cadastroUsuario'])->name('api.app.usuarios.cadastro.professor');
        Route::post('/cadastro-aluno', [UsuarioController::class, 'cadastroUsuario'])->name('api.app.usuarios.cadastro.aluno');
    });
});

Route::middleware('jwt.authenticate')->group(function () {
    Route::prefix('/quiz')->group(function () {
        Route::get('/status/listar', [QuizController::class, 'listarStatus'])->name('api.quiz.status.listar');
    });
});
