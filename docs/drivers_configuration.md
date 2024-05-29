# Drivers configuration `.env` file

## Log

| Key             | Mandatory | Default | Description      |
|:----------------|:----------|:--------|:-----------------|
| SMS_LOG_CHANNEL | No        | null    | Log channel name |

## JawalSms

| Key                       | Mandatory | Default | Description                                                            |
|:--------------------------|:----------|:--------|:-----------------------------------------------------------------------|
| SMS_JAWAL_SMS_USERNAME    | Yes       | null    | Account username                                                       |
| SMS_JAWAL_SMS_PASSWORD    | Yes       | null    | Account password                                                       |
| SMS_JAWAL_SMS_SENDER_NAME | No        | null    | Sender Name (optional) you can set sender name using function `from()` |

## Taqnyat

| Key                       | Mandatory | Default | Description                                                            |
|:--------------------------|:----------|:--------|:-----------------------------------------------------------------------|
| SMS_TAQNYAT_AUTHORIZATION | Yes       | null    | Account authorization password                                         |
| SMS_TAQNYAT_SENDER_NAME   | No        | null    | Sender Name (optional) you can set sender name using function `from()` |

## Jor Mall

| Key                    | Mandatory | Default | Description                                                          |
|:-----------------------|:----------|:--------|:---------------------------------------------------------------------|
| SMS_JOR_MALL_ACC_NAME  | Yes       | null    | Account Acc Name                                                     |
| SMS_JOR_MALL_PASSWORD  | Yes       | null    | Account Password                                                     
| SMS_JOR_MALL_SENDER_ID | No        | null    | Sender ID (optional) you can set sender name using function `from()` |

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

| Key                   | Mandatory | Default | Description                                                            |
|:----------------------|:----------|:--------|:-----------------------------------------------------------------------|
| SMS_NEXMO_API_KEY     | Yes       | null    | Api Key                                                                |
| SMS_NEXMO_API_SECRET  | Yes       | null    | Api Secret                                                             |
| SMS_NEXMO_SENDER_NAME | No        | null    | Sender Name (optional) you can set sender name using function `from()` |

## Twilio

Installation `twilio/sdk` package:

    $ composer require twilio/sdk

Or you can add it directly in your composer.json file:

```json
{
    "require": {
        "twilio/sdk": "^6.33"
    }
}
```

| Key                    | Mandatory | Default | Description                                                            |
|:-----------------------|:----------|:--------|:-----------------------------------------------------------------------|
| SMS_TWILIO_SID         | Yes       | null    | Account Sid                                                            |
| SMS_TWILIO_TOKEN       | Yes       | null    | Account Token                                                          |
| SMS_TWILIO_SENDER_NAME | No        | null    | Sender Name (optional) you can set sender name using function `from()` |

## MoraSa

| Key                    | Mandatory | Default | Description                                                            |
|:-----------------------|:----------|:--------|:-----------------------------------------------------------------------|
| SMS_MORASA_USERNAME    | Yes       | null    | Account username                                                       |
| SMS_MORASA_API_KEY     | Yes       | null    | Account Api Key                                                        |
| SMS_MORASA_SENDER_NAME | No        | null    | Sender Name (optional) you can set sender name using function `from()` |

## Msegat

| Key                    | Mandatory | Default | Description                                                            |
|:-----------------------|:----------|:--------|:-----------------------------------------------------------------------|
| SMS_MSEGAT_USERNAME    | Yes       | null    | Account username                                                       |
| SMS_MSEGAT_API_KEY     | Yes       | null    | Account Api Key                                                        |
| SMS_MSEGAT_SENDER_NAME | No        | null    | Sender Name (optional) you can set sender name using function `from()` |

## Kobikom

| Key                     | Mandatory | Default | Description                                                            |
|:------------------------|:----------|:--------|:-----------------------------------------------------------------------|
| SMS_KOBIKOM_API_KEY     | Yes       | null    | Account Api Key                                                        |
| SMS_KOBIKOM_SENDER_NAME | No        | null    | Sender Name (optional) you can set sender name using function `from()` |

## Unifonic

| Key                       | Mandatory | Default | Description                                                        |
|:--------------------------|:----------|:--------|:-------------------------------------------------------------------|
| SMS_UNIFONIC_APP_SID      | Yes       | null    | Application SID                                                    |
| SMS_UNIFONIC_SENDER_ID    | No        | null    | Sender ID (optional) you can set sender ID using function `from()` |
| SMS_UNIFONIC_MESSAGE_TYPE | No        | 3       | Message Type                                                       |
