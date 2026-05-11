<?php

namespace App\Mail;

use App\Models\EventReservation;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

/**
 * 管理者によるステータス更新時のユーザー向けメール（イベント予約）
 *
 * @param string $statusKey  'confirmed' | 'cancelled'
 * @param string $extraNote  管理者が入力した追記内容
 */
class EventReservationStatusMail extends Mailable
{
    use Queueable, SerializesModels;

    private const SUBJECTS = [
        'confirmed'  => '【FHK】イベントへのお申し込みが確定しました',
        'cancelled'  => '【FHK】イベントへのお申し込みがキャンセルされました',
    ];

    private const TEMPLATES = [
        'confirmed'  => 'emails.event_reservation_status_confirmed',
        'cancelled'  => 'emails.event_reservation_status_cancelled',
    ];

    public function __construct(
        public EventReservation $reservation,
        public string $statusKey,
        public string $extraNote = '',
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: self::SUBJECTS[$this->statusKey] ?? '【FHK】イベントお申し込みのお知らせ',
        );
    }

    public function content(): Content
    {
        return new Content(
            text: self::TEMPLATES[$this->statusKey] ?? 'emails.event_reservation_status_confirmed',
        );
    }
}
