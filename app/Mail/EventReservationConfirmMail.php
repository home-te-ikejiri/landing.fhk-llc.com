<?php

namespace App\Mail;

use App\Models\EventReservation;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

/**
 * 申込者向け：イベント仮予約受付確認メール
 */
class EventReservationConfirmMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public EventReservation $reservation) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '【FHK】イベントへのお申し込みを承りました',
        );
    }

    public function content(): Content
    {
        return new Content(
            text: 'emails.event_reservation_confirm',
        );
    }
}
