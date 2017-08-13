<?php
/**
 * Created by PhpStorm.
 * User: dstructx
 * Date: 13/08/17
 * Time: 11:53 AM
 */

namespace App\Http\BotCommands;

use Telegram\Bot\Actions;
use Telegram\Bot\Commands\Command;
use Telegram\Bot\Keyboard;
use App\Account;

class CreateAccountCommand extends Command
{
    /**
     * @var string Command Name
     */
    protected $name = "createAccount";

    /**
     * @var string Command Description
     */
    protected $description = "Registrar cuenta";

    /**
     * @inheritdoc
     */
    public function handle($arguments)
    {
//        if ($this->getUpdate()->getMessage()->getDate() >= resolve("timestampInit")) {
        try {
            $args = explode(",", $arguments);

            if (!isset($args) || count($args) != 4) {
                $message = "Formato esperado: cantidad inicial, contaseña, tipo(corriente/ahorros),  cédula";
                $this->replyWithMessage(['text' => $message]);
            } else {
                $this->replyWithChatAction(['action' => Actions::TYPING]);
                $data = [
                    "amount" => trim($args[0]),
                    "password" => trim($args[1]),
                    "type" => '',
                    "user_id" => trim($args[3])
                ];

                switch (trim($args[2])) {
                    case 'corriente': {
                        $data["type"] = 'Current';
                        break;
                    }
                    case 'ahorros': {
                        $data['type'] = 'Saving';
                        break;
                    }
                }
                logger($data);
                $newAccount = new Account($data);
                $newAccount->save();

                $this->replyWithMessage(['text' => "Su número de cuenta es $newAccount->id"]);
            }
        } catch (Exception $e) {
            $errorData = $e->getResponseDate();

            if ($errorData['ok'] === false) {
                $this->getTelegram()->sendMessage([
                    'chat_id' => '179203467',
                    'text' => 'Hubo un error' . $errorData['error_code']
                ]);
            }
        }
    }
    // }
}