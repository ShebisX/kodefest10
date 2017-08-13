<?php
/**
 * Created by PhpStorm.
 * User: dstructx
 * Date: 13/08/17
 * Time: 11:53 AM
 */

namespace App\Http\BotCommands;

use Mockery\Exception;
use Telegram\Bot\Actions;
use Telegram\Bot\Commands\Command;
use Telegram\Bot\Keyboard;
use App\User;

class RegisterClientCommand extends Command
{
    /**
     * @var string Command Name
     */
    protected $name = "registerUser";

    /**
     * @var string Command Description
     */
    protected $description = "Registrar usuario";

    /**
     * @inheritdoc
     */
    public function handle($arguments)
    {
//        if ($this->getUpdate()->getMessage()->getDate() >= resolve("timestampInit")) {

        try {
            $args = explode(",", $arguments);

            logger($args);
            if (!isset($args) || count($args) != 8) {
                $message = 'Formato esperado: cédula,nombre,apellidos,género(Masculino/Femenino),teléfono,dirección,email,fecha de nacimiento(aaaa-mm-dd)';
                $this->replyWithMessage(['text' => $message]);
            } else {
                $this->replyWithChatAction(['action' => Actions::TYPING]);
                $data = [
                    "id" => trim($args[0]),
                    "name" => trim($args[1]),
                    "lastname" => trim($args[2]),
                    "gender" => "",
                    "telephone_number" => trim($args[4]),
                    "direction" => trim($args[5]),
                    "email" => trim($args[6]),
                    "birth_date" => trim($args[7])
                ];
                switch (trim($args[3])) {
                    case 'masculino': {
                        $data["gender"] = 'Male';
                        break;
                    }
                    case 'femenino': {
                        $data['gender'] = 'Female';
                        break;
                    }
                }
                $newUser = new User($data);
                $newUser->save();

                $this->replyWithMessage(['text' => 'Usuario creado']);
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
    //}
}