<div id="up_background" class="w-full h-full flex-col fixed bg-neutral-900/50 backdrop-blur-sm overflow-y-scroll hidden text-white">
  <div id="up_modal" class="w-[50%] bg-neutral-950/75 rounded-md">

    <div id="userpost_m" class="w-full flex-col p-5 border-l-[1px] border-neutral-800/75">

      <div id="" class="upm border-b-[1px] border-teal-600/75 w-full flex flex-col p-1">
        <div class="flex flex-row">
          <div class="w-full text-neutral-500">
            <span>Пост №debug</span>
            <span>от admin</span>
          </div>
          <div class="edit_post_btn h-8 w-8">
            <svg class="menu_btn fill-current h-8 w-8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
            </svg>
            <div class="post_menu absolute" style="display:none">
              <button class="del_btn bg-teal-500/75">Удалить</button>
            </div>
          </div>
        </div>

        <div class="w-full my-3">
          <h2 class="text-[26px] font-bold ml-2"></h2>
        </div>
        <div class="w-full my-4 ml-3 px-2 text-lg">
        </div>

          <div class="flex p-3 border-t-[1px] border-teal-800/25 mt-1 w-full">
            <div class="flex flex-col w-full">
                <div class="flex _box mb-1">
                  <img class="mini_pic mod_pic" src="" alt="">
                </div>
            </div>
          </div>

    </div>

  </div>

  <div id="comm_modal" class="w-full flex flex-col rounded-md px-3 mb-4">
    <span class="w-full text-center text-xl font-bold border-b-[1px] border-teal-600/75 pb-3 ">Комментарии</span>

    <div id="comments" class="w-full flex-col flex">

      <div id="OP" class="flex-col w-full text-white px-3 pt-2 pb-3">
        <div class="w-full text-neutral-500 mb-2">
          <span><a href="/profile/1">Username</a>#OP</span>
          <span>19.01.2020 17:43:28</span>
          <a id="OP" class="reply_btn underline ml-2 hover:text-red" href="#thread_form">Ответ</a>
        </div>
        <div class="flex w-full text-base">
          some some some some some text
        </div>
      </div>

    </div>

    <div class="flex flex-col border-t-[1px] border-teal-600/75">
      <span id="reply-to-info" class="mt-1 hover:text-red-600 hover:underline hidden cursor-pointer"></span>
      <div class="mt-1 pt-3 flex flex-row">
        <form class="w-[80%] flex" action="" method="post">
          @csrf
          <textarea rows="1" class="comm_area p-1 w-full resize-none bg-neutral-900/75 border-[1px] rounded-md border-red-900/75" placeholder="Ваш комментарий"></textarea>
          <input id="reply_to_field" type="hidden" value="">
        </form>
        <div class="flex flex-row mb-3 items-start w-[20%] ml-2">
          <x-button class="comm_submit">Отправить</x-button>
        </div>
      </div>

    </div>

  </div>


    </div>
  </div>

<style>
#up_background{
  z-index: 99;
}
#up_modal{
  transform: translate(50%, 10px);
}
#comments{
  min-height: 100px;
  /* max-height: 500px; */
  overflow-y: none;
}
.mod_box{
  max-width: 700px;
  max-height: 400px;
  overflow: hidden;
  }
.mod_pic{
  /* object-fit:cover; */
  /* max-width: 600px; */
  /* max-height: 400px; */
}
.post_menu{
  margin-left: -40px;
  width: 87px;
}
.del_btn{
  border-radius: 6px;
  color: rgba(200,200,200, 0.5);
  background-color: rgba(13,148,136,0.1);
  padding-left: 6px;
  padding-right: 6px;
  height: 27px;
  text-align: center;
  letter-spacing: 0.05em;
}
.del_btn:hover{
  color: white;
  background-color: rgba(13,148,136,0.3);
}
.del_btn:active{
  color: black;
  background-color: rgba(13,148,136,1);
}

@media(max-width:900px){
  #up_modal, #comm_modal{
    width: 85%;
    transform: translate(10%, 60px);
  }
}
</style>
