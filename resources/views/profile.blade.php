
@extends('layouts.main')
@vite('resources/js/profile.js')
@vite('resources/js/userpost.js')

@section('edit_info')
  @include('inc.edit_info')
@endsection

@section('picture_modal')
  @include('inc.bigpic')
@endsection

@section('up_modal')
  @include('inc.userpost_modal')
@endsection

@section('fl_modal')
  @include('inc.friends_modal')
@endsection

@section('page-title')
  Профиль|{{$user->name}}
@endsection

@section('page-container')

<div id="container" class="text-white mt-5 mx-auto flex">

  <div class="central_block flex flex-col">

    <div id="user_info_main" class="bg-neutral-900/90 h-52 w-full flex">

      <div class="p-3">
        <div class="up-box overflow-hidden rounded" style="height: 187px; width:187px">
          <img id="prof_pic" src="{{$profile->userpic_path}}" alt="img/notfound.jpeg" class="object-cover object-center" style="height: 187px; width:187px">
          @csrf
        </div>
      </div>

      @include('inc.userinfo')

      <div class="mob_btns ml-60" style="display:none;">
        <x-button class="flm_button h-14 m-4 text-[24px]">Друзья</x-button>
      </div>



    </div>

    <div class="flex flex-row items-start bg-neutral-900/90 mt-5">

        @include('inc.leftmenu_user')

      <div id="post_field" class="flex flex-col w-3/4 mt-5 ml-5 rounded-md">

        <div id="user_post_form" style="display: none" class="w-full px-8 border-b-[1px] border-l-[1px] border-red-900/25">
          <form action="" method="POST" id="new_post_form" enctype="multipart/form-data">
            @csrf
            <input type="hidden" class="uid" name="uid" value="{{$user->id}}">
            <input
            class="subject w-full h-10 pl-2 text-white bg-neutral-900/75 border-[1px] border-red-900/75 rounded-md"
            type="text" name="subject" placeholder="Тема | Не более 50-ти символов" required><br>

            <textarea
            class="txt_area w-full h-52 p-2 text-white bg-neutral-900/75 border-[1px] border-red-900/75 resize-none rounded-md mt-1"
            name="content" placeholder="Что нового?"></textarea>
          </form>
          <div class="flex flex-row mb-4">
            <x-button id="post_submit" class="h-10">Опубликовать</x-button>
            <input id="post_pic" type="file" class="ml-3 h-10" name="image[]" multiple  >
            <img class="preview_post ml-1" src="" height="50" width="50" style="display:none;">
          </div>
        </div><br>

        @include('inc.userposts')

      </div>
  </div>

  </div>

  <div class="right_block flex flex-col ml-5">

    <div id="right_side_menu_top" class="flex flex-col w-full bg-neutral-900/90 h-[380px]">
      <div id="right_side_menu_top_header" class="flex p-1.5 border-b-[1px] border-teal-600/25">
        <button class="flm_button w-full text-center text-[22px] font-bold">Друзья</button>
      </div>
      <div id="" class="friends_list flex flex-col p-2"></div>
    </div>

    <div id="right_side_menu_bottom" class="hidden flex flex-col w-full bg-neutral-900/90 h-72 mt-5">
      <div id="right_side_menu_bottom_header" class="flex pt-1">
        <p class="w-full text-center text-xl font-bold">Активность</p>
      </div>
      <div id="communities_list" class="flex flex-col"></div>
    </div>

  </div>

</div>
<!-- <script src="/js/profile_script.js" type="text/javascript"></script> -->
@endsection
<style>
#post_pic::-webkit-file-upload-button, #post_pic::file-selector-button{
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
#post_pic{
  width: 120px;
}
.preview_post{
  height: 50px;
}

#container{
  margin-left: 6%;
  margin-right: 6%;
}
@media (max-width: 900px) {
  .central_block{
    width: 100% !important;
  }
  .right_block{
    display: none !important;
  }
  #container{
    margin-left: 2%;
    margin-right: 2%;
  }
  .mob_btns{
    display: block !important;
  }
}
  .central_block{
    width: 75%;
  }
  .right_block{
    width: 280px;
  }

</style>
