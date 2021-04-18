<?php

namespace App\Http\Middleware;

use App;
use Auth;
use Closure;
use app\Helpers\RedisUser;

class GetUserSettings
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::check() && (!RedisUser::exist() || !RedisUser::get('isActive'))){
            RedisUser::store();  
            return RedisUser::get('isActive') ? $next($request) : abort(503, 'Unauthorized action.');
        } else {
            return $next($request);
        }
    }
}
