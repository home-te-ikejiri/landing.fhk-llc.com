<?php
use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Admin\FaqCategoryController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\RentalRoomSettingController;
use App\Http\Controllers\Admin\ShopScheduleController;
use App\Http\Controllers\Admin\RentalRoomScheduleController;
use App\Http\Controllers\Admin\RentalRoomTimeSlotController;
use App\Http\Controllers\Admin\RentalRoomReservationController;
use App\Http\Controllers\Admin\EventReservationController;
use App\Http\Controllers\Admin\ContactController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
// とりあえず認証なしで実装
Route::prefix('admin')->name('admin.')->middleware('basicauth')->group(function () {

    Route::resource('news',                                 NewsController::class);
    Route::resource('faq',                                  FaqController::class);
    Route::resource('faq-category',                         FaqCategoryController::class);
    Route::resource('event',                                EventController::class);
    Route::get('rental-room-setting',  [RentalRoomSettingController::class, 'edit'])->name('rental-room-setting.edit');
    Route::put('rental-room-setting',  [RentalRoomSettingController::class, 'update'])->name('rental-room-setting.update');
    // スケジュール管理
    Route::get('shop-schedule',         [ShopScheduleController::class, 'index'])->name('shop-schedule.index');
    Route::post('shop-schedule',        [ShopScheduleController::class, 'store'])->name('shop-schedule.store');
    Route::get('rental-room-schedule',  [RentalRoomScheduleController::class, 'index'])->name('rental-room-schedule.index');
    Route::post('rental-room-schedule', [RentalRoomScheduleController::class, 'store'])->name('rental-room-schedule.store');
    // 時間枠管理
    Route::get('rental-room-time-slot/{date}',  [RentalRoomTimeSlotController::class, 'show'])->name('rental-room-time-slot.show');
    Route::post('rental-room-time-slot',        [RentalRoomTimeSlotController::class, 'store'])->name('rental-room-time-slot.store');
    // 予約管理
    Route::resource('rental-room-reservation',  RentalRoomReservationController::class)->only(['index', 'create', 'store', 'show', 'edit', 'update']);
    Route::delete('rental-room-reservation/{id}', [RentalRoomReservationController::class, 'destroy'])->name('rental-room-reservation.destroy');
    Route::resource('event-reservation',        EventReservationController::class)->only(['index', 'create', 'store', 'show', 'edit', 'update']);
    Route::delete('event-reservation/{id}',     [EventReservationController::class, 'destroy'])->name('event-reservation.destroy');
    // お問い合わせ管理
    Route::get('contact',           [ContactController::class, 'index'])->name('contact.index');
    Route::get('contact/{id}',      [ContactController::class, 'show'])->name('contact.show');
    Route::put('contact/{id}',      [ContactController::class, 'update'])->name('contact.update');
    Route::get('/', function () {
        return redirect('admin/news');
    });

});


// Route::namespace('Admin')->prefix('admin')->name('admin.')->group(function () {
//     Route::middleware('auth:admin')->group(function () {
//         Route::get('/', 'DashboardController@index');


        
//     });
// });