<div id="eim_bg" class="w-screen h-screen bg-neutral-900/50 fixed z-[999] backdrop-blur-sm" style="display:none">
  <div id="eim_modal" class="w-1/3 ml-[35%] h-[490px] flex flex-col bg-neutral-950/75 mt-16 rounded-md text-white">
    <div id="eim_header" class="flex flex-row w-full h-[40px] p-1">
      <p class="text-xl font-bold w-full text-center">Редактирование</p>
    </div>
    <div id="eim_body" class="flex flex-col w-full h-[390px] border-t-[1px] border-red-900/75">
      <span class="w-full text-center font-semibold tracking-wide">Загрузка аватарки</span>
      <div class="h-[150px] w-full flex flex-row">
        <div class="w-[63%]">
          <form class="mt-8 ml-8" action="" method="post" id="userpic_form" enctype="multipart/form-data">
            @csrf
            <input type="hidden" class="uid" name="uid" value="{{$user->id}}">
            <input id="add_pic" type="file" name="image" class="w-full">
          </form>
          <x-button class="ml-8" id="eim_upload">Загрузить</x-button>
        </div>
        <div class="w-[37%]">
          <div class="overflow-hidden h-24 w-24 mt-8 ml-8">
            <img src="" class="preview object-cover object-bottom" style="display:none">
          </div>
        </div>
      </div>
      <div class="eim_error w-full text-center h-8 border-b-[1px] border-red-900/75">

      </div>
      <span class="w-full text-center font-semibold tracking-wide">Информация о себе</span>
      <div class="flex flex-row">
        <div class="w-[27%] pt-2">
          <ul class="ml-10 text-lg mt-[0.5] leading-9">
            <li>Имя:</li>
            <li>Возраст:</li>
            <li>Страна:</li>
            <li>Пол:</li>
          </ul>
        </div>
        <div class="w-[73%] pt-2">
          <form class="" action="" method="post" id="userinfo_form">
            @csrf
            <input type="hidden" name="uid" value="{{$user->id}}">
            <input name="name" placeholder="{{$profile->name}}" value="{{$profile->name}}" class="name_field pl-1 h-8 bg-neutral-900/75 border-b-[1px] border-red-900 mt-1 w-56">

            <input name="age" value="" placeholder="{{$profile->age}}" value="{{$profile->age}}" class="age_field pl-1 h-8 bg-neutral-900/75 border-b-[1px] border-red-900 mt-1 w-56">

            <input name="country" value="" placeholder="{{$profile->country}}" value="{{$profile->country}}" class="country_field pl-1 h-8 bg-neutral-900/75 border-b-[1px] border-red-900 mt-1 w-56">

            <select name="sex" class="h-8 mt-1 bg-neutral-900/75 border-none w-56">
              @if($profile->sex == 1)
                <option value="1" selected="selected">Мужской</option>
                <option value="0">Женский</option>
              @else
                <option value="1">Мужской</option>
                <option value="0" selected="selected">Женский</option>
              @endif
            </select>
          </form>
        </div>
      </div>
    </div>
    <div id="eim_footer" class="flex flex-row w-full h-[60px] pt-3 pl-4 border-t-[1px] border-red-900/75">
      <x-button id="eim_save" class="h-[35px]">Сохранить</x-button>
      <x-button id="eim_cancel" class="ml-2 h-[35px]">Отменить</x-button>
    </div>
  </div>
</div>
<style media="screen">
  #add_pic::-webkit-file-upload-button, #add_pic::file-selector-button{
    display: inline-block;
    width: 115px;
    border-radius: 6px;
    font-size: 14px;
    letter-spacing: 0.05em;
    height: 35px;
    border: none;
    background-color: #991b1b;
    color: white;
  }
</style>
