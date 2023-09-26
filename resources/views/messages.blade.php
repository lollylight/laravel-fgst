@extends('layouts.main')
@vite('/resources/js/messages.js')

@section('page-title')
  Сообщения
@endsection

@section('picture_modal')
  @include('inc.bigpic')
@endsection

@section('fl_modal')
  @include('inc.friends_modal')
@endsection

@section('page-container')
<input type="hidden" id="uid" value="{{$user->id}}">
<div id="container" class="pt-5 text-white h-[570px]">
  <div class="flex flex-row px-8">

    <div class="bg-neutral-900/90 w-[300px] h-[550px]">
      <div class="border-b-2 border-red-900/50 w-full h-10 text-xl font-bold flex flex-row">
        <div class="w-1/2 pt-1.5 text-center">
          Контакты
        </div>
        <div class="w-1/2 pl-24">
          <svg class="plus_icon cursor-pointer" width="40px" height="40px" viewBox="-6 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <rect width="24" height="24" fill="none"/>
            <path class="add-contact" d="M12 6V18" stroke="#ffffff" stroke-linejoin="round" stroke-width="2"/>
            <path class="add-contact" d="M6 12H18" stroke="#ffffff" stroke-linejoin="round" stroke-width="2"/>
          </svg>
        </div>
      </div>

      <div id="contacts_list" class="h-[482px] w-full p-2 overflow-y-auto">

        <div id="card_" class="card flex flex-row h-15 w-full rounded-md border-r-[1px] border-b-[1px] border-teal-600/50 bg-neutral-800/25 hover:bg-neutral-600/25">
          <div class="fc_pic_box p-1.5">
            <a href="/profile/"><img src=""class="card-userpic rounded-md"></a>
          </div>
          <div class="card-username text-xl font-bold pt-[14px] pl-2">
            username
          </div>
        </div>

      </div>
    </div>

    <div id="msg_window" class="bg-neutral-900/90 w-[700px] h-[550px] ml-5" style="display:none;">

      <div id="msg_list_header" class="w-full h-10 text-xl text-center font-bold pt-1.5 border-b-2 border-red-900/50">
        UserName
      </div>
      <!-- <input type="hidden" id="contactUp" value="">
      <input type="hidden" id="contactId" value=""> -->

      <div id="msg_list" class="msg-list h-[454px] w-full p-2 overflow-y-auto">

        <div class="w-full msg_box w-full rounded-md flex flex-row justify-end mb-2">
          <div class="flex flex-col bg-teal-900/50 rounded-md mt-[8px]">
            <div class="msg-text py-1 px-2 text-[16px] text-right">
              message
            </div>
            <div class="text-neutral-500 px-1 pb-1">
              date
            </div>
          </div>
          <div class="rc_pic_box p-1.5 shrink-0">
            <a href="/profile/8"><img src="/userpics/userpic_8.jpg" alt="" class="rc_pic rounded-md"></a>
          </div>
        </div>

        <div class="msg_box w-full rounded-md flex flex-row mb-2">
          <div class="rc_pic_box p-1.5 shrink-0">
            <a href="/profile/1"><img src="/userpics/userpic_1.jpg" alt="" class="rc_pic rounded-md"></a>
          </div>
          <div class="bg-red-900/50 rounded-md mt-[8px]">
            <div class="msg-text py-1 px-2 text-[16px]">
              message
            </div>
            <div class="text-neutral-500 px-1 pb-1 text-right">
              date
            </div>
          </div>
        </div>


      </div>

      <div class="h-12 p-1.5 flex flex-row mt-1 border-t-2 border-red-900/50">
        <input type="file" multiple name="files[]" id="add_pic" value="" hidden>
        <div id="preview_modal" class="bg-neutral-900/25 h-[80px] mt-[-90px] absolute flex flex-row py-1 pr-1" style="display:none;">
          <img class="preview_post ml-1" src="" height="80" width="80" style="display:none;">
        </div>
        <label id="add_pic_icon" for="add_pic" class="ml-1 cursor-pointer" name="button">
          <svg width="30px" height="30px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <rect width="24" height="24" fill="none"/>
            <path d="M21 16V20C21 20.5523 20.5523 21 20 21H4C3.44772 21 3 20.5523 3 20V18M21 16V4C21 3.44772 20.5523 3 20 3H4C3.44772 3 3 3.44772 3 4V18M21 16L15.4829 12.3219C15.1843 12.1228 14.8019 12.099 14.4809 12.2595L3 18" stroke="#ffffff" stroke-linejoin="round"/>
            <circle cx="8" cy="9" r="2" stroke="#ffffff" stroke-linejoin="round"/>
          </svg>
        </label>
        <span class="pic_counter text-teal-600 text-[12px]">0</span>

        <form class="w-5/6 mr-2" action="" method="post">
          @csrf
          <textarea id="msg_field" class="ml-2 h-9 w-full rounded-md bg-neutral-900 p-1 resize-none border-2 border-red-900/50" placeholder="Ваше сообщение"></textarea>
        </form>


        <button id="send_msg" class="" name="button">
          <svg width="40px" height="30px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <g clip-path="url(#clip0_15_829)">
              <rect width="34" height="24" fill="none"/>
              <path class="send-icon" d="M19.364 5.05026L3.10051 8.58579L10.8787 13.5355M19.364 5.05026L15.8284 21.3137L10.8787 13.5355M19.364 5.05026L10.8787 13.5355" stroke="#ffffff" stroke-linecap="round" stroke-linejoin="round"/>
            </g>
            <defs>
              <clipPath id="clip0_15_829">
                <rect class="send-icon" width="24" height="24" fill="white"/>
              </clipPath>
            </defs>
          </svg>
        </button>

      </div>
    </div>


  </div>
</div>

@endsection

<style>
.rc_pic_box{
  height: 50px;
  width: 50px;
  overflow: hidden;
}
.rc_pic_box img{
  top: 50%;
  left: 50%;
  object-fit: cover;
  height: 50px
}
.msg_box{
  display: inline-block;
}
.msg-text{
  max-width: 500px;
}
.plus_icon:hover .add-contact{
  stroke: rgba(220,38,38,0.5);
}
.msg_pic{
  max-width: 350px;
}

#send_msg:hover .send-icon{
  stroke: rgba(220,38,38,0.5);
}
</style>
