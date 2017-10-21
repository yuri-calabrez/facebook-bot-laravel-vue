<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\ApiControllerTrait;
use App\Menu;
use CodeBot\Build\Solid;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MenusController extends Controller
{
    use ApiControllerTrait;

    /**
     * @var Menu
     */
    protected $model;
    protected $relationships = ['menuButtons'];

    public function __construct(Menu $model)
    {
        $this->model = $model;
    }

    public function setMenu(int $menuId)
    {
        $menu = $this->model->findOrFail($menuId);
        $bot = Solid::factory();
        Solid::setPageAccessToken(config('botfb.page_access_token'));

        $result = $bot->addMenu($menu->locale, $menu->composer_input_disabled, $menu->menuButtons);

        $menu->facebook_diff = false;
        $menu->save();

        return $result;
    }

    public function removeMenu()
    {
        $bot = Solid::factory();
        Solid::setPageAccessToken(config('botfb.page_access_token'));

        return $bot->removeMenu();
    }
}
