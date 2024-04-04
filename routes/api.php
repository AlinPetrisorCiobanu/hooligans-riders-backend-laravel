<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Events_Controller;
use App\Http\Controllers\Messages_Controller;
use App\Http\Controllers\Users_Controller;
use Illuminate\Support\Facades\Route;

// AUTH
Route::get('/', [AuthController::class, 'healthcheck']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

//USERS
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user/{id?}', [Users_Controller::class, 'user_data']);
    Route::put('/user/{id?}', [Users_Controller::class, 'update_user']);
    Route::delete('/user', [Users_Controller::class, 'delete_user']);
    Route::get('/users', [Users_Controller::class, 'list_users'])->middleware('isNotUser');
});

//Events
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/events', [Events_Controller::class, 'list_events']);
    Route::get('/event_participant', [Events_Controller::class, 'list_event_participant']);
    Route::post('/events', [Events_Controller::class, 'new_event'])->middleware('isNotUser');
    Route::patch('/add_participant/{id}', [Events_Controller::class, 'add_participant']);
    Route::patch('/remove_participant/{id}', [Events_Controller::class, 'remove_participant']);
});

//Messages
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/message', [Messages_Controller::class, 'list_messages'])->middleware('isNotUser');
    Route::post('/message', [Messages_Controller::class, 'new_message']);
    Route::delete('/message/{id}', [Messages_Controller::class, 'delete_message'])->middleware('isNotUser');
});