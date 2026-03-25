<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
        if ($this->app->environment() === 'production') {
            \URL::forceScheme('https');
        }

        $uri = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '';
        // システム管理画面用のクッキー名称、セッションテーブル名を変更する
        if (strpos($uri, '/admin/') === 0 || $uri === '/admin') {
            config([
                'session.cookie' => config('const.session_cookie_admin'),
                'session.table' => config('const.ssession_table_admin'),
            ]);
        } else {
            //ユーザー管理画面用のクッキー名称、セッションテーブル名を変更する
            config([
                'session.cookie' => config('const.session_cookie_user'),
                'session.table' => config('const.ssession_table_user'),
            ]);

        }
    }
}
