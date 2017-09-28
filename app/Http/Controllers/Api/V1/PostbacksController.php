<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\ApiControllerTrait;
use App\Postback;
use CodeBot\Build\Solid;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PostbacksController extends Controller
{
    use ApiControllerTrait;

    protected $model;
    protected $relationships = ['Messages'];

    public function __construct(Postback $model)
    {
        $this->model = $model;
    }

    public function setGetStartedButton($id)
    {
        $postback = $this->model->where('id', $id)->firstOrFail();

        $bot = Solid::factory();
        Solid::setPageAccessToken(config('botfb.page_access_token'));

        try{
            $bot->addGetStartedButton($postback->value);
        } catch (RequestException $e) {
            return (string) $e->getResponse()->getBody();
        }

        $this->model->where(['get_started' => true])->update(['get_started' => false]);
        $postback->get_started = true;
        $postback->save();

        return response()->json(['status' => 'ok']);
    }

    public function removeGetStartedButton()
    {
        $bot = Solid::factory();
        Solid::setPageAccessToken(config('botfb.page_access_token'));

        try{
            $bot->removeGetStartedButton();
        } catch (RequestException $e) {
            return (string) $e->getResponse()->getBody();
        }

        $this->model->where(['get_started' => true])->update(['get_started' => false]);
        return response()->json(['status' => 'ok']);
    }
}
