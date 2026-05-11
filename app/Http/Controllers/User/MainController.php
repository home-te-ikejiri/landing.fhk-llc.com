<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use App\Services\User\MainService;
use App\Services\User\CalendarService;


class MainController extends Controller
{
    public function __construct(
        private MainService     $service,
        private CalendarService $calendarService,
    ) {}

    public function index(Request $request)
    {
        $faqs = $this->service->fetchFaqs();
        $news = $this->service->fetchNews();

        $month = $request->get('month', now()->format('Y-m'));
        if (!preg_match('/^\d{4}-\d{2}$/', $month)) {
            $month = now()->format('Y-m');
        }
        $calendar = $this->calendarService->getCalendar($month);

        return view('user.main.index', compact('faqs', 'news', 'calendar'));
    }

    public function price()
    {
        return view('user.main.price');
    }

    /**
     * Ajax用：カレンダー部分HTMLのみ返す
     */
    public function calendar(Request $request): Response
    {
        $month = $request->get('month', now()->format('Y-m'));
        if (!preg_match('/^\d{4}-\d{2}$/', $month)) {
            $month = now()->format('Y-m');
        }
        $calendar = $this->calendarService->getCalendar($month);
        $html = view('user.main._calendar', compact('calendar'))->render();
        return response($html);
    }
}