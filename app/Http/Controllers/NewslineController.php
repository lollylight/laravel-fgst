<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\PostController;
use App\Http\Controllers\FriendController;
use App\Http\Controllers\ThreadController;
use App\Http\Controllers\LikeController;
use App\Models\Post;
use App\Models\Thread;

class NewslineController extends Controller
{
  public function getNews(Request $request){
    if ($request->type === 'userposts'){
      $friendsId = FriendController::getFriendsId(Auth::user()->id);
      if ( $friendsId != 'none' ){
        $posts = PostController::getUserpostsJson($friendsId);
        echo json_encode($posts);
      } else {
        $posts = ['content' => [], 'type' => 'userposts' ];
        echo json_encode($posts);
      }
    }
    elseif ($request->type === 'news'){
      $news = ThreadController::getThreads('news');
      echo json_encode($news);
    }
    elseif ($request->type === 'threads'){
      $cats = LikeController::getAllFavCats();
      if ( $cats != 'none' ){
        $threads = ThreadController::getFavThreads($cats);
        echo json_encode($threads);
      } else {
        $threads = ['content' => [], 'type' => 'threads' ];
        echo json_encode($threads);
      }
    }
  }
}
