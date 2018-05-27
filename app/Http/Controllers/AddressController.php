<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use App\Address;
use App\User;

class AddressController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

      $addresss = DB::table('address')->where('user_id', Auth::id())->get();
        return view('address.index', compact('addresss'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('address.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $this->validate($request, [
        'firstline' => 'required|max:30|min:8',
        'secondline' => 'required|max:30|min:8',
        'city' => 'required|max:20|min:3',
        'county' => 'required|max:10|min:3',
        'postcode' => 'required|max:8|min:5',
        'tel1' => 'required|max:15|min:8',
        'tel2' => 'max:15|min:8',

    ]);
     $address = DB::table('address')->where('user_id', Auth::id())->get();
      if(count($address) <= 2){
        $address = new Address;
        $address->user_id = Auth::id();
        $address->firstline= $request->firstline;
        $address->secondline = $request->secondline;
        $address->city = $request->city;
        $address->county = $request->county;
        $address->postcode = $request->postcode;
        $address->tel1 = $request->tel1;
        $address->tel2 = $request->tel2;


        $address->save();
         return redirect('/address');
      }
      else{
        return redirect('/address');
      }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $address = DB::table('address')->where([['id', $id],['user_id',Auth::id()]])->get();
        if(empty($address[0]->id)){
          return redirect()->back();
        }
        $test = User::userVerifiaction($address[0]->user_id);
        if($test){
          $address = Address::findOrFail($id);
            return view('address.edit', compact('address'));
        }
        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
      $this->validate($request, [
        'firstline' => 'required|max:30|min:8',
        'secondline' => 'required|max:30|min:8',
        'city' => 'required|max:20|min:3',
        'county' => 'required|max:10|min:3',
        'postcode' => 'required|max:8|min:5',
        'tel1' => 'required|max:15|min:8',
        'tel2' => 'max:15|min:8',
    ]);
      $address = Address::findOrFail($id);
      $test = User::userVerifiaction($address->user_id);
      if($test){
        $address->update($request->all());
        return redirect('/address');
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
      $address = DB::table('address')->where([['id',$id],['user_id',Auth::id()]])->get();
      $test = User::userVerifiaction($address[0]->user_id);
      if($test){
        Address::destroy($id);
        return redirect('/address');
      }
    }
}
