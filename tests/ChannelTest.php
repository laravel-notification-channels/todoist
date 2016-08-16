<?php

namespace NotificationChannels\Todoist\Test;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use Illuminate\Notifications\Notification;
use Mockery;
use NotificationChannels\Todoist\Exceptions\CouldNotSendNotification;
use NotificationChannels\Todoist\TodoistChannel;
use NotificationChannels\Todoist\TodoistMessage;
use Orchestra\Testbench\TestCase;

class ChannelTest extends TestCase
{
    /** @test */
    public function it_can_send_a_notification()
    {
        $response = new Response(200);
        $client = Mockery::mock(Client::class);
        $client->shouldReceive('post')
            ->once()
            ->with('https://todoist.com/API/v7/sync', Mockery::type('array'))
            ->andReturn($response);
        $channel = new TodoistChannel($client);
        $channel->send(new TestNotifiable(), new TestNotification());
    }

    /** @test */
    public function it_throws_an_exception_when_it_could_not_send_the_notification()
    {
        $this->setExpectedException(CouldNotSendNotification::class);

        $response = new Response(500);
        $client = Mockery::mock(Client::class);
        $client->shouldReceive('post')
            ->once()
            ->andReturn($response);
        $channel = new TodoistChannel($client);
        $channel->send(new TestNotifiable(), new TestNotification());
    }
}

class TestNotifiable
{
    use \Illuminate\Notifications\Notifiable;

    /**
     * @return int
     */
    public function routeNotificationForTodoist()
    {
        return 'NotifiableToken';
    }
}


class TestNotification extends Notification
{
    public function toTodoist($notifiable)
    {
        return
            (new TodoistMessage('TodoistName'))
                ->priority(4);
    }
}
