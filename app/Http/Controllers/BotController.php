<?php

namespace App\Http\Controllers;

use App\Postback;
use App\Repositories\MessagesBuilderRepository;
use CodeBot\Build\Solid;
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

        $postback = Postback::where('value', $postback)->first();
        foreach ($postback->messages as $message) {
            (new MessagesBuilderRepository)->createMessage($bot, $message);
        }

        return '';

    }
}
