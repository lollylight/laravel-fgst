<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Profile;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    private function getProfile($id){
      $profile = Profile::where('user_id',$id)->get()[0];
      return $profile;
    }
    private function getUserpic($id){
      $picPath = Profile::select('userpic_path')->where('user_id',$id)->get()[0];
      return $picPath;
    }

    public function updateProfile(Request $request){
      if ($request->ajax()){
        Profile::where('user_id',$request->uid)->update([
          'name' => $request->name,
          'age' => $request->age,
          'sex'=> $request->sex,
          'country'=> $request->country
        ]);
        return json_encode($this->getProfile($request->uid));
      } else{
        return 'Error';
      }
    }

    public function updateUserpic(Request $request){
      if ($request->ajax()){
        $file = $request->file('image');
        $path = 'userpics';
        $filename = 'userpic_' . $request->uid . '.' . $file -> getClientOriginalExtension();
        // Storage::putFileAs($path, $file, $filename);
        $file -> move($path,$filename);
        $fullPath = '/userpics/' . $filename;

        Profile::where('user_id',$request->uid)->update([
          'userpic_path'=> $fullPath
        ]);
        return json_encode($this->getUserpic($request->uid));
      }
    }
}
