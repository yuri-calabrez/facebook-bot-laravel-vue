<?php

namespace App\Repositories;


use App\Suggestion;
use Illuminate\Support\Facades\Redis;

class SuggestionsRepository
{
    public function statusStart($senderId)
    {
        Redis::set('suggestion::start::' . $senderId, 'started');
    }

    public function statusCheck($senderId)
    {
        return Redis::get('suggestion::start::' . $senderId);
    }

    public function statusStop($senderId)
    {
        Redis::del('suggestion::start::' . $senderId);
    }

    public function create($senderId, $suggestion)
    {
        Suggestion::create([
           'user_face_id' => $senderId,
           'suggestion' => $suggestion
        ]);
    }

}