<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Profile;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    public function show($slug){
      $userpic = Profile::select('userpic_path')->where('user_id',Auth::user()->id)->get()[0];
      $cat = Category::where('catlink',$slug)->get();
      if(!$cat->isEmpty()){
        return view('category')->with(['userpic'=>$userpic,'cat'=>$cat[0],'authId'=>Auth::user()->id]);
      }else{
        return abort(404);
      }
    }

    static function getCategoryId($catName){
      $cat = Category::select('id')->where('catlink',$catName)->get()->toArray()[0]['id'];
      return $cat;
    }
}
