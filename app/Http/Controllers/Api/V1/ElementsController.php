<?php

namespace App\Http\Controllers\Api\V1;

use App\Element;
use App\Http\Controllers\ApiControllerTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ElementsController extends Controller
{
    use ApiControllerTrait;

    protected $model;

    public function __construct(Element $model)
    {
        $this->model = $model;
    }
}
