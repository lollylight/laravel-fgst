@extends('layouts.main')
@vite('resources/js/forum.js')
@section('picture_modal')
  @include('inc.bigpic')
@endsection
@section('page-title')
  {{$cat->catname}}|{{$thread->subject}}
@endsection
@section('page-container')
<div id="container" class="flex flex-row w-full pl-7 items-start h-full">

  @include('inc.leftmenu_forum')

  <div id="thread_container" class="w-[59%] flex flex-col bg-neutral-900/[.85] ml-5 mt-5">

    <div id="tc_header" class="w-full text-center text-white font-bold text-[26px] p-2 tracking-wider">
      @if(mb_strlen($thread->subject) > 44)
        {{mb_substr($thread->subject,0,43) . '...'}}
      @else
        {{$thread->subject}}
      @endif
    </div>
    <div class="text-white w-full">
      <button id="new_thread" class="w-full text-lg uppercase tracking-wider font-semibold h-10 border-t-[1px] border-red-900/75 bg-teal-900/50 hover:bg-teal-600/50 active:bg-teal-900/75">Ответить в тред</button>
    </div>

    <div id="thread_form" style="display: none" class="w-full border-b-[1px] border-teal-600/50 px-12 pt-3 backdrop-blur-sm">
      <form action="" method="POST" id="new_thread_form" enctype="multipart/form-data">
        @csrf
        <input type="hidden" id="uid" value="{{$uid}}">
        <input id="thid" type="hidden" value="{{$thread->id}}">
        <input id="reply_to" type="hidden" value="">
        <span class="reply_field text-[rgba(250,40,100,1)] hover:text-[rgba(13,148,136,1)]"></span>
        <textarea
        class="txt_area w-full h-52 text-white bg-neutral-900/[.85] border-[1px] p-2 border-teal-600/75 resize-none mt-1"
        name="content" placeholder="Ваш ответ"></textarea>
      </form>
      <div class="flex flex-row mb-4">
        <x-button id="reply_submit" class="h-10">Опубликовать</x-button>
        <input id="reply_pic" type="file" class="ml-3 h-10" name="image[]" multiple>
        <img class="preview_reply ml-1" src="" height="50" width="50" style="display:none;">
      </div>
    </div><br>

    @include('inc.OPpost')

    <div class="replies_list w-full">

    </div>

  </div>
  <div id="scrollUp" class="bg-gray-900/25 text-[rgba(255,255,255,0.5)] hover:text-[rgba(255,255,255,1)] hover:bg-gray-900/75 h-10 fixed w-44 mt-[40.3%] ml-[78.85%] z-10">
    <button  class="w-full h-full  text-lg font-bold pt-1">Наверх</button>
  </div>
</div>

@endsection
<style media="screen">
  #reply_pic::-webkit-file-upload-button, #reply_pic::file-selector-button{
    display: inline-block;
    width: 115px;
    border-radius: 6px;
    font-size: 14px;
    letter-spacing: 0.05em;
    height: 40px;
    border: none;
    background-color: #991b1b;
    color: white;
  }
  #reply_pic{
    width: 120px;
  }
  ul a:hover{
    color:rgba(150,20,20,1);
  }
  .reply_to{
    color: rgba(250,40,100,1);
  }
  .reply_to:hover{
    color: rgba(13,148,136,1);
  }
  .reply_btn:hover{
    color: rgba(13,148,136,1);
  }
  .box{
    max-width: 170px;
    max-height: 170px;
    overflow: hidden;
  }
  .mini_pic{
    object-fit:cover;
  }
</style>
