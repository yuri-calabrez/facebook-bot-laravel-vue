<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\ApiControllerTrait;
use App\Message;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MessagesController extends Controller
{
    use ApiControllerTrait;

    protected $model;

    public function __construct(Message $model)
    {
        $this->model = $model;
    }
}
