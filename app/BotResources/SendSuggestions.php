<?php

namespace App\BotResources;


use App\Repositories\SuggestionsRepository;
use CodeBot\Bot;
use CodeBot\Resources\ResourceInterface;
use CodeBot\SenderRequest;

class SendSuggestions implements ResourceInterface
{

    public function __invoke(SenderRequest $senderRequest, Bot $bot): bool
    {
        $suggestion = new SuggestionsRepository;

        if ($suggestion->statusCheck($senderRequest->getSenderId()) === 'started') {
            $suggestion->create($senderRequest->getSenderId(), $senderRequest->getMessage());

            $bot->message('text', 'Obrigado! Sua sugestão foi enviada com sucesso!');
            $suggestion->statusStop($senderRequest->getSenderId());

            return true;
        }
        return false;
    }

    public function statusStart(SenderRequest $sender, Bot $bot)
    {
        (new SuggestionsRepository)->statusStart($sender->getSenderId());

        $bot->message('text', 'OK. Por favor qual a sua sugestão?');
        $bot->message('text', 'Você pode digitar, mas envia sua sugestão em uma unica mensagem');
    }
}