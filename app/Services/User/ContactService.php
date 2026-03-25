<?php

namespace App\Services\User;

use Illuminate\Support\Facades\Mail;

class ContactService
{
    /**
     * お問い合わせ内容をメールで送信する
     *
     * 送信先は環境変数 CONTACT_MAIL_TO で設定してください。
     * 未設定の場合は MAIL_FROM_ADDRESS にフォールバックします。
     */
    public function send(array $data): void
    {
        $to = config('mail.contact_to', config('mail.from.address'));

        Mail::raw($this->buildBody($data), function ($message) use ($data, $to) {
            $message->to($to)
                    ->subject('【FHK】お問い合わせがありました')
                    ->replyTo($data['email'], $data['name']);
        });
    }

    private function buildBody(array $data): string
    {
        $body  = "FHK ウェブサイトより、お問い合わせがありました。\n";
        $body .= str_repeat('-', 40) . "\n\n";
        $body .= "【お名前】　　　　　{$data['name']}\n";

        if (!empty($data['kana'])) {
            $body .= "【ふりがな】　　　　{$data['kana']}\n";
        }

        $body .= "【メールアドレス】　{$data['email']}\n";

        if (!empty($data['phone'])) {
            $body .= "【電話番号】　　　　{$data['phone']}\n";
        }

        $body .= "\n【お問い合わせ内容】\n";
        $body .= $data['message'] . "\n";

        return $body;
    }
}
