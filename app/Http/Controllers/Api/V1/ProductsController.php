<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\ApiControllerTrait;
use App\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductsController extends Controller
{
    use ApiControllerTrait;

    protected $model;

    public function __construct(Product $model)
    {
        $this->model = $model;
    }
}
