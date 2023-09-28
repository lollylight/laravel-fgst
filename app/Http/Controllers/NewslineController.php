<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\PostController;
use App\Http\Controllers\FriendController;
use App\Http\Controllers\ThreadController;
use App\Models\Post;
use App\Models\Thread;

class NewslineController extends Controller
{
  public function getNews(Request $request){
    if ($request->type === 'userposts'){
      $friendsId = FriendController::getFriendsId(Auth::user()->id);
      $posts = PostController::getUserpostsJson($friendsId);
      echo json_encode($posts);
    }
    elseif ($request->type === 'news'){
      $news = ThreadController::getThreads('news');
      echo json_encode($news);
    }
    elseif ($request->type === 'threads'){

    }
  }
}
