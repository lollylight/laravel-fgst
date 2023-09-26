<div class="pic_background w-screen h-screen bg-neutral-900/50 fixed z-[999] backdrop-blur-sm" style="display: none">
   <img id="big_pic" src="">
 </div>
</div>

<style>
#big_pic{
  max-height: 550px;
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
}
.mini_pic{
  cursor: pointer;
}
</style>

<script type="text/javascript">
// show full picture
var all_pics = [];
var i = 0;
$(document).on('click','.mini_pic',function(){
  $('#big_pic').attr('src',$(this).attr('src'));
  var this_pic = $(this).attr('src');
  $(this).parent().parent().parent().find('.mini_pic').each(function(e){
    all_pics.push($(this).attr('src'));
  });
  i = all_pics.indexOf(this_pic);
  $('.pic_background').show();
});
$('#big_pic').click(function(){
  $('#big_pic').attr('src','');
  setTimeout(function(){
    $('#big_pic').attr('src', all_pics[i]);
  },100)
  if(i + 1 < all_pics.length){
    i++;
  }else{
    $('.pic_background').hide();
    all_pics = [];
    i = 0;
  }
})
$(document).keydown(function(e){
  if(e.keyCode === 39){  //right
    $('#big_pic').attr('src','');
    setTimeout(function(){
      $('#big_pic').attr('src', all_pics[i]);
    },100)
    if(i + 1 < all_pics.length){
      i++;
    }else{
      $('.pic_background').hide();
      all_pics = [];
      i = 0;
    }
  }
  if (e.keyCode === 37){  //left
    $('#big_pic').attr('src','');
    setTimeout(function(){
      $('#big_pic').attr('src', all_pics[i]);
    },100)
    if(i - 1 >= 0){
      i--;
    }else{
      $('.pic_background').hide();
      all_pics = [];
      i = 0;
    }
  }
})
$(document).on('mouseup','.pic_background',function(e){
  if(!$('#big_pic').is(e.target)){
    $('.pic_background').hide();
    all_pics = [];
    i = 0;
  }
});
</script>
