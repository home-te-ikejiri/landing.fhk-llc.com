<?php

use App\Http\Controllers\User\ContactController;
use App\Http\Controllers\User\EventController;
use App\Http\Controllers\User\MainController;
use App\Http\Controllers\User\NewsController;
use App\Http\Controllers\User\RentalRoomController;

Route::name('user.')->group(function () {
    Route::get('/',          [MainController::class, 'index']);
    Route::get('/calendar',  [MainController::class, 'calendar'])->name('calendar');
    Route::get('/price',     [MainController::class, 'price'])->name('price');
    Route::get('/news/{id}',        [NewsController::class, 'show']);

    // レンタルルーム
    Route::get('/rental-room/complete',     [RentalRoomController::class, 'complete'])->name('rental-room.complete');
    Route::get('/rental-room/{date}',       [RentalRoomController::class, 'show'])->name('rental-room.index');
    Route::post('/rental-room/reserve',     [RentalRoomController::class, 'reserve'])->name('rental-room.reserve');
    Route::post('/rental-room/store',       [RentalRoomController::class, 'store'])->name('rental-room.store');

    // イベント
    Route::get('/event/complete',           [EventController::class, 'complete'])->name('event.complete');
    Route::get('/event/{id}',               [EventController::class, 'show'])->name('event.show');
    Route::get('/event/{id}/reserve',       [EventController::class, 'reserve'])->name('event.reserve');
    Route::post('/event/confirm',           [EventController::class, 'confirm'])->name('event.confirm');
    Route::post('/event/store',             [EventController::class, 'store'])->name('event.store');

    // お問い合わせ
    Route::get('/contact',              [ContactController::class, 'index'])->name('contact');
    Route::post('/contact/confirm',     [ContactController::class, 'confirm'])->name('contact.confirm');
    Route::post('/contact/send',        [ContactController::class, 'send'])->name('contact.send');
    Route::get('/contact/complete',     [ContactController::class, 'complete'])->name('contact.complete');
});
