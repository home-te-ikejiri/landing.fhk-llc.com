<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\RentalRoomReservationRequest;
use App\Services\User\RentalRoomReservationService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RentalRoomController extends Controller
{
    private const SESSION_KEY = 'rental_room_reservation';

    public function __construct(private RentalRoomReservationService $service) {}

    /**
     * 日付別の時間帯一覧ページ
     */
    public function show(string $date): View|RedirectResponse
    {
        // date 形式チェック
        if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
            return redirect('/')->with('error', '無効な日付です。');
        }

        $data = $this->service->getTimeSlots($date);

        if (!$data) {
            return redirect('/')->with('error', 'この日はレンタルルームの予約を受け付けていません。');
        }

        return view('user.rental-room.show', compact('data'));
    }

    /**
     * バリデーション → 確認画面
     */
    public function reserve(RentalRoomReservationRequest $request): View|RedirectResponse
    {
        $formData = $request->only([
            'reservation_date', 'start_time', 'end_time',
            'usage_type', 'purpose', 'num_people',
            'name', 'email', 'phone', 'message',
        ]);

        $request->session()->put(self::SESSION_KEY, $formData);

        return view('user.rental-room.confirm', compact('formData'));
    }

    /**
     * 予約保存 → 完了画面へリダイレクト
     */
    public function store(Request $request): RedirectResponse
    {
        $data = $request->session()->get(self::SESSION_KEY);

        if (!$data) {
            return redirect()->route('user.rental-room.index')
                ->withErrors(['error' => 'セッションが切れました。もう一度入力してください。']);
        }

        $this->service->save($data);
        $request->session()->forget(self::SESSION_KEY);

        return redirect()->route('user.rental-room.complete');
    }

    /**
     * 完了画面
     */
    public function complete(): View
    {
        return view('user.rental-room.complete');
    }
}
