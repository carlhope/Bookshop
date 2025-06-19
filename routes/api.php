<?php

use App\Http\Controllers\ApiController;

Route::get('/books', [ApiController::class, 'index']);
Route::get('/books/{id}', [ApiController::class, 'show']);