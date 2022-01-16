# Drivers configuration ```.env``` file

## Log
|Key|Mandatory|Default|Description
|:------------------ | :---------- |  :------ | :------------- |
|SMS_LOG_CHANNEL|No|null| Log channel name

## JawalSms
|Key|Mandatory|Default|Description
|:------------------ | :---------- |  :------ | :------------- |
|SMS_JAWAL_SMS_USERNAME|Yes|null| Account username
|SMS_JAWAL_SMS_PASSWORD|Yes|null| Account password
|SMS_JAWAL_SMS_SENDER|No|null| Sender Name (optional) you can set sender name using function ```from()```


## Taqnyat
|Key|Mandatory|Default|Description
|:------------------ | :---------- |  :------ | :------------- |
|SMS_TAQNYAT_AUTHORIZATION|Yes|null| Account authorization password
|SMS_TAQNYAT_SENDER_NAME|No|null| Sender Name (optional) you can set sender name using function ```from()```

## Nexmo

Installation nexmo laravel package:

    $ composer require nexmo/laravel

Or you can add it directly in your composer.json file:
```json
{
    "require": {
        "nexmo/laravel": "^2.0"
    }
}
```

|Key|Mandatory|Default|Description
|:------------------ | :---------- |  :------ | :------------- |
|SMS_NEXMO_API_KEY|Yes|null| Api Key
|SMS_NEXMO_API_SECRET|Yes|null| Api Secret
|SMS_NEXMO_SENDER_NAME|No|null| Sender Name (optional) you can set sender name using function ```from()```

## Twilio

Installation ```twilio/sdk``` package:

    $ composer require twilio/sdk

Or you can add it directly in your composer.json file:
```json
{
    "require": {
        "twilio/sdk": "^6.33",
    }
}
```

|Key|Mandatory|Default|Description
|:------------------ | :---------- |  :------ | :------------- |
|SMS_TWILIO_SID|Yes|null| Account Sid
|SMS_TWILIO_TOKEN|Yes|null| Account Token
|SMS_TWILIO_SENDER_NAME|No|null| Sender Name (optional) you can set sender name using function ```from()```


