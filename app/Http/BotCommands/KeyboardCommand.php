<?php
/**
 * Created by PhpStorm.
 * User: dstructx
 * Date: 13/08/17
 * Time: 01:45 AM
 */

namespace App\Http\BotCommands;


use Telegram\Bot\Commands\Command;
use Telegram\Bot\Keyboard;
use Telegram\Bot\Laravel\Facades\Telegram;

class KeyboardCommand extends Command
{
    /**
     * @var string Command Name
     */
    protected $name = "keyboard";

    /**
     * @var string Command Description
     */
    protected $description = "Start keyboard to get you started";

    /**
     * @inheritdoc
     */
    public function handle($arguments)
    {
        $keyboard = [
            ['7', '8', '9'],
            ['4', '5', '6'],
            ['1', '2', '3'],
            ['0']
        ];

        $reply_markup = Telegram::replyKeyboardMarkup([
            'keyboard' => $keyboard,
            'resize_keyboard' => true,
        ]);

        $response = Telegram::sendMessage([
            'chat_id' => $this->update->getMessage()->getChat()->getId(),
            'text' => 'Hello World',
            'reply_markup' => $reply_markup
        ]);


        logger($arguments[0]);
        $messageId = $response->getData();
        logger($response);
        $this->replyWithMessage(['text' => "Hello! $messageId"]);
    }
}