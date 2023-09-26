<div id="left_side_menu" class="w-1/4 h-42 p-3 mt-5 mb-5">
  @if($user->id === Auth::user()->id)
  <x-button id="new_post" class="w-[187px] h-9 ml-1"><span class="w-full text-center">Новая запись</span></x-button><br>
  <x-button id="edit_info_btn" class="w-[187px] h-9 mt-2 ml-1"><span class="w-full text-center">Редактировать</span></x-button><br>
  <a href="/messages#contacts"><x-button id="chat_page" class="w-[187px] h-9 mt-2 ml-1"><span class="w-full text-center">Сообщения</span></x-button></a><br>
  @else
  <a href="/messages#{{$user->id}}"><x-button id="new_message" class="w-[187px] h-9 ml-1"><span class="w-full text-center">Написать</span></x-button></a><br>
  <x-button id="add_friend_{{$user->id}}" class="add_friend w-[187px] h-9 mt-2 ml-1"><span class="af_label w-full text-center">Добавить друга</span></x-button><br>
  <x-button id="report" class="w-[187px] h-9 mt-2 ml-1"><span class="w-full text-center">Пожаловаться</span></x-button><br>
  @endif
</div>
