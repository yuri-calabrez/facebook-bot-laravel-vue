<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Element extends Model
{
    protected $fillable = [
        'type',
        'title',
        'postback',
        'webview_height_ratio',
        'message_id'
    ];
}
