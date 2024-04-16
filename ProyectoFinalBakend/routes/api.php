<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers;

Route::middleware('auth:sanctum')->get('/user', function (Request $request){
    return $request->user();
});

Route::controller(Controllers\LoginRegisterController::class)->group(function (){
    Route::post('/register', 'register');
    Route::post('/login', 'login');
});

Route::controller(Controllers\NoteController::class)->group(function (){
    Route::post('/createNote', 'createNote');
});