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

    static function getNewsThreads(){
      $newsThreads = Thread::where('cat_id','3')->orderby('updated_at','desc')->get()->toArray();
      $newsThreads['type'] = 'news'; 
      return $newsThreads;
    }
    static function getFavThreads(){

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
      if($request->ajax()){
        $this->getThreads($request->cid);
      }
    }

    private function getThreads($cid){
      $threads = Thread::where('cat_id',$cid)->orderby('updated_at','desc')->get();
      foreach ($threads as $thread){
        $cat = $thread->category()->get()[0];
        $username = User::select('name')->where('id',$thread->user_id)->get()[0]['name'];
        ?>
        <div class="flex-col w-full text-white px-3 pt-2 pb-3 border-b-2 border-teal-600/50 bg-gray-900/[.5]">

          <div class="w-full text-neutral-500 mb-2">
            <span><a href="/profile/<?php echo $thread->user_id;?>"><?php echo $username;?></a>#<?php echo $thread->id;?></span>
            <span><?php echo $thread->created_at;?></span>
            <span class="ml-4"> Ответы: <?php echo $thread->replies;?></span>
          </div>

          <div class="w-full flex flex-row">
            <?php if ($thread->image != 'nopic'){?>
            <div class="flex w-[25%] items-start">
              <div class="box">
                <img class="op_pic max-w-[170px] mini_pic" src="<?php echo $thread->image;?>" alt="">
              </div>
            </div>
            <a class="w-full ml-2" href="<?php echo '/forum/' . $cat->catlink . '/' . $thread->id;?>">
              <div class="flex flex-col w-[75%]">
                <span class="w-full flex text-[22px] font-semibold mb-1"><?php echo $thread->subject;?></span>
                <div class="flex w-full text-base">
                  <?php echo $this->shortText($thread->content,312);?>
                </div>
              </div>
            </a>
          <?php }else{?>
            <a class="w-full" href="<?php echo '/forum/' . $cat->catlink . '/' . $thread->id;?>">
              <div class="flex flex-col h-32">
                <span class="w-full flex text-[22px] font-semibold mb-1"><?php echo $thread->subject;?></span>
                <div class="flex w-full text-base">
                  <?php echo $this->shortText($thread->content,312);?>
                </div>
              </div>
            </a>
        <?php  }?>

          </div>

        </div>
        <?php
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
