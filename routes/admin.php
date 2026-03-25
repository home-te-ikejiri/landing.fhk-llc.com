<?php
use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Admin\FaqCategoryController;
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
    Route::get('/', function () {
        return redirect('admin/news');
    });

});


// Route::namespace('Admin')->prefix('admin')->name('admin.')->group(function () {
//     Route::middleware('auth:admin')->group(function () {
//         Route::get('/', 'DashboardController@index');


        
//     });
// });