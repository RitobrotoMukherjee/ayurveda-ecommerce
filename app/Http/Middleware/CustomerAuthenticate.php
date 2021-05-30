<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class CustomerAuthenticate extends Middleware
{
    
    protected function authenticate($request, array $guards)
    {
//        dd($guards);
        if ($this->auth->guard('customer')->check()) {
            return $this->auth->shouldUse('customer');
        }
        $this->unauthenticated($request, ['customer']);
    }
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            return route('customer.login');
        }
    }
}
