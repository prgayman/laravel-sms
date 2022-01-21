# Laravel SMS 

Laravel SMS allows you to send SMS from your Laravel application using multiple sms providers, allow to add custom sms provider

## Requirements
- php ```^7.3|^8.0```
- guzzlehttp/guzzle ```^7.0.1```

## Installation

To get the latest version of laravel-sms on your project, require it from "composer":

    $ composer require prgayman/laravel-sms

Or you can add it directly in your composer.json file:

```json
{
  "require": {
    "prgayman/laravel-sms": "1.0.0"
  }
}
```

### Laravel

Register the provider directly in your app configuration file config/app.php `config/app.php`:

Laravel >= 5.5 provides package auto-discovery, thanks to rasmuscnielsen and luiztessadri who help to implement this feature in Zatca, the registration of the provider and the facades should not be necessary anymore.

```php
'providers' => [
    Prgayman\Sms\SmsServiceProvider::class,
]
```

Add the facade aliases in the same file:

```php
'aliases' => [
  'Sms' => Prgayman\Sms\Facades\Sms::class,
  'SmsHistory' => Prgayman\Sms\Facades\SmsHistory::class,
]
```

### Lumen

Register the provider in your bootstrap app file `boostrap/app.php`

Add the following line in the "Register Service Providers" section at the bottom of the file.

```php
$app->register(Prgayman\Sms\SmsServiceProvider::class);
```

For facades, add the following lines in the section "Create The Application" .

```php
class_alias(\Prgayman\Sms\Facades\Sms::class, 'Sms');
class_alias(\Prgayman\Sms\Facades\SmsHistory::class, 'SmsHistory');
```

## Run Migrations

Publish the migrations with this artisan command:

    $ php artisan vendor:publish --tag=laravel-sms-migrations

## Configuration

You can publish the config file with this artisan command:

    $ php artisan vendor:publish --tag=laravel-sms-config

## Available SMS Providers
|Provider|URL|Tested|Config
|:--------- | :-----------------: | :------: | :------: |
|JawalSms|https://www.jawalsms.net/|Yes|[Click](docs/drivers_configuration.md#jawalsms)
|Taqnyat|https://www.taqnyat.sa/|Yes|[Click](docs/drivers_configuration.md#taqnyat)
|Nexmo|https://www.nexmo.com/|Yes|[Click](docs/drivers_configuration.md#nexmo)
|Twilio|https://www.twilio.com/|Yes|[Click](docs/drivers_configuration.md#twilio)


