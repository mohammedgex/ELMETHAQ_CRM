<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use DevKandil\NotiFire\FcmMessage;
use Illuminate\Support\Facades\Log;

class PushNotification extends Notification
{
    use Queueable;

    protected string $title;
    protected string $body;
    protected ?string $icon;
    protected ?string $clickAction;
    protected ?string $sound;
    protected ?string $image;
    protected array $data;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        string $title,
        string $body,
        ?string $icon = null,
        ?string $clickAction = null,
        ?string $sound = 'default',
        ?string $image = null,
        array $data = []
    ) {
        $this->title = $title;
        $this->body = $body;
        $this->icon = $icon;
        $this->clickAction = $clickAction;
        $this->sound = $sound;
        $this->image = $image;
        $this->data = $data;
    }

    /**
     * Define the channels this notification will be sent through.
     */
    public function via(object $notifiable): array
    {
        return ['fcm'];
    }

    /**
     * Build the FCM message.
     */
    public function toFcm(object $notifiable): FcmMessage
    {
        Log::info('Sending FCM Notification to token: ' . $notifiable->fcm_token);

        $message = FcmMessage::create($this->title, $this->body)
            ->clickAction($this->clickAction ?? 'https://example.com')
            ->sound($this->sound ?? 'default')
            ->priority(\DevKandil\NotiFire\Enums\MessagePriority::HIGH) // أو استخدم ->highPriority()
            ->data($this->data);

        if ($this->icon) {
            $message->icon($this->icon);
        }

        if ($this->image) {
            $message->image($this->image);
        }

        return $message;
    }
}
