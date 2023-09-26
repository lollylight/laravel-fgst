<div id="user_posts" class="w-full flex-col pr-5 border-l-[1px] border-red-900/25">

  <div id="" class="userpost border-b-[1px] border-teal-600/50 w-full flex flex-col p-1 bg-gray-900/25 rounded-md border-r-[1px]">
    <div class="w-full mt-3 ">
      <h2 class="text-[26px] font-bold ml-2">DEBUG POST</h2>
    </div>
    <div class="w-full my-4 px-3 text-lg">
      DEBUG POST
    </div>
      <div class="flex flex-row p-3 border-t-[1px] border-teal-800/25 mt-1">
        <div class="border-r-[1px] border-teal-800/25 bb_col">
          <div class="big_box" style="max-width: 600px">
            <img class="mini_pic big_pic" src="" alt="">
          </div>

          <div class="big_box" style="max-width: 530px">
            <img class="mini_pic big_pic" src="" alt="">
          </div>
        </div>
        <div class="small_pics flex-row ml-2">
          <div class="box">
            <img class="mini_pic small_pic mt-2" src="" alt="">
          </div>
        </div>
      </div>
      <div class="w-full text-neutral-500 text-right pr-2">
      </div>
    </div>

</div>
<style media="screen">
  .small_pic{
    max-width: 100px;
    /* max-height: 100px; */
    object-fit:cover;
  }
  .box{
    max-width: 100px;
    max-height: 100px;
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
  @media (max-width: 900px) {
    .big_box{
      max-width: 430px;
      max-height: 400px;
    }
  }
  /* .userpost{
    border-color: rgba(13,148,136,0.75);
  } */
</style>
