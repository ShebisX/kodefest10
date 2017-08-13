<?php

namespace App\Http\BotCommands;

use App\Account;

use PhpParser\Node\Expr\Cast\Double;
use Telegram\Bot\Actions;
use Telegram\Bot\Commands\Command;
use Telegram\Bot\Keyboard;
use App\Transfer;

class MakeTransferCommand extends Command
{
    /**
     * @var string Command Name
     */
    protected $name = "makeTransfer";

    /**
     * @var string Command Description
     */
    protected $description = "Hacer transferencia de dinero";

    /**
     * @inheritdoc
     */
    public function handle($arguments)
    {
//        if ($this->getUpdate()->getMessage()->getDate() >= resolve("timestampInit")) {
        try {
            $args = explode(",", $arguments);

            logger($args);
            if (!isset($args) || count($args) != 4) {
                $message = 'Formato esperado: Cantidad,Numero de cuenta,Numero de cuenta destino, contraseña';
                $this->replyWithMessage(['text' => $message]);
            } else {
                $this->replyWithChatAction(['action' => Actions::TYPING]);
                $data = [
                    "amount" => trim($args[0]),
                    "account_id" => trim($args[1]),
                    "to" => trim($args[2]),
                    "from" => trim($args[1])
                ];
                $data2 = [
                    "amount" => trim($args[0]),
                    "account_id" => trim($args[2]),
                    "to" => trim($args[1]),
                    "from" => trim($args[2]),
                    "cost" => 0
                ];
                $account = Account::find(trim($args[1]));
                if ($account && $account->password == $args[3]) {
                    $account2 = Account::find(trim($args[2]));
                    $transfer = new Transfer($data);
                    $transfer2 = new Transfer($data2);
                    $transfer->save();
                    $transfer2->save();
                    $val = $account->amount;
                    $val2 = $account2->amount;
                    if ($account->type = "Current") {
                        $account->amount = (Double)$val - ((Double)trim($args[0]) + (Double)$transfer->cost);
                        $account2->amount = (Double)$val2 + (Double)trim($args[0]);
                        $account->save();
                        $account2->save();

                        $this->replyWithMessage(['text' => 'Se ha realizado la trensferrencia exitosamente Su nuevo saldo es $' . $account->amount]);
                    } else {
                        $this->replyWithMessage(['text' => 'Transaccion invalida solo las cuantas corrientes pueden realizar Transferencias de dinero hacia cualquier otra cuenta']);
                    }
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
//        }
    }
}
