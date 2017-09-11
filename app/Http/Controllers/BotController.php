<?php

namespace App\Http\Controllers;

use CodeBot\CallSendApi;
use CodeBot\Element\Button;
use CodeBot\Message\Text;
use CodeBot\SenderRequest;
use CodeBot\TemplatesMessage\ButtonsTemplate;
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
        $message = $sender->getMessage();

        $text = new Text($senderId);
        $callSendApi = new CallSendApi(config('botfb.page_access_token'));
        $callSendApi->make($text->message('Olá eu sou um Bot!'));
        $callSendApi->make($text->message('Você digitou: '.$message));

        $buttonTemplate = new ButtonsTemplate($senderId);
        $buttonTemplate->add(new Button('web_url', 'Google', 'https://www.google.com'));
        $buttonTemplate->add(new Button('web_url', 'PDV Calçados', 'https://www.pdvcalcados.com.br'));
        $callSendApi->make($buttonTemplate->message("Testando botões"));

    }
}
