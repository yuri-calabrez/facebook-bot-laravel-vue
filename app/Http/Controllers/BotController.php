<?php

namespace App\Http\Controllers;

use CodeBot\Build\Solid;
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
        $postback = $sender->getPostback();


        $bot = Solid::factory();
        Solid::setPageAccessToken(config('botfb.page_access_token'));
        Solid::setSenderId($senderId);

        if($postback) {
            if(is_array($postback)) {
                $postback = json_encode($postback);
            }
            $bot->message('text', 'Postback: '.$postback);
            return '';
        }

        $bot->message('text', 'Olá tudo bem!');
        $bot->message('text', 'Você digitou: '.$message);

        $bot->message('image', 'http://www.dumpaday.com/wp-content/uploads/2017/01/random-pictures-74.jpg');
        $bot->message('audio', 'https://fathomless-castle-56481.herokuapp.com/audio/woohoo.wav');
        $bot->message('file', 'https://fathomless-castle-56481.herokuapp.com/file/file.zip');
        $bot->message('video', 'https://fathomless-castle-56481.herokuapp.com/video/video.mp4');

        $buttons = [
            new Button('web_url', 'Google', 'https://www.google.com'),
            new Button('web_url', 'Github', 'https://github.com')
        ];
        $bot->template('buttons', 'Testando botões', $buttons);

        $products = [
            new Product('Produto 1', 'https://angular.io/assets/images/logos/angular/angular.png',
                'Curso Angular', new Button('web_url', null, 'https://angular.io')),
            new Product('Produto 2', 'https://vuejs.org/images/logo.png','Curso VueJs',
                new Button('web_url', null, 'https://vuejs.org'))
        ];

        $bot->template('generic', '', $products);
        $bot->template('list', '', $products);

    }
}
