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
```

## Run Migrations

Publish the migrations with this artisan command:

    $ php artisan vendor:publish --tag=laravel-sms-migrations

## Configuration

You can publish the config file with this artisan command:

    $ php artisan vendor:publish --tag=laravel-sms-config

## Available SMS Providers
|Provider|URL|Tested|For Testing
|:--------- | :-----------------: | :------: | :------: |
|array|-|Yes|Yes
|log|-|Yes|Yes
|JawalSms|http://www.jawalsms.net/|Yes|No


## Exceptions
- ```Prgayman\Sms\Exceptions\ClientException```
- ```Prgayman\Sms\Exceptions\DriverException```


## Events
- ```\Prgayman\Sms\Events\MessageSending::class```
- ```\Prgayman\Sms\Events\MessageSent::class```
- ```\Prgayman\Sms\Events\MessageFailed::class```
