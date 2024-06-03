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
    Route::post('/sendEmailToRemember', 'sendEmailToRemember');
    Route::post('/changePasswordWithCode', 'changePasswordWithCode');
});

Route::controller(Controllers\NoteController::class)->group(function (){
    Route::post('/createNote', 'createNote');
    Route::post('/listNotes', 'listNotes');
    Route::post('/updateNote', 'updateNote');
    Route::post('/deleteNote', 'deleteNote');
});

Route::controller(Controllers\DiaryController::class)->group(function (){
    Route::post('/updateDiaryEntry', 'updateDiaryEntry');
    Route::post('/getDiaryEntry', 'getDiaryEntry');
});

Route::controller(Controllers\UserController::class)->group(function (){
    Route::post('/getUserByToken', 'getUserByToken');
    Route::post('/changeUsername', 'changeUsername');
    Route::post('/changePassword', 'changePassword');
    Route::post('/createPaymentToken', 'createPaymentToken');
    Route::post('/checkPaymentToken', 'checkPaymentToken');
    Route::post('/grantPremiumToUser', 'grantPremiumToUser');
});

Route::controller(Controllers\ToDoController::class)->group(function (){
    Route::post('/createToDo', 'createToDo');
    Route::post('/listToDos', 'listToDos');
    Route::post('/completeToDo', 'completeToDo');
    Route::post('/deleteToDo', 'deleteToDo');
    Route::post('/updateToDo', 'updateToDo');
});