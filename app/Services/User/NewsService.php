<?php

namespace App\Services\User;

use App\Services\User\Service;
use App\Models\News;

class NewsService extends Service
{
    public function __construct()
    {
    }

    public function fetchNewsById($id)
    {
        return News::where('status',         config('define.common.status.published.id'))
            ->findOrFail($id);
    }

}