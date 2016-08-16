<?php

namespace NotificationChannels\Todoist\Exceptions;

class CouldNotSendNotification extends \Exception
{
    public static function serviceRespondedWithAnError($response)
    {
        return new static('Todoist responded with an error: `'.$response->getBody()->getContents().'`');
    }
}