## Available SMS Drivers local development
|Provider|Config
|:--------- | :------: |
|array|-
|log|[Click](docs/drivers_configuration.md#log)


## Events
- ```\Prgayman\Sms\Events\MessageSending::class```
- ```\Prgayman\Sms\Events\MessageSent::class```
- ```\Prgayman\Sms\Events\MessageFailed::class```

## Usage


### Set default driver

#### Using ```.env```
```dotenv
SMS_DRIVER=log
```
#### Using facades
```php
/**
 * Set the default sms driver name.
 * 
 * @param string $driver
*/
Prgayman\Sms\Facades\Sms::setDefaultDriver("array");
```

### Enable sms history using database

- Enable the key ```SMS_HISTORY_ENABLED``` in ```.env``` file

  ```dotenv
  SMS_HISTORY_ENABLED=true
  ```

- Make sure publish the migrations with this artisan command:

      $ php artisan vendor:publish --tag=laravel-sms-migrations

- Run migrate with this artisan command:

      $ php artisan migrate

### Send Message

You can simply send a message like this:

```php

# Send message using facade
use Prgayman\Sms\Facades\Sms;

$to = "+962790000000";
$from = "SenderName";
$message = "Test Send Message";

/**
 * Send using default driver sms
 * 
 * @return \Prgayman\Sms\SmsDriverResponse
 */
$response = Sms::to($to)->from($from)->message($message)->send(); 

# Get Message
$response->getMessage();

# Get Request
$response->getRequest();

# Get driver response
$response->getResponse();

# Check is successfuly send sms message
$response->successful();

# Check is failed send sms message
$response->failed();
```

Send using select driver sms
```php
Sms::driver("array")->to($to)->from($from)->message($message)->send();
```

Send multiple messages (per message run events and store history)

```php
    $items = [
        [
            "to" => "+962792994123",
            "from" => "SenderName",
            "message" => "New message"
        ],
        [
            "to" => "+962792994124",
            "from" => "SenderName",
            "message" => "Send Message"
        ]
    ];

    /**
     * @param $items must contain message, to, and from keys per item
     * @return \Prgayman\sms\SmsDriverResponse[]
     */
    $response = Sms::sendArray($items); 

    // Or send using helper function 
    $response = sms()->sendArray($items); 
```

Send using helper function with default driver
```php
sms()->to($to)->from($from)->message($message)->send();
```
Send using helper function and select driver
```php
sms("array")->to($to)->from($from)->message($message)->send();
```

### Create custom driver

- Create class extends from ```\Prgayman\Sms\Drivers\Driver``` and handler send function

  ```php
  use Prgayman\Sms\Drivers\Driver;
  use Prgayman\Sms\SmsDriverResponse;

  class CustomDriver extends Driver {

      # You not need to run events or store history 
      # package automatically run all events and store history
      public function send() : SmsDriverResponse
      {
          
        $request = [
            "to" => $this->getTo(),
            'from' => $this->getFrom(),
            'body' => $this->getMessage(),
        ];

        try {
            # Handler send message
            $response = null;
            return new SmsDriverResponse($request, $response, true);
        } catch (\Exception $e) {
            return new SmsDriverResponse($request, null, false, $e->getMessage());
        }
      }

  }
  ```
- Add driver confg in ```config/sms.php```
  ```php 
    "drivers"=>[
      .......

      # Use custom driver
      'your-driver-name'=>[
        'handler'=> \App\SmsDrivers\CustomDriver::class
      ],

      # Use supported drivers but different name
      # Copy driver object and change name
      "new-log-driver" => [
            "driver" => "log",
            'channel' => env('SMS_LOG_CHANNEL'),
      ],
    ]
  ```
- Send message with custom driver
  ```php
  # Use driver 
  Sms::driver("your-driver-name")
      ->to($to)
      ->from($from)
      ->message($message)
      ->send();

  # Or set custom driver in default driver or set 
  # SMS_DRIVER=your-driver-name in dotenv file
  Sms::setDefaultDriver("your-driver-name");

  Sms::to($to)
    ->from($from)
    ->message($message)
    ->send();
  ```

## Channel Usage
First you have to create your notification using ```php artisan make:notification``` command.
then ```Prgayman\Sms\Channels\SmsChannel::class``` can be used as channel like the below:

```php

use Illuminate\Notifications\Notification;
use Prgayman\Sms\SmsNotification;

class SendSmsNotification extends Notification
{

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['sms']; # add this channel
    }

    /**
     * @param mixed $notifiable
     * @return \Prgayman\Sms\SmsNotification
     */
    public function toSms($notifiable)
    {
        # Send message with default driver
        return (new SmsNotification)
          ->to("+962790000000")
          ->from("SenderName")
          ->message("Test New Message");

        # Send message with select driver
        return (new SmsNotification)
          ->driver('array')
          ->to("+962790000000")
          ->from("SenderName")
          ->message("Test New Message");
    }
}
```
## SMS History
```php
use Prgayman\Sms\Facades\SmsHistory;

# Get all
$histories = SmsHistory::get();

# Use Filters all filter is optional
$histories = SmsHistory::recipients("+962790000000")
->senders(["SendName"])
->statuses([
  Prgayman\Sms\Models\SmsHistory::SUCCESSED,
  Prgayman\Sms\Models\SmsHistory::FAILED,
])
->drivers(["log","array"])
->driverNames(["custom_name"])
->get();

# Or can use helper function
$histories = smsHistory()
->recipients("+962790000000")
->senders(["SendName"])
->statuses([
  Prgayman\Sms\Models\SmsHistory::SUCCESSED,
  Prgayman\Sms\Models\SmsHistory::FAILED,
])
->drivers(["log","array"])
->driverNames(["custom_name"])
->get();
```

## Testing

```bash
composer test
```

## Licence

This library is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).