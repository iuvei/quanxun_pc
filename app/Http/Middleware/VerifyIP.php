<?php

namespace App\Http\Middleware;

use Closure;
use App\Model\Ip;

class VerifyIP
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
        $allowed = Ip::ip_info()->select('i_ip')->get();
        $flipped = [];
        foreach ($allowed as $val){
            $flipped[] = $val->i_ip;
        }
	    if(!in_array($request->ip(), $flipped)) {
            return response()->json(['status' => 'Illegal IP']);
        }
        return $next($request);
    }
}
