<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use DB;
use Illuminate\Support\Facades\File;
class ImageController extends Controller
{
  public function manageImages($id)
  {
    $products = DB::table('products')->where('id',$id)->get();
    $images = DB::table('product_images')->where('product_id',$id)->get();
    //return $images;
    return view('productImages.manageImages',compact('id','products','images'));
  }
  public function addImage(request $request){
    $this->validate($request, [
      'image' => 'image',
  ]);
    if(Input::hasFile('image')){
      $file = Input::file('image');
      $file->move('products/', $file->getClientOriginalName());
      $image = '/products/'.$file->getClientOriginalName();
      DB::table('product_images')->insert(
        ['product_id' => $request->product_id, 'image' => $image]
      );
    }
    return redirect()->back();
  }
  public function removeImage($id){
    $filename = DB::table('product_images')->where('id', $id)->get();
    File::delete($filename[0]->image);
    DB::table('product_images')->where('id', $id)->delete();

    return redirect()->back();
  }
}
