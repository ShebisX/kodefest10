<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Telegram BotCommands API Access Token [REQUIRED]
    |--------------------------------------------------------------------------
    |
    | Your Telegram's BotCommands Access Token.
    | Example: 123456:ABC-DEF1234ghIkl-zyx57W2v1u123ew11
    |
    | Refer for more details:
    | https://core.telegram.org/bots#botfather
    |
    */
    'bot_token' => env('TELEGRAM_BOT_TOKEN', 'YOUR-BOT-TOKEN'),

    /*
    |--------------------------------------------------------------------------
    | Asynchronous Requests [Optional]
    |--------------------------------------------------------------------------
    |
    | When set to True, All the requests would be made non-blocking (Async).
    |
    | Default: false
    | Possible Values: (Boolean) "true" OR "false"
    |
    */
    'async_requests' => env('TELEGRAM_ASYNC_REQUESTS', false),

    /*
    |--------------------------------------------------------------------------
    | HTTP Client Handler [Optional]
    |--------------------------------------------------------------------------
    |
    | If you'd like to use a custom HTTP Client Handler.
    | Should be an instance of \Telegram\BotCommands\HttpClients\HttpClientInterface
    |
    | Default: GuzzlePHP
    |
    */
    'http_client_handler' => null,

    /*
    |--------------------------------------------------------------------------
    | Register Telegram Commands [Optional]
    |--------------------------------------------------------------------------
    |
    | If you'd like to use the SDK's built in command handler system,
    | You can register all the commands here.
    |
    | The command class should extend the \Telegram\BotCommands\Commands\Command class.
    |
    | Default: The SDK registers, a help command which when a user sends /help
    | will respond with a list of available commands and description.
    |
    */
    'commands' => [
        Telegram\Bot\Commands\HelpCommand::class,
        App\Http\BotCommands\StartCommand::class,
//        App\Http\BotCommands\KeyboardCommand::class,
        App\Http\BotCommands\RegisterClientCommand::class,
        App\Http\BotCommands\CreateAccountCommand::class,
        App\Http\BotCommands\MakeDepositCommand::class,
        App\Http\BotCommands\MakeWithdrawlCommand::class,
        App\Http\BotCommands\MakeTransferCommand::class,
        App\Http\BotCommands\MyAmountCommand::class,
    ],
];
