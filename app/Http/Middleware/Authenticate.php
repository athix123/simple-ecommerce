<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Factory as Auth;
use App\Pengguna;

class Authenticate
{
    /**
     * The authentication guard factory instance.
     *
     * @var \Illuminate\Contracts\Auth\Factory
     */
    protected $auth;

    /**
     * Create a new middleware instance.
     *
     * @param  \Illuminate\Contracts\Auth\Factory  $auth
     * @return void
     */
    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if ($this->auth->guard($guard)->guest()) {
            $token = $request->header('token');
            if ($token) {
                $token = $request->header('token');
                $check_token = Pengguna::where('token', $token)->first();
                if ($check_token == null) {
                    $res['success'] = false;
                    $res['message'] = 'Permission not allowed!';

                    return response('Unauthorized.', 401);
                }
            }else{
                $res['success'] = false;
                $res['message'] = 'Login please!';


            return response($res, 403);
        }

        return $next($request);
        }
    }
}
