<?php

namespace App\Mail;

use App\Models\RentalRoomReservation;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

/**
 * 管理者向け：ステータス更新通知メール（ユーザーへの送付内容をそのまま転送）
 */
class RentalRoomStatusAdminMail extends Mailable
{
    use Queueable, SerializesModels;

    private const STATUS_LABELS = [
        'confirmed'  => '確定',
        'rejected'   => '受付不可',
        'cancelled'  => 'キャンセル',
    ];

    public function __construct(
        public RentalRoomReservation $reservation,
        public string $statusKey,
        public string $extraNote = '',
    ) {}

    public function envelope(): Envelope
    {
        $label = self::STATUS_LABELS[$this->statusKey] ?? $this->statusKey;
        return new Envelope(
            subject: "【FHK】予約番号{$this->reservation->id} のステータスを「{$label}」に更新しました",
        );
    }

    public function content(): Content
    {
        return new Content(
            text: 'emails.rental_room_status_admin',
        );
    }
}
