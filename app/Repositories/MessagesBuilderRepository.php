<?php

namespace App\Repositories;


use App\Message;
use CodeBot\Bot;

class MessagesBuilderRepository
{
    public function createMessage(Bot $bot, Message $message)
    {
        if($message->template) {

        } else {
            $bot->message($message->type, $message->message);
        }
    }
}