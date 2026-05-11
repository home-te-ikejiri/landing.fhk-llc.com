<?php

namespace App\Mail;

use App\Models\EventReservation;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

/**
 * 管理者向け：イベント予約ステータス更新通知（ユーザー送付内容を含む）
 */
class EventReservationStatusAdminMail extends Mailable
{
    use Queueable, SerializesModels;

    private const STATUS_LABELS = [
        'confirmed'  => '確定',
        'cancelled'  => 'キャンセル',
    ];

    public function __construct(
        public EventReservation $reservation,
        public string $statusKey,
        public string $extraNote = '',
    ) {}

    public function envelope(): Envelope
    {
        $label = self::STATUS_LABELS[$this->statusKey] ?? $this->statusKey;
        return new Envelope(
            subject: "【FHK】申込番号{$this->reservation->id} のステータスを「{$label}」に更新しました",
        );
    }

    public function content(): Content
    {
        return new Content(
            text: 'emails.event_reservation_status_admin',
        );
    }
}
