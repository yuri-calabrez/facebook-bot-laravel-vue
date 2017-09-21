<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\ApiControllerTrait;
use App\Postback;
use CodeBot\Build\Solid;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PostbacksController extends Controller
{
    use ApiControllerTrait;

    protected $model;
    protected $relationships;

    public function __construct(Postback $model)
    {
        $this->model = $model;
    }

    public function setGetStarted($id)
    {
        $postback = $this->model->where('id', $id)->firstOrFail();
        $this->model->where(['get_started' => true])->update(['get_started' => false]);
        $postback->get_started = true;
        $postback->save();

        $bot = Solid::factory();
        Solid::setPageAccessToken(config('botfb.page_access_token'));
        $bot->addGetStartedButton($postback->value);

        return response()->json(['status' => 'ok']);
    }
}
