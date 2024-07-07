<?php

use App\Http\Controllers\api\BooksController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::apiResource('books', BooksController::class);

Route::get('/apiTest', function () {
    return response()->json(['message' => 'this is a test response']);
});
