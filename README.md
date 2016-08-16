# Todoist notifications channel for Laravel 5.3

[![Latest Version on Packagist](https://img.shields.io/packagist/v/laravel-notification-channels/todoist.svg?style=flat-square)](https://packagist.org/packages/laravel-notification-channels/todoist)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Build Status](https://img.shields.io/travis/laravel-notification-channels/todoist/master.svg?style=flat-square)](https://travis-ci.org/laravel-notification-channels/todoist)
[![StyleCI](https://styleci.io/repos/65765910/shield)](https://styleci.io/repos/65765910)
[![SensioLabsInsight](https://img.shields.io/sensiolabs/i/262c4806-f5de-473a-99ca-8d86a96dcfba.svg?style=flat-square)](https://insight.sensiolabs.com/projects/262c4806-f5de-473a-99ca-8d86a96dcfba)
[![Quality Score](https://img.shields.io/scrutinizer/g/laravel-notification-channels/todoist.svg?style=flat-square)](https://scrutinizer-ci.com/g/laravel-notification-channels/todoist)
[![Code Coverage](https://img.shields.io/scrutinizer/coverage/g/laravel-notification-channels/todoist/master.svg?style=flat-square)](https://scrutinizer-ci.com/g/laravel-notification-channels/todoist/?branch=master)
[![Total Downloads](https://img.shields.io/packagist/dt/laravel-notification-channels/todoist.svg?style=flat-square)](https://packagist.org/packages/laravel-notification-channels/todoist)

This package makes it easy to create [Todoist tasks](https://developer.todoist.com/) with Laravel 5.3.

## Contents

- [Installation](#installation)
    - [Setting up the Todoist service](#setting-up-the-todoist-service)
- [Usage](#usage)
	- [Available Message methods](#available-message-methods)
- [Changelog](#changelog)
- [Testing](#testing)
- [Security](#security)
- [Contributing](#contributing)
- [Credits](#credits)
- [License](#license)


## Installation

You can install the package via composer:

``` bash
composer require laravel-notification-channels/todoist
```

### Setting up the Todoist service

In order to add tickets to Todoist users, you need to obtain their access token.

Create a [new Todoist App](https://developer.todoist.com/appconsole.html) to get started.


## Usage

Now you can use the channel in your `via()` method inside the notification:

``` php
use NotificationChannels\Todoist\TodoistChannel;
use NotificationChannels\Todoist\TodoistMessage;
use Illuminate\Notifications\Notification;

class ProjectCreated extends Notification
{
    public function via($notifiable)
    {
        return [TodoistChannel::class];
    }

    public function toTodoist($notifiable)
    {
        return TodoistMessage::create('This is the ticket name.')
                ->priority(4)
                ->due('tomorrow');
    }
}
```

In order to let your Notification know which Todoist user and Todoist list you are targeting, add the `routeNotificationForTodoist` method to your Notifiable model.

This method needs to return the access token of the authorized Todoist user.

```php
public function routeNotificationForTodoist()
{
    return 'NotifiableAccessToken';
}
```

### Available methods

- `content('')`: Accepts a string value for the Todoist ticket content.
- `projectId('')`: Accepts an integer value for the Todoist project id, default is the "Inbox" project.
- `priority('')`: Accepts an integer value for the ticket priority. It should be a number between 1 and 4, 4 for very urgent and 1 for natural.
- `indent('')`: Accepts an integer value for the ticket indent level. It should be a a number between 1 and 4, where 1 is top-level.
- `itemOrder('')`: Accepts an integer value for the ticket item order.  
- `collapsed()`: Marks the Todoist ticket as collapsed.
- `due('')`: Accepts a string or DateTime object for the Todoist ticket due date.


## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Testing

``` bash
$ composer test
```

## Security

If you discover any security related issues, please email m.pociot@gmail.com instead of using the issue tracker.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Credits

- [Marcel Pociot](https://github.com/mpociot)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
