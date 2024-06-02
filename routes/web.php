<?php

use App\Http\Controllers\event\EventController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\event\EventGustController;
use App\Http\Controllers\event\ReminderController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
Route::get('/register', [RegisteredUserController::class, 'create'])->middleware('guest')->name('register');
Route::post('/register', [RegisteredUserController::class, 'store'])->middleware('guest');



Route::get('/', function(){return view('auth.login');});

Route::get('/user/create/', function(){return view('auth.login');});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard/', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/event/list', [EventController::class, 'index'])->name('event.record');
    Route::post('/event/list/data', [EventController::class, 'eventRecords'])->name('event.record.data');
    Route::get('/event/add', [EventController::class, 'addEvent'])->name('event.add');
    Route::post('/event/create', [EventController::class, 'store'])->name('event.create');
    Route::post('/event/delete', [EventController::class, 'delete'])->name('event.delete');
    Route::get('/event/edit/{event_id}', [EventController::class, 'editEvent'])->name('event.edit');
    Route::post('/event/update/{event_id}', [EventController::class, 'update'])->name('event.update');
    Route::post('/event/import/', [EventController::class, 'importCsv'])->name('event.import.csv');

    Route::get('/event/guest/list', [EventGustController::class, 'index'])->name('event.guest.record');
    Route::post('/event/guest/list/data', [EventGustController::class, 'eventGuestRecords'])->name('event.guest.record.data');
    Route::post('/event/guest/create', [EventGustController::class, 'store'])->name('event.guest.create');
    Route::post('/event/guest/delete', [EventGustController::class, 'delete'])->name('event.guest.delete');

    Route::get('/user-list/', [UserController::class, 'index'])->name('user.record');
    Route::POST('/user/list/data/', [UserController::class, 'loadUsers'])->name('user.record.data');
    Route::get('/user/info/{id}', [UserController::class, 'userInfo'])->name('user.info');
    Route::post('/user/add/', [UserController::class, 'addUser'])->name('user.create');
    Route::post('/user/update/{id}', [UserController::class, 'updateUser'])->name('user.update');

    Route::get('/event/reminder/send', [ReminderController::class, 'index'])->name('reminder.send');
    Route::get('/event/guest/{$guest_id}/reminder/send', [ReminderController::class, 'staticMailSendReminder'])->name('event.guest.reminder.send');
});

require __DIR__.'/auth.php';
