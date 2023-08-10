<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Models\Offer;
use Illuminate\Notifications\Messages\MailMessage;

class OfferNotification extends Notification
{
    use Queueable;

    protected $offer;

    public function __construct(Offer $offer)
    {
        $this->offer = $offer;
    }

    public function via($notifiable)
    {
        return ['database', 'mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Offer Notification')
            ->line('A new offer has been created')
            ->line('Thank you for using our application!');
    }

    public function toDatabase($notifiable)
    {
        return [
            'message' => 'A new offer has been created with Offer id: ' . $this->offer->id,
            'offer_id' => $this->offer->id,
        ];
    }

}
