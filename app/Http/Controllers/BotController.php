<?php

namespace App\Http\Controllers;

use CodeBot\CallSendApi;
use CodeBot\Element\Button;
use CodeBot\Element\Product;
use CodeBot\Message\Text;
use CodeBot\SenderRequest;
use CodeBot\TemplatesMessage\ButtonsTemplate;
use CodeBot\TemplatesMessage\GenericTemplate;
use CodeBot\TemplatesMessage\ListTemplate;
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

        $button = new Button('web_url', null, 'https://angular.io');
        $product = new Product('Produto 1', 'https://angular.io/assets/images/logos/angular/angular.png',
            'Curso Angular', $button);

        $button2 = new Button('web_url', null, 'https://vuejs.org');
        $product2 = new Product('Produto 2', 'https://vuejs.org/images/logo.png','Curso VueJs', $button2);

        $template = new GenericTemplate($senderId);
        $template->add($product);
        $template->add($product2);
        $callSendApi->make($template->message("Testando Generic"));

        $button = new Button('web_url', null, 'https://angular.io');
        $product = new Product('Produto 1', 'https://angular.io/assets/images/logos/angular/angular.png',
            'Curso Angular', $button);

        $button2 = new Button('web_url', null, 'https://vuejs.org');
        $product2 = new Product('Produto 2', 'https://vuejs.org/images/logo.png','Curso VueJs', $button2);

        $template = new ListTemplate($senderId);
        $template->add($product);
        $template->add($product2);
        $callSendApi->make($template->message("Testando List"));

    }
}
