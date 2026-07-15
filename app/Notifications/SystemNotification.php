<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class SystemNotification extends Notification
{
    use Queueable;

    /**
     * @param  string       $title    Short headline, e.g. "New student added"
     * @param  string       $message  Detail line
     * @param  string       $icon     One of: user-plus, calendar, user-edit, user-check
     * @param  string|null  $url      Optional link to the related resource
     */
    public function __construct(
        public string $title,
        public string $message,
        public string $icon = 'bell',
        public ?string $url = null,
    ) {
    }

    /**
     * Deliver via the database channel only (in-app notifications).
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * The payload stored in the notifications table `data` column.
     */
    public function toArray(object $notifiable): array
    {
        return [
            'title'   => $this->title,
            'message' => $this->message,
            'icon'    => $this->icon,
            'url'     => $this->url,
        ];
    }
}
