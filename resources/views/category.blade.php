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

    <div id="tc_header" class="w-full text-center text-white font-bold text-[26px] p-2 tracking-wider">
      {{$cat->catname}}
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
  <div id="scrollUp" class="bg-gray-900/25 text-[rgba(255,255,255,0.5)] hover:text-[rgba(255,255,255,1)] hover:bg-gray-900/75 h-10 fixed w-44 mt-[40.3%] ml-[78.85%] z-10">
    <button  class="w-full h-full  text-lg font-bold pt-1">Наверх</button>
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
</style>
