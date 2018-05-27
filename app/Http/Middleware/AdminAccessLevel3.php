<?php

namespace App\Http\Middleware;

use Closure;
use DB;
use Auth;
use App\User;
use Carbon\Carbon;
class AdminAccessLevel3
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
       if(empty($user[0]->id)){
         return redirect('/home');
       }
       if($user[0]->access_level <= 3){
         DB::table('user_track')->insert(
           ['user_id' => Auth::id(), 'route' => $request->path(), 'created_at'=> carbon::now()]
         );
         return $next($request);
       }
       return redirect('/restrictedAccess');
     }
}
