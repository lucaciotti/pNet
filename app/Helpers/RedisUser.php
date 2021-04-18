<?php
namespace App\Helpers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;

class RedisUser
{
    private static $prefix = "user_config:";

    public static function exist(){
        return Redis::exists(static::$prefix.Auth::user()->id);
    }

    public static function store(){
        $user = Auth::user();
        $ditta = 'pNet_DB';
        $settings = [
            'ditta_DB' => $ditta,
            'location' => 'it',
            'role' => $user->roles()->first()->name,
            'codag' => (string)$user->codag,
            'codcli' => (string)$user->codcli,
            'codforn' => (string)$user->codfor,
            'lang' => (string)$user->lang,
            'isActive' => $user->isActive,
        ];
        
        Redis::hmset(static::$prefix.$user->id, $settings);

        return Redis::expire(static::$prefix.$user->id, 1800);
    }

    public static function getAll(){
        return Redis::hgetAll(static::$prefix.Auth::user()->id);
    }

    /* public static function set($name) {
        return Redis::set(static::$prefix."1", $name);
    } */

    public static function get($name) {
        return Redis::hget(static::$prefix.Auth::user()->id, $name);
    }

}