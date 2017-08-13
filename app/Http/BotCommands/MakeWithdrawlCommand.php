<?php

namespace App\Http\BotCommands;

use App\Account;
use App\Withdrawl;
use PhpParser\Node\Expr\Cast\Double;
use Telegram\Bot\Actions;
use Telegram\Bot\Commands\Command;
use Telegram\Bot\Keyboard;
use App\Deposit;

class MakeWithdrawlCommand extends Command
{
    /**
     * @var string Command Name
     */
    protected $name = "makeWithdrawl";

    /**
     * @var string Command Description
     */
    protected $description = "Hacer retiro";

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
                    "account_id" => trim($args[1]),
                ];
                $account = Account::find(trim($args[1]));
                if ($account && $account->password == $args[2]) {
                    $withdrawl = new Withdrawl($data);
                    $withdrawl->save();
                    $val = $account->amount;
                    if ($account->type = "Current") {
                        $account->amount = (Double)$val - ((Double)trim($args[0]) + (Double)$withdrawl->cost);
                    } elseif ($account->type = "Saving") {
                        $account->amount = (Double)$val - (Double)trim($args[0]);
                    }
                    $account->save();


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
//        }

}
