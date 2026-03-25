<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;

    // 承認種別
    const APPROVAL_TYPE_NEWS        = 'news';            // お知らせ
    const APPROVAL_TYPE_RECRUITMENT = 'recruitment';     // 採用情報
    const APPROVAL_TYPE_COMPANIES   = 'company';       // 募集企業

    protected $table = 'news';
    protected $guarded = array('id');

    protected $dates = [
        'publish_date'
    ];

    

}
