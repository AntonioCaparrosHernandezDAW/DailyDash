<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers;

Route::middleware('auth:sanctum')->get('/user', function (Request $request){
    return $request->user();
});

Route::controller(Controllers\LoginRegisterController::class)->group(function (){
    Route::post('/registerUser', 'registerUser');
    Route::post('/logUser', 'logUser');
    Route::post('/sendEmailToRemember', 'sendEmailToRemember');
    Route::post('/changePasswordWithCode', 'changePasswordWithCode');
});

Route::controller(Controllers\NoteController::class)->group(function (){
    Route::post('/createNote', 'createNote');
    Route::post('/listNotes', 'listNotes');
    Route::put('/updateNote', 'updateNote');
    Route::put('/deleteNote', 'deleteNote');
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
    Route::post('/changeProfilePicture', 'changeProfilePicture');
    Route::post('/getProfilePicture', 'getProfilePicture');
});

Route::controller(Controllers\ToDoController::class)->group(function (){
    Route::post('/createToDo', 'createToDo');
    Route::post('/listToDos', 'listToDos');
    Route::post('/completeToDo', 'completeToDo');
    Route::put('/deleteToDo', 'deleteToDo');
    Route::put('/updateToDo', 'updateToDo');
    Route::put('/getToDoCode', 'getToDoCode');
    Route::post('/importToDo', 'importToDo');
    Route::post('/listImportedToDos', 'listImportedToDos');
});