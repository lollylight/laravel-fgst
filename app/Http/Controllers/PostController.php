<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;


class PostController extends Controller
{
    static function getUserpostsJson($uid){
        $userposts = Post::whereIn('user_id',$uid)->orderby('created_at','desc')->get();
        $upRaw = $userposts->toArray();
        $i = 0;
        foreach ($userposts as $post){
          $username = $post->user()->select('name')->get()[0]['name'];
          $comments = $post->comments()->get();
          $upRaw[$i]['images'] = $post->image()->get()->toArray();
          $upRaw[$i]['username'] = $username;
          $upRaw[$i]['comments'] = $comments;
          $i++;
        }
        $posts['content'] = $upRaw;
        $posts['type'] = 'userposts';
      return $posts;
    }

    static function getUserposts(Request $request){
        $userposts = Post::where('user_id',$request->uid)->orderby('created_at','desc')->get();
        $upRaw = $userposts->toArray();
        $i = 0;
        foreach ($userposts as $post){
          $username = $post->user()->select('name')->get()[0]['name'];
          $comments = $post->comments()->get();
          $upRaw[$i]['images'] = $post->image()->get()->toArray();
          $upRaw[$i]['username'] = $username;
          $upRaw[$i]['comments'] = $comments;
          $i++;
        }
      echo json_encode($upRaw);
    }

    public function showUserPost(Request $request){
      if($request->ajax()){
        $post = Post::where('id', $request->pid)->get()[0];
        $images = $post->image()->get();
        $username = $post->user()->select('name')->get()[0]['name'];

        echo json_encode(['post'=>$post, 'images'=>$images, 'username'=>$username]);
      }
    }

    public function createUserPost(Request $request){
      if($request->ajax()){
        $post = Post::create([
          'subject' => strip_tags($request->subject),
          'content' => strip_tags($request->content),
          'user_id' => Auth::user()->id
        ]);
        if($request->file('images') != null){
          foreach($request->images as $file){
            $path = 'post_images';
            $filename = rand(1000000,9999999) . 'p' . '.' . $file -> getClientOriginalExtension();
            // Storage::putFileAs($path, $file, $filename);
            $file -> move($path,$filename);
            $fullPath = '/post_images/' . $filename;

            $post->image()->create([
              'image' => $fullPath
            ]);
          }
        }
      }
      return;
    }

    public function deleteUserPost(Request $request){
      if($request -> ajax()){
        Post::where('id',$request->pid)->delete();
        return 'Deleted';
      }
    }

    private function shortText($text, $maxLength, $endSymbol = '...'){
      if(mb_strlen($text) <= $maxLength){
        return $text;
      }
      $shortenedText = mb_substr($text,0,$maxLength);
      $lastSpaceSymbol = mb_strrpos($shortenedText,' ');

      if($lastSpaceSymbol === false){
        return $shortenedText . $endSymbol;
      }
      return mb_substr($shortenedText, 0, $lastSpaceSymbol) . $endSymbol;
    }

}
