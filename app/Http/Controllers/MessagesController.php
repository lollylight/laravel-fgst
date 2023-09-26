<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Profile;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;

class MessagesController extends Controller
{
  public function index(){
    $user = User::where('id',Auth::user()->id)->get()[0];
    $profile = $user->profile()->get()[0];
    return view('messages')->with(['user' => $user,'userpic'=>$profile,'authId'=>Auth::user()->id]);
  }
  public function sendMessage(Request $request){
    if($request->ajax() && $request->from != $request->to){
      $message = Message::create([
        'from' => $request->from,
        'to' => $request->to,
        'content' => $request->message
      ]);
      if($request->file('images') != null){
        foreach($request->images as $file){
          $path = 'message_images';
          $filename = rand(1000000,9999999) . 'm' . '.' . $file -> getClientOriginalExtension();
          // Storage::putFileAs($path, $file, $filename);
          $file -> move($path,$filename);
          $fullPath = '/message_images/' . $filename;

          $message->media()->create([
            'image' => $fullPath
          ]);
          $img[] = $fullPath;
        }
        $response['images'] = $img;
      }
      $response['content'] = $request->message;
      $response['date'] = str_replace(' ','T', date("Y-m-d H:i:s", time()));
      echo json_encode($response);
    }
  }

  public function getMessages(Request $request){
    if ($request->ajax()){
      $cid = $request->cid;
      $uid = Auth::user()->id;
      $messages = Message::where(function($query) use ($cid,$uid){
        $query->where('from', $uid)->where('to',$cid);
      })->orWhere(function($query) use ($cid,$uid){
        $query->where('from',$cid)->where('to',$uid);
      })->get();
      $username = User::where('id',$request->cid)->select('name')->get();
      $userpic = Profile::where('user_id',$request->cid)->select('userpic_path')->get();
      $result = [];
      foreach($messages as $message){
        $pic = $message->media()->select('image')->get();
        $media = [];
        foreach ($pic as $picture){
          $media[] = $picture['image'];
        }
        $msg = $message->toArray();
        $msg['media'] = $media;
        $result[] = $msg;
      }

      $response['messages'] = $result;
      $response['username'] = $username[0]['name'];
      $response['userpic'] = $userpic[0]['userpic_path'];
      $response['date'] = date("Y-m-d", time());
      echo json_encode($response);
    }
  }
  public function getContacts(Request $request){
      $messages = Message::where('from', $request->uid)->orWhere('to',$request->uid)->distinct()->get();
      $rawIdList = [];
      foreach($messages as $message){
        if($message->from != $request->uid){
          $rawIdList[] = $message->from;
        }
        if($message->to != $request->uid){
          $rawIdList[] = $message->to;
        }
      }
      $idList = array_unique($rawIdList);
      $contacts = [];
      $contact = [];
      foreach($idList as $id){
        $username = User::where('id',$id)->select('name')->get()->toArray();
        $userpic = Profile::where('user_id',$id)->select('userpic_path')->get()->toArray();
        $contact['id'] = $id;
        $contact['username'] = $username[0]['name'];
        $contact['userpic'] = $userpic[0]['userpic_path'];
        $contacts[] = $contact;
      }
      echo json_encode($contacts);
  }
}
