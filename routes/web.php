<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Telegram::setWebhook(['url' => 'https://kodefest10.herokuapp.com/' . env('TELEGRAM_BOT_TOKEN', 'YOUR-BOT-TOKEN') . '/webhook',]);

Route::get('/', function () {
    return view('welcome');
});

Route::post('/' . env('TELEGRAM_BOT_TOKEN', 'YOUR-BOT-TOKEN') . '/webhook', function () {
//    $updates = Telegram::getWebhookUpdates();
    $update = Telegram::commandsHandler(true);

    // Commands handler method returns an Update object.
    // So you can further process $update object
    // to however you want.

    return 'ok';
});
