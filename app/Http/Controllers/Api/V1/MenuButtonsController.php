<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\ApiControllerTrait;
use App\MenuButton;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MenuButtonsController extends Controller
{
    use ApiControllerTrait;

    /**
     * @var MenuButton
     */
    protected $model;

    public function __construct(MenuButton $model)
    {
        $this->model = $model;
    }
}
