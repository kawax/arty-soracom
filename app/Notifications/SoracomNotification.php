<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\Discord\DiscordChannel;
use NotificationChannels\Discord\DiscordMessage;
use Revolution\Line\Notifications\LineNotifyChannel;
use Revolution\Line\Notifications\LineNotifyMessage;

class SoracomNotification extends Notification
{
    use Queueable;

    protected $bill;

    /**
     * Create a new notification instance.
     *
     * @param  array  $bill
     *
     * @return void
     */
    public function __construct(array $bill)
    {
        $this->bill = $bill;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     *
     * @return array
     */
    public function via($notifiable)
    {
        return [
            DiscordChannel::class,
            LineNotifyChannel::class,
        ];
    }

    public function toDiscord($notifiable)
    {
        return DiscordMessage::create('Amount: '.$this->bill['amount']);
    }

    /**
     * @param  mixed  $notifiable
     *
     * @return LineNotifyMessage
     */
    public function toLineNotify($notifiable)
    {
        return LineNotifyMessage::create('Amount: '.$this->bill['amount']);
    }
}
