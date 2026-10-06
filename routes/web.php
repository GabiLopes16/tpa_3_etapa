<?php

use App\Http\Controllers\EventoController;
use Illuminate\Support\Facades\Route;

Route::get('/', [EventoController::class, 'index'])
    ->name('eventos.index');

Route::get('/eventos/{id}', [EventoController::class, 'show'])
    ->name('eventos.show');

Route::post('/eventos/{id}/perguntas', [EventoController::class, 'storePergunta'])
    ->name('eventos.perguntas.store');

Route::delete('/perguntas/{pergunta}', [EventoController::class, 'destroyPergunta'])->name('perguntas.destroy');
