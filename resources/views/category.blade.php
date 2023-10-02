@extends('layouts.main')
@vite('resources/js/forum.js')
@section('picture_modal')
  @include('inc.bigpic')
@endsection
@section('page-title')
Форум|{{$cat->catname}}
@endsection
@section('page-container')

<style>
ul a:hover{
  color:rgba(150,20,20,1);
}
</style>

<div id="container" class="flex flex-row w-full pl-7">

  @include('inc.leftmenu_forum')

  <div id="thread_container" class="w-[59%] flex flex-col bg-neutral-900/[.85] ml-5 mt-5">

    <div id="tc_header" class="flex flex-row w-full text-white font-bold text-[26px] p-2 tracking-wider">
      <span class="w-full text-center">{{$cat->catname}}</span>
    </div>
    <div class="text-white w-full">
      <button id="new_thread" class="w-full text-lg uppercase tracking-wider font-semibold h-10 border-t-[1px] border-red-900/75 bg-teal-900/50 hover:bg-teal-600/50 active:bg-teal-900/75">Создать тред</button>
    </div>

    <div id="thread_form" style="display: none" class="w-full border-b-[1px] border-teal-600/50 px-12 pt-3 backdrop-blur-sm">
      <form action="" method="POST" id="new_thread_form" enctype="multipart/form-data">
        @csrf
        <input id="cid" type="hidden" value="{{$cat->id}}">
        <input
        class="subject w-full h-10 text-white bg-neutral-900/[.85] border-[1px] pl-2 border-teal-600/75"
        type="text" name="subject" placeholder="Тема | Не более 50-ти символов" required><br>

        <textarea
        class="txt_area w-full h-52 text-white bg-neutral-900/[.85] border-[1px] p-2 border-teal-600/75 resize-none mt-1"
        name="content" placeholder="Что нового?"></textarea>
      </form>
      <div class="flex flex-row mb-4">
        <x-button id="thread_submit" class="h-10">Опубликовать</x-button>
        <input id="add_pic" type="file" class="ml-3 h-10" name="image">
        <img class="preview ml-1" src="" height="50" width="50" style="display:none;">
      </div>
    </div><br>

    @include('inc.thread_list')

  </div>

  <button id="like-btn" class="like-btn p-[12px] absolute mt-5 ml-[74.85%]" value="" title="">
    <svg width="30px" height="30px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
      <rect width="24" height="24" fill="none"/>
      <path d="M21 8.99998C21 12.7539 15.7156 17.9757 12.5857 20.5327C12.2416 20.8137 11.7516 20.8225 11.399 20.5523C8.26723 18.1523 3 13.1225 3 8.99998C3 2.00001 12 2.00002 12 8C12 2.00001 21 1.99999 21 8.99998Z" stroke="#ffffff" stroke-linecap="round" stroke-linejoin="round"/>
    </svg>
  </button>

  <div class="bg-gray-900/25  hover:bg-gray-900/75 h-14 mt-[39.1%] fixed w-56  ml-[78.85%] z-10">


    <button id="scrollUp" class="w-full h-14 text-[rgba(255,255,255,0.5)] hover:text-[rgba(255,255,255,1)] text-lg font-bold">Наверх</button>
  </div>
</div>

@endsection
<style media="screen">
  #add_pic::-webkit-file-upload-button, #add_pic::file-selector-button{
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
  #add_pic{
    width: 120px;
  }
  .thread-box{
    max-width: 150px;
    max-height: 150px;
    overflow: hidden;
  }
  .mini_pic{
    object-fit:cover;
    object-position: center;
  }
  .like-btn{
    cursor: pointer;
  }
  .dislike-btn svg path{
    stroke: rgba(234,153,153,1);
  }
  .like-btn:hover svg path{
    stroke: rgba(0,0,0,1);
    fill: rgba(13,148,136,1);
  }
  .like-btn:active svg path{
    fill: rgba(19,78,74,1);
  }
  .dislike-btn:hover svg path{
    stroke: rgba(0,0,0,1);
    fill: rgba(234,153,153,1);
  }
  .dislike-btn:active svg path{
    fill: rgba(19,78,74,1);
  }
</style>
