<?php

namespace App\Mail;

use App\Models\RentalRoomReservation;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

/**
 * 管理者によるステータス更新時のユーザー向けメール
 *
 * @param string $statusKey  'confirmed' | 'rejected' | 'cancelled'
 * @param string $extraNote  管理者が入力した追記内容
 */
class RentalRoomStatusMail extends Mailable
{
    use Queueable, SerializesModels;

    private const SUBJECTS = [
        'confirmed'  => '【FHK】レンタルルームのご予約が確定しました',
        'rejected'   => '【FHK】レンタルルームのご予約について（受付不可のご連絡）',
        'cancelled'  => '【FHK】レンタルルームのご予約がキャンセルされました',
    ];

    private const TEMPLATES = [
        'confirmed'  => 'emails.rental_room_status_confirmed',
        'rejected'   => 'emails.rental_room_status_rejected',
        'cancelled'  => 'emails.rental_room_status_cancelled',
    ];

    public function __construct(
        public RentalRoomReservation $reservation,
        public string $statusKey,
        public string $extraNote = '',
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: self::SUBJECTS[$this->statusKey] ?? '【FHK】レンタルルームご予約のお知らせ',
        );
    }

    public function content(): Content
    {
        return new Content(
            text: self::TEMPLATES[$this->statusKey] ?? 'emails.rental_room_status_confirmed',
        );
    }
}
