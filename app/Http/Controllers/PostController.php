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

    public function getUserpostsLegacy(Request $request){
      if ($request->ajax()){
        $userposts =  Post::where('user_id',$request->uid)->orderby('created_at','desc')->get();
        ?>
        <?php
        foreach($userposts as $post){
          $images =$post->image()->get();?>

          <div id="<?php echo $post->id;?>" class="userpost border-b-[1px] border-teal-600/50 w-full flex flex-col p-1 bg-gray-900/25 rounded-md border-r-[1px] cursor-pointer">

            <div class="w-full mt-3 ">
              <h2 class="text-[26px] font-bold ml-2"><?php echo $post->subject;?></h2>
            </div>

            <div class="w-full my-4 px-3 text-lg">
              <?php echo nl2br($this->shortText($post->content,312));?>
            </div>

            <?php if(!$images->isEmpty()){ ?>

              <div class="flex flex-row p-3 border-t-[1px] border-teal-800/25 mt-1">
                <div class="border-r-[1px] border-teal-800/25 bb_col">
                  <?php for($i = 0; $i < 1; $i++){ ?>
                    <?php if(count($images) === 1){ ?>


                    <div class="big_box" style="max-width: 600px">
                    <img class="mini_pic big_pic" src="<?php echo $images[$i]->image;?>" alt="">
                    </div>
                  <?php }else{ ?>
                    <div class="big_box" style="max-width: 530px">
                    <img class="mini_pic big_pic" src="<?php echo $images[$i]->image;?>" alt="">
                    </div>

                <?php  }} ?>
                </div>

                <div class="small_pics flex-row ml-2">

                  <?php for($i = 1; $i < count($images); $i++){ ?>
                    <div class="box">
                      <img class="mini_pic small_pic mt-2" src="<?php echo $images[$i]->image;?>" alt="">
                    </div>
                    <?php } ?>

                  </div>
                </div>
                  <?php } ?>
              <div class="w-full text-neutral-500 text-right pr-2">
                <?php echo $post->created_at;?>
              </div>
            </div>

<?php
      }
    }
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
