<?php

namespace NotificationChannels\Todoist;

use GuzzleHttp\Client;
use NotificationChannels\Todoist\Exceptions\CouldNotSendNotification;
use Illuminate\Notifications\Notification;

class TodoistChannel
{
    const API_ENDPOINT = 'https://todoist.com/API/v7/sync';

    /** @var Client */
    protected $client;

    /**
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Send the given notification.
     *
     * @param mixed $notifiable
     * @param \Illuminate\Notifications\Notification $notification
     *
     * @throws \NotificationChannels\Todoist\Exceptions\CouldNotSendNotification
     */
    public function send($notifiable, Notification $notification)
    {
        if (! $token = collect($notifiable->routeNotificationFor('Todoist'))) {
            return;
        }

        $command = $notification->toTodoist($notifiable)->toArray();

        $response = $this->client->post(self::API_ENDPOINT, [
            'form_params' => [
                'commands' => json_encode([$command]),
                'token' => $token,
            ],
        ]);

        if ($response->getStatusCode() !== 200) {
            throw CouldNotSendNotification::serviceRespondedWithAnError($response);
        }
    }
}
