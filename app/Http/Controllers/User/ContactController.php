<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\ContactRequest;
use App\Services\User\ContactService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ContactController extends Controller
{
    private const SESSION_KEY = 'contact_form';

    public function __construct(private ContactService $service) {}

    /** フォーム表示 */
    public function index(): View
    {
        // 確認画面から「戻る」で戻った場合にセッションの値をフォームへ復元する
        $old = session(self::SESSION_KEY, []);
        return view('user.contact.index', compact('old'));
    }

    /** バリデーション → 確認画面表示 */
    public function confirm(ContactRequest $request): View
    {
        $data = $request->only(['name', 'kana', 'email', 'phone', 'related_type', 'related_id_input', 'message']);
        $request->session()->put(self::SESSION_KEY, $data);
        return view('user.contact.confirm', compact('data'));
    }

    /** 送信処理 → 完了画面へリダイレクト */
    public function send(Request $request): RedirectResponse
    {
        $data = $request->session()->get(self::SESSION_KEY);

        if (!$data) {
            return redirect()->route('user.contact')
                ->withErrors(['error' => 'セッションが切れました。もう一度入力してください。']);
        }

        $this->service->send($data);
        $request->session()->forget(self::SESSION_KEY);

        return redirect()->route('user.contact.complete');
    }

    /** 完了画面表示 */
    public function complete(): View
    {
        return view('user.contact.complete');
    }
}
