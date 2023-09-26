<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Profile;
use Illuminate\Support\Facades\Auth;

class UserContoller extends Controller
{
    public function index(User $user){

      $profile = $user->profile()->get()[0];
      $userpic = Profile::select('userpic_path')->where('user_id',Auth::user()->id)->get()[0];
      $userposts = $user->post()->orderby('created_at','desc')->get();

      return view('profile')->with(['user' => $user,'profile'=> $profile,'userpic'=>$userpic,'userposts'=>$userposts,'authId'=>Auth::user()->id]);
    }

    public function getContactInfo(Request $request){
      $user = User::find($request->uid);
      $userpic = $user->profile()->get()[0];
      $result['username'] = $user->name;
      $result['userpic'] = $userpic->userpic_path;
      echo json_encode($result);
    }
}
