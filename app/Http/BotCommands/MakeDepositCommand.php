<?php

namespace App\Http\BotCommands;

use App\Account;
use App\Deposit;
use Telegram\Bot\Actions;
use Telegram\Bot\Commands\Command;
use Telegram\Bot\Keyboard;

class MakeDepositCommand extends Command
{
    /**
     * @var string Command Name
     */
    protected $name = "makeDeposit";

    /**
     * @var string Command Description
     */
    protected $description = "Hacer deposito";

    /**
     * @inheritdoc
     */
    public function handle($arguments)
    {
//        if ($this->getUpdate()->getMessage()->getDate() >= resolve("timestampInit")) {
        try {
            $args = explode(",", $arguments);

            logger($args);
            if (!isset($args) || count($args) != 3) {
                $message = 'Formato esperado: Cantidad,Numero de cuenta, contraseña';
                $this->replyWithMessage(['text' => $message]);
            } else {
                $this->replyWithChatAction(['action' => Actions::TYPING]);
                $data = [
                    "amount" => trim($args[0]),
                    "account_id" => trim($args[1])
                ];
                $account = Account::find(trim($args[1]));

                if ($account && $account->password == $args[2]) {
                    $val = $account->amount;
                    $account->amount = (Double)$val + (Double)trim($args[0]);
                    $account->save();
                    $deposit = new Deposit($data);
                    $deposit->save();

                    $this->replyWithMessage(['text' => 'Su nuevo saldo es $' . $account->amount]);
                } else {
                    $this->replyWithMessage(['text' => 'La transaccion no se pudo realizar la clave es invalida']);
                }

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

//    }
}
