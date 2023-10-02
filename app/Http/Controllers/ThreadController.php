<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Thread;
use App\Models\Category;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ThreadController extends Controller
{
    public function showThread($slug, Thread $thread){
      $userpic = Profile::select('userpic_path')->where('user_id',Auth::user()->id)->get()[0];
      $cat = Category::where('catlink',$slug)->get();
      $uid = Auth::user()->id;
      $username = User::select('name')->where('id',$thread->user_id)->get()[0]['name'];
      if(!$cat->isEmpty()){
        return view('thread')->with(['userpic'=>$userpic,'cat'=>$cat[0],'thread'=>$thread,'username'=>$username,'uid'=>$uid,'authId'=>Auth::user()->id]);
      }else{
        return abort(404);
      }
    }

    static function getThreads($cat){
      $catId = Category::select('id')->where('catlink',$cat)->get()->toArray()[0]['id'];

      $rawThread = Thread::where('cat_id',$catId)->orderby('created_at','desc')->get();
      $threads = [];
      if ( !$rawThread->isEmpty() ){
        
        foreach ($rawThread as $thread){
          $elem = $thread->toArray();
          $elem['user_replies'] = array_reverse($thread->replies()->orderby('created_at','DESC')->take(3)->get()->toArray());
          $elem['username'] = $username = User::select('name')->where('id',$elem['user_id'])->get()[0]['name'];
          $threads[] = $elem;
        }
        $result['content'] = $threads;
        if ($catId = 3){
          $result['type'] = 'news';
        }
        return $result;

      } else {
        $result['content'] = [];
        if ($catId = 3){
          $result['type'] = 'news';
        }
        return $result;
      }
    }

    static function getFavThreads($cats){
      $rawThreads = Thread::whereIn('cat_id', $cats)->orderby('created_at','desc')->get();
      $threads = [];
      $result = [];
      if ( !$rawThreads->isEmpty() ){

        foreach ( $rawThreads as $thread){
          $elem = $thread->toArray();
          $elem['user_replies'] = array_reverse($thread->replies()->orderby('created_at','DESC')->take(3)->get()->toArray());
          $elem['username'] = User::select('name')->where('id',$elem['user_id'])->get()[0]['name'];
          $elem['catname'] = Category::select('catname')->where('id', $elem['cat_id'])->get()[0]['catname'];
          $elem['catlink'] = Category::select('catlink')->where('id', $elem['cat_id'])->get()[0]['catlink'];
          $threads[] = $elem;
        }
        $result['content'] = $threads;
        $result['type'] = 'threads';
        return $result;

      } else {
        $result['content'] = [];
        $result['type'] = 'threads';
        return $result;
      }
    }


    public function createThread(Request $request){
      if ($request->ajax()){
        if($request->file('image') != null){
          $file = $request->file('image');
          $path = 'OP_pics';
          $filename = rand(0000000, 9999999) . 'o' . '.' . $file -> getClientOriginalExtension();
          // Storage::putFileAs($path, $file, $filename);
          $file -> move($path,$filename);
          $fullPath = '/OP_pics/' . $filename;
        }else{
          $fullPath = $request->image;
        }

        $thread = Thread::create([
          'subject' => $request->subject,
          'content' => $request->content,
          'cat_id' => $request->cid,
          'user_id' => Auth::user()->id,
          'image' => $fullPath,
          'replies' => '0'
        ]);
        return $this->getThreads($request->cid);
      }
    }

    public function showContent(Request $request){
      $threads = self::getThreads($request->cid);
      echo json_encode($threads);
    }

}
