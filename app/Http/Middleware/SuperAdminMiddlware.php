<?php

namespace App\Http\Middleware;

use App\Traits\Helpers;
use Closure;

class SuperAdminMiddleware
{
    use Helpers;

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param string $methodsStr
     * @return mixed
     */
    public function handle($request, Closure $next, $methodsStr)
    {
        $methods_to_check = explode("-", $methodsStr);
        $current_route_method = explode("@", $request->route()[1]["uses"])[1];

        if(!in_array($current_route_method, $methods_to_check) || (in_array($current_route_method, $methods_to_check) && auth()->check() && $this->superAdminCheck())) {
            return $next($request);
        }

        return response('Operation denied.', 401);
    }
}
