<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
class IsAgent
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
        $user = Auth::guard()->user();
        if($user->role[0]['id']===3){
            return $next($request);
        }
        return response(['status'=>false,'Message'=>'This is restricted area. Choose the other way']);
   
    }
}
