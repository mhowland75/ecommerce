<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;
use Auth;

class AdministratorController extends Controller
{
  public function userActivity($id){
    $usersactivity = DB::table('user_track')->where('user_id',$id)->get();
    return view('administration.userActivity', compact('usersactivity'));

  }
  public function whosOnline(){

      $onlineUsers = DB::table('users')->whereIn('online',['1','2'])->get();
      foreach($onlineUsers as $user){

        $last_activity = new carbon($user->last_activity);
        $time = carbon::now();
        $sessionExpire = carbon::now()->subHours(2);
        $inactive = carbon::now()->subMinutes(1);
        if($last_activity <= $sessionExpire){
          DB::table('users')->where('id',$user->id)->update(['online'=>'0']);
        }
        elseif($last_activity < $inactive){
          DB::table('users')->where('id',$user->id)->update(['online'=>'2']);
        }
        elseif($last_activity > $inactive){
          DB::table('users')->where('id',$user->id)->update(['online'=>'1']);
        }
      }
      $users = DB::table('users')->whereIn('online',['1','2'])->get();
      foreach($users as $user){
        $lastLogin = new Carbon($user->last_login);
        $user->last_login = $lastLogin->diffForHumans();
        $lastLogout = new Carbon($user->last_logout);
        $user->last_logout = $lastLogout->diffForHumans();
        $lastActivity = new Carbon($user->last_activity);
        $user->last_activity = $lastActivity->diffForHumans();
      }

      $onlineUsers = DB::table('users')->where('online',1)->count();
      $inactiveUsers = DB::table('users')->where('online',2)->count();
      $offlineUsers = DB::table('users')->where('online',0)->count();
      return view('administration.whosOnline', compact('offlineUsers','inactiveUsers','onlineUsers','users'));
  }
    public function manageAdministration(){
      $admins = DB::table('administrator_privileges')->get();
      $data = array();
      foreach ($admins as $admin) {
        $x = array();
        $userInfo = DB::table('users')->where('id',$admin->user_id)->get();
        $x['userinfo'] = $userInfo;
        $x['admininfo'] = $admin;
        $data[] = $x;
      }
      return view('administration.manageAdmin', compact('data'));
    }

    public function insertAdministrator(request $request){
        $this->validate($request, [
          'email' => 'required|email|exists:users',
        ]);

        $user = DB::table('users')->where('email',$request->email)->get();
        $userexits = DB::table('administrator_privileges')->where('user_id',$user[0]->id)->get();
        if(empty($userexits[0]->id)){
          DB::table('administrator_privileges')->insert(
            ['user_id' => $user[0]->id, 'access_level' => $request->access_level, 'created_at'=> carbon::now()]
          );
        }
        else{
          return redirect('/administrator/manage')->withErrors(['User is already an administrator.']);
        }
        return redirect('/administrator/manage');

    }
    

    public function updateAdministrator(){
      if(isset($_POST)){
         unset($_POST['_token']);

        foreach($_POST as $id=>$access_level){
            $user = DB::table('administrator_privileges')->where('id',$id)->get();
              if($user[0]->user_id > '1'){

                DB::table('administrator_privileges')
                ->where('id', $id)
                ->update(['access_level' => $access_level]);
              }
            }
        }
      return redirect('/administrator/manage');
    }
    public function removeAdministrator($id){
      DB::table('administrator_privileges')->where('id', $id)->delete();
      return redirect('/administrator/manage');
    }
}
