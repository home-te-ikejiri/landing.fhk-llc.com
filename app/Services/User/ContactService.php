<?php

namespace App\Services\User;

use App\Models\Contact;
use Illuminate\Support\Facades\Mail;

class ContactService
{
    // お問い合わせ種別ラベル
    const RELATED_TYPE_LABELS = [
        'rental_room_reservation' => 'レンタルルーム予約の変更・キャンセル',
        'event_reservation'       => 'イベント予約の変更・キャンセル',
        'other'                   => 'その他',
    ];

    /**
     * お問い合わせ内容をメールで送信し、contactsテーブルに保存する
     *
     * 送信先は環境変数 CONTACT_MAIL_TO で設定してください。
     * 未設定の場合は MAIL_FROM_ADDRESS にフォールバックします。
     */
    public function send(array $data): void
    {
        // メール送信
        $to = config('mail.contact_to', config('mail.from.address'));

        Mail::raw($this->buildBody($data), function ($message) use ($data, $to) {
            $message->to($to)
                    ->subject('【FHK】お問い合わせがありました')
                    ->replyTo($data['email'], $data['name']);
        });

        // DBへ保存
        $relatedType = ($data['related_type'] ?? '') !== '' && ($data['related_type'] ?? '') !== 'other'
            ? $data['related_type']
            : null;

        $relatedId = ($relatedType && !empty($data['related_id_input']) && (int)$data['related_id_input'] > 0)
            ? (int) $data['related_id_input']
            : null;

        // subject: related_type ラベルがあれば利用、なければ「お問い合わせ」
        $subject = isset($data['related_type']) && isset(self::RELATED_TYPE_LABELS[$data['related_type']])
            ? self::RELATED_TYPE_LABELS[$data['related_type']]
            : 'お問い合わせ';

        Contact::create([
            'name'         => $data['name'],
            'email'        => $data['email'],
            'phone'        => $data['phone'] ?? null,
            'subject'      => $subject,
            'message'      => $data['message'],
            'related_type' => $relatedType,
            'related_id'   => $relatedId,
            'status'       => Contact::STATUS_PENDING,
        ]);
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

        if (!empty($data['related_type']) && isset(self::RELATED_TYPE_LABELS[$data['related_type']])) {
            $body .= "【お問い合わせ種別】" . self::RELATED_TYPE_LABELS[$data['related_type']] . "\n";
        }

        if (!empty($data['related_id_input'])) {
            $body .= "【予約番号】　　　　{$data['related_id_input']}\n";
        }

        $body .= "\n【お問い合わせ内容】\n";
        $body .= $data['message'] . "\n";

        return $body;
    }
}
