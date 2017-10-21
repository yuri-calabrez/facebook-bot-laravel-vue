<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MenuButton extends Model
{
    protected $fillable = [
        'type',
        'title',
        'value',
        'parent_id',
        'menu_id'
    ];

    public $timestamps = false;
}
