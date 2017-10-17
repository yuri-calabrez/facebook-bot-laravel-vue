<?php

namespace App\Http\Controllers;

use App\BotResources\SendSuggestions;
use App\Postback;
use App\Repositories\MessagesBuilderRepository;
use CodeBot\Build\Solid;
use CodeBot\Resources\Resolver;
use CodeBot\SenderRequest;
use CodeBot\WebHook;
use Illuminate\Http\Request;

class BotController extends Controller
{
    public function subscribe()
    {
        $webhook = new WebHook;
        $subscribe = $webhook->check(config('botfb.validation_token'));
        if(!$subscribe) {
            abort(403, 'Unauthorized action!');
        }
        return $subscribe;
    }

    public function receiveMessage(Request $request)
    {
        $sender = new SenderRequest;
        $senderId = $sender->getSenderId();
        $postback = $sender->getPostback();


        $bot = Solid::factory();
        Solid::setPageAccessToken(config('botfb.page_access_token'));
        Solid::setSenderId($senderId);

        if ($postback === 'suggestion') {
            (new SendSuggestions)->statusStart($sender, $bot);
            return '';
        }

        $postback = Postback::where('value', $postback)->first();

        if(!$postback) {
            $botResourceResolver = new Resolver;
            $botResourceResolver->register(SendSuggestions::class);

            if($botResourceResolver->resolver($sender, $bot)) {
                return '';
            }
            $bot->message('text', 'Desculpe eu não sei o que você quis dizer :/');
            $bot->message('text', 'Use o menu ao lado esquerdo do campo de digitação para ver o que você pode fazer.');

            return '';
        }

        foreach ($postback->messages as $message) {
            (new MessagesBuilderRepository)->createMessage($bot, $message);
        }

        return '';

    }
}
