<?php

namespace App\Mail;

use App\Models\RentalRoomReservation;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

/**
 * 管理者向け：レンタルルーム仮予約通知メール
 */
class RentalRoomReservationMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public RentalRoomReservation $reservation) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '【FHK】レンタルルーム仮予約が入りました',
        );
    }

    public function content(): Content
    {
        return new Content(
            text: 'emails.rental_room_reservation_admin',
        );
    }
}
