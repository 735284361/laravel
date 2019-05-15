<?php

namespace App\Http\Middleware;

use Closure;
use Overtrue\Socialite\User as SocialiteUser;

class MockUser
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
        $user = new SocialiteUser([
            'id' => 'ovFDq1VUIzL6ed56AAnOMgAULXW0',//openid
            'name' => 'mock',
            'nickname' => 'mock user',
            'avatar' => '',
            'email' => null,
            'original' => [],
            'provider' => 'WeChat',
        ]);
        session(['wechat.oauth_user.default' => $user]);
        return $next($request);
    }
}
