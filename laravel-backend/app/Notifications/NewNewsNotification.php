<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewNewsNotification extends Notification
{
    use Queueable;

    protected $news;

    /**
     * Yeni bir bildirim örneği oluştur.
     *
     * @param mixed $news
     */
    public function __construct($news)
    {
        $this->news = $news;
    }

    /**
     * Bildirimin teslim kanallarını, kaynağını alır.
     *
     * @param mixed $notifiable
     * @return array<int, string>
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Bildirimin e-posta temsilini alır.
     *
     * @param mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->line('Yeni bir haber eklendi!')
            ->line('Başlık: ' . $this->news->first()->title) // Sadece ilk haberin başlığını kullanarak bir örnek
            ->line('İçerik: ' . $this->news->first()->content); // Sadece ilk haberin içeriğini kullanarak bir örnek
    }

    /**
     * Bildirimin dizinini alabiliriz.
     *
     * @param mixed $notifiable
     * @return array<string, mixed>
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}