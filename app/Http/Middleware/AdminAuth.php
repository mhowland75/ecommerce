<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use DB;

class AdminAuth
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
      $user = DB::table('administrator_privileges')->where('user_id', Auth::id())->get();
      if($user[0]->access_level == 1){
        return $next($request);
      }
      return redirect('/login');
    }
}
