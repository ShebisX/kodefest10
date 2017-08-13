<?php
/**
 * Created by PhpStorm.
 * User: dstructx
 * Date: 13/08/17
 * Time: 11:53 AM
 */

namespace App\Http\BotCommands;

use App\Account;
use Telegram\Bot\Actions;
use Telegram\Bot\Commands\Command;
use Telegram\Bot\Keyboard;

class MyAmountCommand extends Command
{
    /**
     * @var string Command Name
     */
    protected $name = "myAmount";

    /**
     * @var string Command Description
     */
    protected $description = "Consultar saldo en la cuenta";

    /**
     * @inheritdoc
     */
    public function handle($arguments)
    {
//        if ($this->getUpdate()->getMessage()->getDate() >= resolve("timestampInit")) {
        try {
            $args = explode(",", $arguments);

            if (!isset($args) || count($args) != 2) {
                $message = "Formato esperado: Numero de cuenta, contaseña";
                $this->replyWithMessage(['text' => $message]);
            } else {
                $this->replyWithChatAction(['action' => Actions::TYPING]);
                $account = Account::find(trim($args[0]));
                if ($account != null) {

                    if (trim($args[1] == $account->password)) {
                        $this->replyWithMessage(['text' => "La cantidad de dinero en su cuenta es: $" . $account->amount]);
                    } else {
                        $this->replyWithMessage(['text' => "Operacion invalida contraseña incorrecta"]);
                    }

                } else {
                    $this->replyWithMessage(['text' => "La cuenta ingresada no existe, por favor verifique"]);
                }
            }


        } catch
        (Exception $e) {
            $errorData = $e->getResponseDate();

            if ($errorData['ok'] === false) {
                $this->getTelegram()->sendMessage(['chat_id' => '179203467',
                    'text' => 'Hubo un error' . $errorData['error_code']]);
            }
        }
    }
// }
}