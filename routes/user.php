<?php

use App\Http\Controllers\User\ContactController;
use App\Http\Controllers\User\MainController;
use App\Http\Controllers\User\NewsController;

Route::name('user.')->group(function () {
    Route::get('/',                 [MainController::class, 'index']);
    Route::get('/news/{id}',        [NewsController::class, 'show']);

    // お問い合わせ
    Route::get('/contact',              [ContactController::class, 'index'])->name('contact');
    Route::post('/contact/confirm',     [ContactController::class, 'confirm'])->name('contact.confirm');
    Route::post('/contact/send',        [ContactController::class, 'send'])->name('contact.send');
    Route::get('/contact/complete',     [ContactController::class, 'complete'])->name('contact.complete');
});
