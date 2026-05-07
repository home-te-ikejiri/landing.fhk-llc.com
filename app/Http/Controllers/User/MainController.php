<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Services\User\MainService;


class MainController extends Controller
{
    public function __construct(MainService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        $faqs = $this->service->fetchFaqs();
        $news = $this->service->fetchNews();

        return view('user.main.index', compact('faqs', 'news'));
    }

    public function price()
    {
        return view('user.main.price');
    }
}