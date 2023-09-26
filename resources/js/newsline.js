$.ajaxSetup({
  headers: {
      'X-CSRF-TOKEN': $('#csrf_token').attr('content')
  }
});

getNews(location.hash.split('#')[1]);

paintCurrentPageButton()
function paintCurrentPageButton(){
  var cUrl = new URL(window.location);
  // console.log(cUrl);
  $('.current-btn').each(function(){
    // console.log(cUrl.pathname.startsWith($(this).attr('href')));
    if (cUrl.pathname.startsWith($(this).attr('href'))){
      $(this).css('color','rgba(13,168,136,1)');
      $(this).css('border-bottom','2px solid');
      $(this).css('border-color','rgba(209,213,219,1)');
    }
  })
}


//Update Newsline

$('.radio-a').click(function(){
  var type = $(this).attr('id');
  $('.radio-b').prop('checked', false);
  $(this).find('.radio-b').prop('checked',true);
  console.log(type);
  location.hash = '#' + type;
  getNews(type);
})

function getNews(type){
  $.ajax({
    url: '/get-news',
    method: 'POST',
    data: {type: type},
    success: function(response){
      var result = $.parseJSON(response);
      // console.log(result);
      $('.newsline-posts').html('');
      if (result.type === 'userposts'){

        for (let i = 0; i < result.content.length; i++){
          var post = result.content[i];
          var media = post.images;
          var pictures ='';

          if (media.length > 1){

            pictures = '\
            <div class="flex flex-row p-3 border-t-[1px] border-teal-800/25 mt-1">\
            <div class="border-r-[1px] border-teal-800/25 bb_col">\
            <div class="big_box" style="max-width: 530px">\
            <img class="mini_pic big_pic" src="'+media[0].image+'" alt="">\
            </div>\
            </div>';

            pictures += '<div class="small_pics flex-row ml-2">';

            for (let k = 1; k < media.length; k++){
              var images = media[k];
              pictures += '\
              <div class="box">\
              <img class="mini_pic small_pic mt-2" src="'+images.image+'" alt="">\
              </div>';
            }
            pictures += '</div></div>';

          }else if (media.length === 1){
            var img = media[0];
            pictures = '\
            <div class="flex flex-row p-3 border-t-[1px] border-teal-800/25 mt-1">\
            <div class="border-teal-800/25 bb_col mx-auto">\
            <div class="big_box" style="max-width: 600px">\
            <img class="mini_pic big_pic" src="'+img.image+'" alt="">\
            </div>\
            </div></div>';
          }

          var text = post.content.replaceAll('\n','<p>');
          text = text.replaceAll('<br><br>','<br>');
          if(post.content.length > 315){
            text = text.substring(0,312) + '...';
          }
          if (post.comments.length === 1){
            var comm = ' Комментарий';
          } else if (post.comments.length === 2 || post.comments.length === 3 || post.comments.length === 4){
            var comm = ' Комментария';
          } else if (post.comments.length === 0 || post.comments.length > 4){
            var comm = ' Комментариев';
          }
          // console.log(text);
          $('.newsline-posts').append('\
          <div id="'+ post.id +'" class="userpost border-b-[1px] border-teal-600/50 w-full flex flex-col p-1 bg-gray-900/25 rounded-md border-r-[1px] cursor-pointer">\
          <div class="w-full text-neutral-500 flex-row text-right pl-1 flex">\
          Запись#'+ post.id +'&nbspот&nbsp<a class="prof-link self-end active:text-red-900/50 hover:text-red-600/50" href="/profile/'+ post.user_id +'">'+ post.username +'</a>\
          &nbsp'+ new Date(post.created_at).toLocaleString() +'\
          </div>\
          <div class="w-full mt-3 ">\
          <h2 class="text-[26px] font-bold ml-2">'+ post.subject +'</h2>\
          </div>\
          <div class="w-full my-4 px-3 text-lg ">\
          '+text+'\
          </div>\
          '+ pictures +'\
          <div class="w-full text-neutral-500 flex-row text-right pr-2 flex mb-1">\
          <button id="comm-btn-'+post.id+'" class="comm_btn hover:text-red-600/50 active:text-red-900/50 w-60 flex-row flex p-1">\
          \
          <div class="mx-1 post_footer w-[24px]">\
          <svg width="24px" height="24px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">\
          <g clip-path="url(#clip0_15_90)">\
          <rect width="24" height="24" fill="none"/>\
          <path class="comm-icon" d="M20 12C20 16.4183 16.4183 20 12 20C10.5937 20 9.27223 19.6372 8.12398 19C7.53267 18.6719 4.48731 20.4615 3.99998 20C3.44096 19.4706 5.4583 16.6708 5.07024 16C4.38956 14.8233 3.99999 13.4571 3.99999 12C3.99999 7.58172 7.58171 4 12 4C16.4183 4 20 7.58172 20 12Z" stroke="#737373" stroke-linejoin="round"/>\
          </g>\
          <defs>\
          <clipPath id="clip0_15_90">\
          <rect width="24" height="24" fill="none"/>\
          </clipPath>\
          </defs>\
          </svg>\
          </div>\
          \
          <span class="text-[15px]">'+ post.comments.length + comm +'</span>\
          <div>\
          </button>\
          </div>\
          ');
        }

      }
    }
  })
}
