<?php

namespace NotificationChannels\Todoist\Exceptions;

class CouldNotCreateMessage extends \Exception
{
    public static function invalidPriority($priority)
    {
        return new static("Priority `{$priority}` is invalid. It should be a number between 1 and 4, 4 for very urgent and 1 for natural.");
    }

    public static function invalidIndent($indent)
    {
        return new static("Indent `{$indent}` is invalid. It should be a a number between 1 and 4, where 1 is top-level.");
    }
}
