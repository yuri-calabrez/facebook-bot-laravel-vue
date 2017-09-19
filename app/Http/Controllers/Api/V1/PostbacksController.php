<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\ApiControllerTrait;
use App\Postback;
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
}
