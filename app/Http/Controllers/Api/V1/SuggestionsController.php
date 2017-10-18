<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\ApiControllerTrait;
use App\Suggestion;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SuggestionsController extends Controller
{
    use ApiControllerTrait;

    protected $model;

    public function __construct(Suggestion $model)
    {
        $this->model = $model;
    }

}
