<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class CommentContorller extends Controller
{
    public function sendComment(Request $request){
      if($request->ajax()){
        $comment = Comment::create([
          'content' => $request->content,
          'user_id' => Auth::user()->id,
          'post_id' => $request->pid,
          'reply_to' => $request->reply_to
        ]);
      }
    }

    public function updateComments(Request $request){
      if($request->ajax()){
        $commRaw = Comment::where('post_id',$request->pid)->get()->toArray();
        $comments = [];
        foreach($commRaw as $comm){
          $comm['username'] = User::select('name')->where('id',$comm['user_id'])->get()[0]['name'];
          $comments[] = $comm;
        }
        echo json_encode($comments);
      }
    }
}
