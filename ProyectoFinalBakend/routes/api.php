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
    Route::post('/listNotes', 'listNotes');
});

Route::controller(Controllers\DiaryController::class)->group(function (){
    Route::post('/updateDiaryEntry', 'updateDiaryEntry');
    Route::post('/getDiaryEntry', 'getDiaryEntry');
});

Route::controller(Controllers\UserController::class)->group(function (){
    Route::post('/getUserByToken', 'getUserByToken');
});

Route::controller(Controllers\ToDoController::class)->group(function (){
    Route::post('/createToDo', 'createToDo');
});