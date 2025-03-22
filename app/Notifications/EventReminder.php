<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Event;

class EventReminder extends Notification implements ShouldQueue
{
    use Queueable;

    protected $event;

    public function __construct(Event $event)
    {
        $this->event = $event;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('Напоминание о событии: ' . $this->event->title)
                    ->line('Описание: ' . $this->event->description)
                    ->line('Начало: ' . $this->event->start_time->format('d.m.Y H:i'))
                    ->action('Просмотреть событие', route('events.show', $this->event->id))
                    ->line('Спасибо за использование нашего приложения!');
    }

    public function toArray($notifiable)
    {
        return [
            'event_id' => $this->event->id,
            'event_title' => $this->event->title,
        ];
    }
}