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
|Provider|URL|Supported countries|Tested|Local Development
|:--------- | :-----------------: | :------: | :------: | :------: |
|array|-|All|Yes|Yes
|log|-|All|Yes|Yes
|JawalSms|http://www.jawalsms.net/|SA|Yes|No


## Exceptions
- ```Prgayman\Sms\Exceptions\ClientException```
- ```Prgayman\Sms\Exceptions\DriverException```


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
 * @return mixed depends on driver
 */
$response = Sms::to($to)->from($from)->message($message)->send(); 

```
Send using select driver sms
```php
Sms::driver("array")->to($to)->from($from)->message($message)->send();
```

Send using helper function with default driver
```php
sms()->to($to)->from($from)->message($message)->send();
```
Send using helper function and select driver
```php
sms("array")->to($to)->from($from)->message($message)->send();
```

## Drivers configuration

### Log
|Key|Mandatory|Default Value|Description
|:------------------ | :---------- |  :------ | :------------- |
|SMS_LOG_CHANNEL|No|null| Log channel name if null using default log channel

### JawalSms
|Key|Mandatory|Default Value|Description
|:------------------ | :---------- |  :------ | :------------- |
|SMS_JAWAL_SMS_USERNAME|Yes|null| Account username
|SMS_JAWAL_SMS_PASSWORD|Yes|null| Account password
|SMS_JAWAL_SMS_SENDER|No|null| Sender Name (optional) you can set sender name using function ```from()```

## Licence

This library is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).