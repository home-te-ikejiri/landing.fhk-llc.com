<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Services\User\NewsService;


class NewsController extends Controller
{
    public function __construct(NewsService $service)
    {
        $this->service = $service;
    }

    public function show($id)
    {
        $news = $this->service->fetchNewsById($id);

        return view('user.news.detail', [
            'news' => $news
        ]);
       
    }
}