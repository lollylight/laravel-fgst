<div class="user_info pt-5 ml-5">
  <span class="font-bold text-2xl uppercase tracking-wider">{{$user -> name}}</span>
  <ul id="info_list" style="list-style-type:none" class="ml-3 mt-2 text-lg">
    <li>Имя:   <i class="p_name">{{$profile -> name}}</i></li>
    <li>Возраст:  <i class="p_age">{{$profile -> age}}</i></li>
    <li>Пол:  <i class="p_sex">@if($profile->sex === 1) Мужской @elseif($profile->sex === 0) Женский @endif</i></li>
    <li>Страна:  <i class="p_country">{{$profile -> country}}</i></li>
    <!-- <li>Email: </li> -->
  </ul>
</div>
