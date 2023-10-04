@extends('layouts.main')
@vite('resources/js/newsline.js')
@vite('resources/js/userpost.js')

@section('picture_modal')
  @include('inc.bigpic')
@endsection

@section('up_modal')
  @include('inc.userpost_modal')
@endsection

@section('page-title')
  Лента
@endsection

@section('page-container')
<div id="container" class="w-full flex">
  <div class="w-full mx-auto flex flex-row">

    <div class="w-[268px] h-[440px] bg-neutral-900/90 ml-7 mt-5">
      <div class="settings-header w-full text-center text-white p-1.5 text-xl font-semibold border-b-[1px] border-red-900/50">
        Фильтры
      </div>

      <div class="border-b-[1px] border-red-900/50 w-full text-white font-semibold p-1.5">
        <label for="news-radio" class="radio-a" id="news-btn">
          <input type="radio" class="radio-b" value="news">
          <span>Новости</span>
        </label>
        <br>
        <label for="up-radio" class="radio-a" id="userposts-btn">
          <input type="radio" class="radio-b" value="userposts" checked>
          <span>Записи друзей</span>
        </label>
        <br>
        <label for="forum-radio" class="radio-a" id="threads-btn">
          <input type="radio" class="radio-b" value="threads">
          <span>Избранное</span>
        </label>
      </div>

      <div class="settings-header w-full text-center text-white p-1.5 text-lg font-semibold border-b-[1px] border-red-900/50">
        Отображение
      </div>

      <div class="border-b-[1px] border-red-900/50 w-full text-white font-semibold p-1.5">
        <button class="checkbox-a" id="compmode-btn">
          <input id="compact" type="checkbox" class="checkbox-b" value="inactive">
          <span>Компактный вид тредов</span>
        </button>
      </div>

    </div>

    <div class="w-[700px] bg-neutral-900/90 ml-5 mt-5">
      <div class="newsline-header w-full text-white font-bold text-xl text-center p-1.5 border-b-[1px] border-red-900/50">
        Лента
      </div>
      <div class="newsline-posts px-1 text-white pb-1.5">

      </div>
    </div>

  </div>
</div>
@endsection
<style media="screen">
  .header{
    z-index: 1;
  }
  .small_pic{
    max-width: 100px;
    /* max-height: 100px; */
    object-fit:cover;
  }
  .comm_btn:hover .comm-icon{
    stroke: rgba(220,38,38,0.5);
  }
  .comm_btn:active .comm-icon{
    stroke: rgba(127,29,29,0.5);
  }
  .box{
    max-width: 100px;
    max-height: 100px;
    overflow: hidden;
  }
    .box img{
      object-fit:cover;
      object-position:center;
    }
    .thread-box{
      max-width: 128px;
      max-height: 128px;
      overflow: hidden;
    }
  .big_box{
    /* max-width: 600px; */
    max-height: 400px;
    overflow: hidden;
    }
    .big_box img{
      margin-left: auto;
      margin-right: auto;
    }
  .bb_col{
    min-width: 500px;
  }
  .big_pic{
    object-fit:cover;
    object-position:center;
    max-width: 650px;
    /* max-height: 400px; */
  }
  .radio-a{
    cursor: pointer;
  }
  .radio-a:hover{
    color: rgba(13,148,136,0.7);
  }
  .radio-a:active{
    color: rgba(13,108,96,0.7);
  }
  @media (max-width: 900px) {
    .big_box{
      max-width: 430px;
      max-height: 400px;
    }
  }

</style>
