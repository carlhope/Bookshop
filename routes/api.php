<?php

use App\Http\Controllers\BookController;

Route::get('/books', [BookController::class, 'apiIndex']);
Route::get('/books/{id}', [BookController::class, 'apiShow']);