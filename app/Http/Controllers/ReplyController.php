<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Thread;
use App\Models\Reply;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class ReplyController extends Controller
{
    public function sendReply(Request $request){
      if($request->ajax()){
        var_dump($request->content);
        $reply = Reply::create([
          'thread_id' => $request->thid,
          'reply_to' => $request->reply_to,
          'content' => $request->content,
          'user_id' => Auth::user()->id
        ]);
        $reply->thread()->update([
          'replies' => DB::raw('replies + 1')
        ]);
        if($request->file('images') != null){
          foreach($request->images as $file){
            $path = 'reply_images';
            $filename = rand(1000000,9999999) . 'r' . '.' . $file -> getClientOriginalExtension();
            // Storage::putFileAs($path, $file, $filename);
            $file -> move($path,$filename);
            $fullPath = '/reply_images/' . $filename;

            $reply->image()->create([
              'image' => $fullPath
            ]);
          }
        }
      }
      return $this->getReplies($request->thid);
    }

    public function showContent(Request $request){
      if($request->ajax()){
        $this->getReplies($request->thid);
      }
    }

    private function getReplies($thid){
      $replies = Reply::where('thread_id',$thid)->orderby('created_at','asc')->get();
      foreach ($replies as $reply){
        $username = User::select('name')->where('id',$reply->user_id)->get()[0]['name'];
        $images = $reply->image()->get();

        if (!$images->isEmpty()){
          if (count($images) > 1){
            // Шаблон ответа при более чем 1-ой картинке
            ?>

            <div id="<?php echo $reply->id;?>" class="reply_<?php echo $reply->user_id;?> flex-col w-full text-white px-3 pt-2 pb-3 border-b-2 border-teal-600/50 bg-gray-900/[.5]">
              <div class="w-full text-neutral-500 mb-2">
                <span><a href="/profile/<?php echo $reply->user_id;?>"><?php echo $username;?></a>#<?php echo $reply->id;?></span>
                <span><?php echo $reply->created_at;?></span>
                <a id="<?php echo $reply->id;?>" class="reply_btn underline ml-2 hover:text-red" href="#thread_form">Ответ</a>
              </div>

              <div class="flex flex-col w-full">

                <div class="flex w-full items-start">
                  <?php foreach($images as $pic){
                    ?>
                    <div class="box ml-2">
                      <img class="mini_pic" src="<?php echo $pic->image;?>" alt="">
                    </div>
                    <?php
                  }
                  ?>
                </div>
                <?php if($reply->reply_to != 'none'){
                  ?>
                  <span class="mt-2"><a class="reply_to" href="#<?php echo $reply->reply_to;?>">>>#<?php echo $reply->reply_to;?></a></span>
                  <?php
                } else{
                  ?>
                  <span class="mt-3"></span>
                  <?php
                }?>
                <div class="flex w-full mt-1">
                  <?php echo nl2br($reply->content);?>
                </div>

              </div>
            </div>

            <?php
          }else{
            // Шаблон для ответа с 1-ой картинкой
            ?>

            <div id="<?php echo $reply->id;?>" class="reply_<?php echo $reply->user_id;?> flex-col w-full text-white px-3 pt-2 pb-3 border-b-2 border-teal-600/50 bg-gray-900/[.5]">
              <div class="w-full text-neutral-500 mb-2">
                <span><a href="/profile/<?php echo $reply->user_id;?>"><?php echo $username;?></a>#<?php echo $reply->id;?></span>
                <span><?php echo $reply->created_at;?></span>
                <a id="<?php echo $reply->id;?>" class="reply_btn underline ml-2 hover:text-red" href="#thread_form">Ответ</a>
              </div>

              <div class="flex flex-row w-full">

                <div class="flex w-[25%] items-start">
                  <?php foreach($images as $pic){
                    ?>
                    <div class="box ml-2">
                      <img class="mini_pic" src="<?php echo $pic->image;?>" alt="">
                    </div>
                    <?php
                  }
                  ?>
                </div>
                <div class="flex flex-col w-[75%]">
                  <?php if($reply->reply_to != 'none'){
                    ?>
                    <span class="mt-2"><a class="reply_to" href="#<?php echo $reply->reply_to;?>">>>#<?php echo $reply->reply_to;?></a></span>
                    <?php
                  }?>
                  <div class="flex w-full text-base">
                    <?php echo nl2br($reply->content);?>
                  </div>
                </div>

              </div>
            </div>

            <?php
          }
        }else{
          // Шаблон для ответа без картинок
          ?>

          <div id="<?php echo $reply->id;?>" class="reply_<?php echo $reply->user_id;?> ease-linear flex-col w-full text-white px-3 pt-2 pb-3 border-b-2 border-teal-600/50 bg-gray-900/[.5]">
            <div class="w-full text-neutral-500 mb-2">
              <span><a href="/profile/<?php echo $reply->user_id;?>"><?php echo $username;?></a>#<?php echo $reply->id;?></span>
              <span><?php echo $reply->created_at;?></span>
              <a id="<?php echo $reply->id;?>" class="reply_btn underline ml-2 hover:text-red" href="#thread_form">Ответ</a>
            </div>

            <div class="flex flex-col w-full">

              <?php if($reply->reply_to != 'none'){
                ?>
                <span class=""><a class="reply_to" href="#<?php echo $reply->reply_to;?>">>>#<?php echo $reply->reply_to;?></a></span>
                <?php
              }?>
              <div class="flex w-full mt-1">
                <?php echo nl2br($reply->content);?>
              </div>

            </div>
          </div>

          <?php
        }

      }
    }
}
