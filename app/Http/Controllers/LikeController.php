<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\CategoryController;
use App\Models\LikeCategory;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function setFavCat(Request $request){
      $catId = CategoryController::getCategoryId($request->cid);
      LikeCategory::create([
        'user_id' => Auth::user()->id,
        'cat_id' => $catId
      ]);
    }

    public function deleteFavCat(Request $request){
      $catId = CategoryController::getCategoryId($request->cid);
      LikeCategory::where('user_id', Auth::user()->id)->where('cat_id', $catId)->delete();
    }

    public function isCatFav(Request $request){
      $catId = CategoryController::getCategoryId($request->cid);
      $isTrue = LikeCategory::where('user_id',Auth::user()->id)->where('cat_id', $catId)->get();
      if ( !$isTrue->isEmpty() ){
        $result['status'] = 1;
      } else {
        $result['status'] = 0;
      }
      echo json_encode($result);
    }

    static function getAllFavCats(){
      $categories = LikeCategory::select('cat_id')->where('user_id', Auth::user()->id)->get();
      $result = [];
      if ( !$categories->isEmpty() ){
        foreach ( $categories as $cat ){
          $result[] = $cat->cat_id;
        }
        return $result;
      }
      return 'none';
    }
}
