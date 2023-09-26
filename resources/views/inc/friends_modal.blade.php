<div id="fl_background" class="w-full h-full flex-col fixed bg-neutral-900/50 backdrop-blur-sm overflow-y-scroll text-white hidden">
  <div id="fl_modal" class="w-[400px] h-[600px] bg-neutral-950/75 rounded-md">

    <div class="flm_header w-full flex flex-row text-center border-b-[1px] border-teal-600/25 p-2 font-semibold">
      @if($user->id === Auth::user()->id)
      <button class="friends_tab mr-2">Друзья</button>
      <span class="text-xl">|</span>
      <button class="requests_tab ml-2">Заявки</button>
      @else
      <button class="friends_tab ml-10">Друзья</button>
      @endif
    </div>

    <div id="friends_list_modal" class="w-full h-[520px]">
      <div id="f_list" class="w-full h-full overflow-y-auto p-2">


      </div>
    </div>
    @if($user->id === Auth::user()->id)
    <div id="requests_list_modal" class="w-full h-[520px]" style="display: none">
      <div id="r_list" class="w-full h-full overflow-y-auto p-2">

        <div class="request_card flex flex-row h-15 w-full rounded-md border-r-[1px] border-b-[1px] border-red-600/50 bg-neutral-800/25 hover:bg-neutral-600/25">
          <a href="/profile/">
          <div class="rc_pic_box p-1.5">
            <img src="" class="rc_pic rounded-md">
          </div>
        </a>
          <div class="text-xl font-bold pt-[14px] pl-2 w-[60%]">

          </div>
          <div class="pt-[14px]">
            <button class="req_accept">
              <svg width="35px" height="35px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <rect width="24" height="24" fill="none"/>
                <path d="M5 13.3636L8.03559 16.3204C8.42388 16.6986 9.04279 16.6986 9.43108 16.3204L19 7" stroke="#ffffff" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
            </button>

            <button class="req_cancel">
              <svg width="35px" height="35px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <rect width="24" height="24" fill="none"/>
                <path d="M7 17L16.8995 7.10051" stroke="#ffffff" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M7 7.00001L16.8995 16.8995" stroke="#ffffff" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
            </button>
          </div>
        </div>

      </div>
    </div>
    @endif
  </div>
</div>


<style>
#fl_modal{
  transform: translate(120%, 20px);
}
.flm_header{
  padding-left:30%;
}
.friends_tab, .requests_tab{
  font-size: 18px;
}
.rc_pic_box{
  height: 60px;
  width: 60px;
  overflow: hidden;
}
.rc_pic_box img{
  top: 50%;
  left: 50%;
  object-fit: cover;
  height: 50px
}
.fc_pic_box{
  height: 60px;
  width: 60px;
  overflow: hidden;
}
.fc_pic_box img{
  top: 50%;
  left: 50%;
  object-fit: cover;
  height: 50px
}
@media (max-width:900px){
  #fl_modal{
    width: 80%;
    transform: translate(10%, 40px);
  }
}
</style>
