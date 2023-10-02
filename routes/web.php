<?php

use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Models\Profile;
use App\Http\Controllers\ProfileController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/', function () {
    return view('auth.login');
});

Route::get('/profile/{user}','App\Http\Controllers\UserContoller@index')->middleware(['auth'])->name('profile');
Route::get('/profile',function () {
  if ( !Auth::user() == null ){
    return redirect()->route('profile',['user'=>Auth::user()->id]);
  }
  return view('auth.login');
});

Route::get('/newsline',function () {
  $userpic = Profile::select('userpic_path')->where('user_id',Auth::user()->id)->get()[0];
  return view('newsline',['user'=>Auth::user()->id,'userpic'=>$userpic,'authId'=>Auth::user()->id]);
})->middleware(['auth'])->name('forum');

Route::get('/forum', function () {
    $userpic = Profile::select('userpic_path')->where('user_id',Auth::user()->id)->get()[0];
    return view('forum',['userpic'=>$userpic,'authId'=>Auth::user()->id]);
})->middleware(['auth'])->name('forum');

Route::get('/messages','App\Http\Controllers\MessagesController@index')->middleware(['auth'])->name('messages');
Route::get('/forum/{slug}','App\Http\Controllers\CategoryController@show')->middleware(['auth']);
Route::get('/forum/{slug}/{thread}','App\Http\Controllers\ThreadController@showThread')->middleware(['auth']);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::post('/update-profile', 'App\Http\Controllers\ProfileController@updateProfile');
Route::post('/update-userpic', 'App\Http\Controllers\ProfileController@updateUserpic');
Route::post('/create-userpost', 'App\Http\Controllers\PostController@createUserPost');
Route::post('/create-thread', 'App\Http\Controllers\ThreadController@createThread');
Route::post('/get-threads', 'App\Http\Controllers\ThreadController@showContent');
Route::post('/send-reply', 'App\Http\Controllers\ReplyController@sendReply');
Route::post('/get-replies', 'App\Http\Controllers\ReplyController@showContent');
Route::post('/get-current-post', 'App\Http\Controllers\PostController@showUserPost');
Route::post('/get-all-posts', 'App\Http\Controllers\PostController@getUserposts');
Route::post('/delete-userpost', 'App\Http\Controllers\PostController@deleteUserPost');
Route::post('/send-comment', 'App\Http\Controllers\CommentContorller@sendComment');
Route::post('/update-comments', 'App\Http\Controllers\CommentContorller@updateComments');
Route::post('/send-friend-request', 'App\Http\Controllers\FriendController@sendFriendRequest');
Route::post('/check-friend-status', 'App\Http\Controllers\FriendController@checkFriendStatus');
Route::post('/check-friends-requests', 'App\Http\Controllers\FriendController@checkFriendsRequests');
Route::post('/get-friends', 'App\Http\Controllers\FriendController@getFriends');
Route::post('/get-friends-to-contact', 'App\Http\Controllers\FriendController@getFriendsToContact');
Route::post('/manage-friend-request', 'App\Http\Controllers\FriendController@manageFriendRequest');
Route::post('/delete-friend', 'App\Http\Controllers\FriendController@deleteFriend');
Route::post('/get-contactinfo', 'App\Http\Controllers\UserContoller@getContactInfo');
Route::post('/send-message', 'App\Http\Controllers\MessagesController@sendMessage');
Route::post('/get-messages', 'App\Http\Controllers\MessagesController@getMessages');
Route::post('/get-contacts', 'App\Http\Controllers\MessagesController@getContacts');
Route::post('/get-news', 'App\Http\Controllers\NewslineController@getNews');
Route::post('/is-fav', 'App\Http\Controllers\LikeController@isCatFav');
Route::post('/set-fav', 'App\Http\Controllers\LikeController@setFavCat');
Route::post('/delete-fav', 'App\Http\Controllers\LikeController@deleteFavCat');

require __DIR__.'/auth.php';
