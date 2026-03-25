<?php

use Illuminate\Support\Str;

return [
    // 一覧で表示する件数
    'list_counts' => [
        'admin' => [
            'index'         => 100
        ],
        'user' => 10,
    ],
    'cookie' =>[
        'limit' => 86400 * 30 * 12, // 1日　×　30日　×　1ヶ月
    ],
    'inquiry' =>[
        'mail' => [
            'system' => 'お問い合わせを受け付けました。',
            'visitor' => 'お問い合わせを受け付けました。',
        ],

    ],

    // User管理画面用のクッキー名称、セッションテーブル名
    'session_cookie_user' => 'auth-user',
    'ssession_table_user' => 'sessions',

    // 管理画面用のクッキー名称、セッションテーブル名
    'session_cookie_admin' => 'auth-admin',
    'ssession_table_admin' => 'sessions_admin',
    
    // Basic認証用のユーザー名、パスワード
    'basic_auth' => [
        'username' => env('BASIC_AUTH_USERNAME', 'home-te'),
        'password' => env('BASIC_AUTH_PASSWORD', 'home-te'),
    ],

];
