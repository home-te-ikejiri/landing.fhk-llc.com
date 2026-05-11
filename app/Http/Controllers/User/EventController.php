<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\EventReservationRequest;
use App\Services\User\EventReservationService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EventController extends Controller
{
    private const SESSION_KEY = 'event_reservation';

    public function __construct(private EventReservationService $service) {}

    /**
     * イベント詳細ページ
     */
    public function show(int $id): View|RedirectResponse
    {
        $event = $this->service->getEvent($id);

        if (!$event) {
            return redirect('/')->with('error', 'イベントが見つかりませんでした。');
        }

        $reserved  = $this->service->reservedCount($event);
        $remaining = $event->capacity - $reserved;

        return view('user.event.show', compact('event', 'reserved', 'remaining'));
    }

    /**
     * 申込フォーム表示
     */
    public function reserve(int $id): View|RedirectResponse
    {
        $event = $this->service->getEvent($id);

        if (!$event) {
            return redirect('/')->with('error', 'イベントが見つかりませんでした。');
        }

        $reserved  = $this->service->reservedCount($event);
        $remaining = $event->capacity - $reserved;

        if ($remaining <= 0) {
            return redirect("/event/{$id}")->with('error', '申し訳ありません。このイベントはすでに満席です。');
        }

        return view('user.event.reserve', compact('event', 'remaining'));
    }

    /**
     * バリデーション → 確認画面
     */
    public function confirm(EventReservationRequest $request): View|RedirectResponse
    {
        $formData = $request->only([
            'event_id', 'num_participants',
            'representative_name', 'representative_phone',
            'email', 'message', 'participants',
        ]);

        // 参加者名の空要素を除去
        $formData['participants'] = array_values(
            array_filter($formData['participants'] ?? [], fn($v) => $v !== null && $v !== '')
        );

        $request->session()->put(self::SESSION_KEY, $formData);

        // イベント情報をビュー用に取得
        $event = $this->service->getEvent((int) $formData['event_id']);

        return view('user.event.confirm', compact('formData', 'event'));
    }

    /**
     * 予約保存 → 完了画面へリダイレクト
     */
    public function store(Request $request): RedirectResponse
    {
        $data = $request->session()->get(self::SESSION_KEY);

        if (!$data) {
            return redirect()->route('user.contact')
                ->withErrors(['error' => 'セッションが切れました。もう一度入力してください。']);
        }

        $this->service->save($data);
        $request->session()->forget(self::SESSION_KEY);

        return redirect()->route('user.event.complete');
    }

    /**
     * 完了画面
     */
    public function complete(): View
    {
        return view('user.event.complete');
    }
}
