<?php

namespace App\Http\Middleware;

use Closure;
use App\Helpers\RedisUser;
use Illuminate\Http\Request;
use App\Models\PrivacyUserAgree;
use Illuminate\Support\Facades\Auth;

class PrivacyPolicy
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && RedisUser::get('role')=='client') {
            $privacyAgreementUser = PrivacyUserAgree::where('user_id', Auth::user()->id)->first();
            if(!$privacyAgreementUser || !$privacyAgreementUser->privacy_agreement){
                // dd($request);
                return redirect()->action('App\Http\Controllers\sysCtrl\PrivacyPolicyController@index', Auth::user()->id);
            } else {
                return $next($request);
            }
        } else {
            return $next($request);
        }
    }
}
