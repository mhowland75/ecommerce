<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\User;
use App\Review;
use Carbon\Carbon;
use Auth;
use Hash;
use Illuminate\Support\Facades\Storage;
class UserController extends Controller
{
    public function changePassword(){
      if(Auth::check()){
        $test = DB::table('users')->where([['id',Auth::id()]])->get();
        if($test[0]->id){
          return view('user.changePassword');
        }
      }
      else{
        return redirect()->back();
      }

    }

    public function updatePassword(request $request){
      $this->validate($request, [
          'newpassword' => 'required|string|min:6',
          'repeatpassword' => 'required|string|min:6',
      ]);
      if($request->newpassword == $request->repeatpassword){
        DB::table('users')
              ->where('id', Auth::id())
              ->update(['password' => bcrypt($request->password)]);
              return redirect('/users/password/edit')->withErrors(['Password Updated']);
        }
        return redirect()->back()->withErrors(['The passwords you have entered do not match']);
      }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(request $request)
    {
      $searchError = 0;
      if(!empty($request->search)){
        $search = $request->search;
            $users=array();
            $x = DB::table('users')->where('name', 'Like', '%'.$request->search.'%')->get();
            foreach($x as $y){
              $users[] = $y;
            }
            $x = DB::table('users')->where('email', 'Like', '%'.$request->search.'%')->get();
            //if x is empty skip array addition
            if(!empty($x[0]->id)){
              //loop though x
              foreach($x as $y){
                //if users is empty skip entery check
                if(!empty($users[0]->id)){
                  foreach($users as $user){
                    //loop though users if user id is found in the db call
                      if($user->id == $y->id){
                        break;
                      }
                      else{
                        $users[] = $y;
                        break;
                      }
                  }
                }
                else{
                  $users[] = $y;
                }
              }
            }
            if(empty($users[0]->id)){
              $users = DB::table('users')->paginate(50);
              $searchError = 1;
            }
          }else{
            $search = '';
              $users = DB::table('users')->paginate(50);
          }
          foreach($users as $user){
            $lastLogin = new Carbon($user->last_login);
            $user->last_login = $lastLogin->diffForHumans();
            $lastLogout = new Carbon($user->last_logout);
            $user->last_logout = $lastLogout->diffForHumans();
            $createdAt = new Carbon($user->created_at);
            $user->created_at = $createdAt->diffForHumans();
            $lastActivity = new Carbon($user->last_activity);
            $user->last_activity = $lastActivity->diffForHumans();
          }


       $current = Carbon::now();
       $time = $current->subDays(7);
       $totalUsers = DB::table('users')->count();
       $loggedinUsers = DB::table('users')->where('online','>',0)->count();
       $registredUsers = DB::table('users')->where('created_at','>',$time)->count();

        return view('user.index', compact('searchError','registredUsers','loggedinUsers','totalUsers','users','searchBy','search'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
          $users = DB::table('users')->where('id',$id)->get();
          $addresss = DB::table('address')->where('user_id',$id)->get();
          $reviews = DB::table('reviews')->where('user_id',$id)->get();
          foreach($reviews as $review){
            $review->rating = Review::starRating($review->rating);
          }
          $orders = DB::table('orders')->where('user_id',$id)->get();
          $last_login = new Carbon($users[0]->last_login);
          $now = Carbon::now();
          //return $last_login;
          // $last_login->diffForHumans($now);
          //return str_replace("before","ago",$last_login->diffForHumans($now));
          return view('user.show', compact('users','addresss','reviews','orders'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
      if(Auth::check()){
        $test = DB::table('users')->where([['id',Auth::id()]])->get();
        if($test[0]->id){
          $users = User::findOrFail(Auth::id());
            return view('user.edit', compact('users'));
        }
      }
      else{
        return redirect()->back();
      }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
      if(Auth::check()){
        $test = DB::table('users')->where([['id',Auth::id()]])->get();
        if($test[0]->id){
          $users = User::findOrFail(Auth::id());
          $users->update($request->all());
          return redirect('/user/edit');
        }
      }
      else{
        return redirect()->back();
      }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
