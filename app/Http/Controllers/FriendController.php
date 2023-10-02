<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Friend;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class FriendController extends Controller
{
    public function sendFriendRequest(Request $request){
      if ($request->ajax()){
        Friend::create([
          'first_user_id' => Auth::user()->id,
          'second_user_id' => $request->sid,
          'status' => '0'
        ]);
      }
    }

    public function checkFriendStatus(Request $request){
      if ($request -> ajax()){
        $uid = Auth::user()->id;
        $sid = $request->sid;
        $friends = Friend::where(function($query) use ($uid,$sid){
          $query->where('first_user_id',$uid)->where('second_user_id',$sid);
        })->orWhere(function($query) use ($uid,$sid){
          $query->where('second_user_id', $uid)->where('first_user_id',$sid);
        })->get();
        if (!$friends->isEmpty()){
          $result = ['info'=>$friends[0]];
          echo json_encode($result);
        }else{
          $result = ['status'=>'2'];
          echo json_encode(['info'=> $result]);
        }
      }
    }

    public function checkFriendsRequests(Request $request){
      if ($request->ajax()){
        $uid = Auth::user()->id;
        $friends = Friend::where('first_user_id', $uid)->orWhere('second_user_id', $uid)->get();

        foreach ($friends as $friend){

          if ($friend->first_user_id != $uid && $friend->status != 1){
            $userpic = Profile::select('userpic_path')
                                ->where('user_id', $friend->first_user_id)
                                ->get()[0]['userpic_path'];

            $username = User::select('name')
                                ->where('id', $friend->first_user_id)
                                ->get()[0]['name'];

            ?>
              <div class="request_card flex flex-row h-15 w-full rounded-md border-r-[1px] border-b-[1px] border-red-600/50 bg-neutral-800/25 hover:bg-neutral-600/25">
                <a href="/profile/<?php echo $friend->first_user_id;?>">
                <div class="rc_pic_box p-1.5">
                  <img src="<?php echo $userpic;?>" class="rc_pic rounded-md">
                </div>
              </a>
                <div class="text-xl font-bold pt-[14px] pl-2 w-[60%]">
                  <?php echo $username;?>
                </div>
                <div class="pt-[14px]">
                  <button id="accept_<?php echo $friend->id;?>" class="req_accept">
                    <svg width="35px" height="35px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <rect width="24" height="24" fill="none"/>
                      <path d="M5 13.3636L8.03559 16.3204C8.42388 16.6986 9.04279 16.6986 9.43108 16.3204L19 7" stroke="#ffffff" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                  </button>

                  <button id="cancel_<?php echo $friend->id;?>" class="req_cancel">
                    <svg width="35px" height="35px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <rect width="24" height="24" fill="none"/>
                      <path d="M7 17L16.8995 7.10051" stroke="#ffffff" stroke-linecap="round" stroke-linejoin="round"/>
                      <path d="M7 7.00001L16.8995 16.8995" stroke="#ffffff" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                  </button>
                </div>
              </div>

            <?php
          }
        }
      }
    }

    function getFriends(Request $request){
      if ($request->ajax()){
        $uid = $request->uid;
        $friends = Friend::where('first_user_id', $uid)->orWhere('second_user_id', $uid)->get();
        foreach ($friends as $friend){
          if ($friend->status === 1){
            if ($friend->first_user_id != $uid){
              $userpic = Profile::select('userpic_path')
              ->where('user_id', $friend->first_user_id)
              ->get()[0]['userpic_path'];


              $username = User::select('name')
              ->where('id', $friend->first_user_id)
              ->get()[0]['name'];
              $friendId = $friend->first_user_id;
            }
            elseif($friend->first_user_id == $uid){
              $userpic = Profile::select('userpic_path')
              ->where('user_id', $friend->second_user_id)
              ->get()[0]['userpic_path'];

              $username = User::select('name')
              ->where('id', $friend->second_user_id)
              ->get()[0]['name'];
              $friendId = $friend->second_user_id;
            }


          if (isset($friendId)){
          ?>

          <a href="/profile/<?php echo $friendId;?>">

            <div id="card_<?php echo $friendId;?>" class="flex flex-row h-15 w-full rounded-md border-r-[1px] border-b-[1px] border-teal-600/50 bg-neutral-800/25 hover:bg-neutral-600/25">
              <div class="fc_pic_box p-1.5">
                <img src="<?php echo $userpic;?>"class="fc_userpic rounded-md">
              </div>
              <div class="text-xl font-bold pt-[14px] pl-2">
                <?php echo $username;?>
              </div>
            </div>

          </a>

          <?php
        }
      }
        }
      }
    }

    function getFriendsToContact(Request $request){
      if ($request->ajax()){
        $uid = $request->uid;
        $friends = Friend::where('first_user_id', $uid)->orWhere('second_user_id', $uid)->get();
        foreach ($friends as $friend){
          if ($friend->status === 1){
            if ($friend->first_user_id != $uid){
              $userpic = Profile::select('userpic_path')
              ->where('user_id', $friend->first_user_id)
              ->get()[0]['userpic_path'];


              $username = User::select('name')
              ->where('id', $friend->first_user_id)
              ->get()[0]['name'];
              $friendId = $friend->first_user_id;
            }
            elseif($friend->first_user_id == $uid){
              $userpic = Profile::select('userpic_path')
              ->where('user_id', $friend->second_user_id)
              ->get()[0]['userpic_path'];

              $username = User::select('name')
              ->where('id', $friend->second_user_id)
              ->get()[0]['name'];
              $friendId = $friend->second_user_id;
            }


          if (isset($friendId)){
          ?>


            <div id="card_<?php echo $friendId;?>" class="card flex flex-row h-15 w-full rounded-md border-r-[1px] border-b-[1px] border-teal-600/50 bg-neutral-800/25 hover:bg-neutral-600/25 cursor-pointer">
              <div class="fc_pic_box p-1.5">
                <a href="/profile/<?php echo $friendId;?>">
                  <img class="card-userpic" src="<?php echo $userpic;?>"class="fc_userpic rounded-md">
                </a>
              </div>
              <div class="card-username text-xl font-bold pt-[14px] pl-2">
                <?php echo $username;?>
              </div>
            </div>



          <?php
        }
      }
        }
      }
    }

    public function manageFriendRequest(Request $request){
      if($request->ajax()){
        if ($request->action === 'accept'){
          Friend::where('id',$request->rid)->update(['status' => '1']);
        }
        elseif($request->action === 'cancel'){
          Friend::where('id',$request->rid)->delete();
        }
      }
    }

    public function deleteFriend(Request $request){
      if($request->ajax()){
        Friend::where('first_user_id', $request->uid)
                ->orWhere('second_user_id',$request->uid)
                ->delete();
      }
    }

    static function getFriendsId($uid){
          $friends = Friend::where('first_user_id', $uid)->orWhere('second_user_id', $uid)->get();
          if ( !$friends->isEmpty() ){
            $friendsId = [];
            foreach ( $friends as $friend ){
              if($friend->first_user_id != $uid){
                $friendsId[] = $friend->first_user_id;
              } else{
                $friendsId[] = $friend->second_user_id;
              }
            }
            return $friendsId;
          } else{
            return 'none';
          }
    }
}
