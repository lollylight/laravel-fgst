<div id="OP" class="flex-col w-full text-white px-3 pt-2 pb-3 border-b-2 border-teal-600/50 bg-gray-900/[.5]">

  <div class="w-full text-neutral-500 mb-2">
    <span><a href="/profile/{{$thread->user_id}}">{{$username}}</a>#OP</span>
    <span>{{$thread->created_at}}</span>
    <a id="OP" class="reply_btn underline ml-2 hover:text-red" href="#thread_form">Ответ</a>
  </div>

  <div class="w-full flex flex-row">
    @if($thread->image != 'nopic')
    <div class="flex w-[25%] items-start">
      <img class="op_pic max-w-[170px] mini_pic" src="{{$thread->image}}" alt="">
    </div>
      <div class="flex flex-col w-[75%]">
        <span class="w-full flex text-[22px] font-semibold mb-1">{{$thread->subject}}</span>
        <div class="flex w-full text-base">
          {!!nl2br($thread->content)!!}
        </div>
      </div>
  @else
      <div class="flex flex-col min-h-32">
        <span class="w-full flex text-[22px] font-semibold mb-1">{{$thread->subject}}</span>
        <div class="flex w-full text-base">
          {!!nl2br($thread->content)!!}

        </div>
      </div>
  @endif

  </div>
</div>
