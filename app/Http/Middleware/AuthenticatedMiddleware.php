<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use DB;
use App\User;
use Carbon\Carbon;

class AuthenticatedMiddleware
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
      if(Auth::check()){
        DB::table('user_track')->insert(
          ['user_id' => Auth::id(), 'route' => $request->path(), 'created_at'=> carbon::now()]
        );
        DB::table('users')->where('id',Auth::id())->update(['last_activity'=>carbon::now()]);
        return $next($request);
      }
      return redirect('/login');
    }
}
