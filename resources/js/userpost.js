$.ajaxSetup({
  headers: {
      'X-CSRF-TOKEN': $('#csrf_token').attr('content')
  }
});


clearComm();
//User Post modal logic
$(document).on('click','.userpost',function(e){
  if(!$('.mini_pic').is(e.target) && !$('.comm_btn').is(e.target) && !$('.prof-link').is(e.target)){
    var upid = $(this).attr('id');
    $('#up_background').show()
    getCurrentPost(upid);
    setTimeout(updateComments,300);
  }
})
$(document).on('click','.comm_btn',function(e){
  if(!$('.mini_pic').is(e.target)){
    var upid = $(this).attr('id').split('-')[2];
    $('#up_background').show()
    getCurrentPost(upid);
    setTimeout(updateComments,300);
    setTimeout(function(){
      $('#up_background').animate({
        scrollTop: $("#comm_modal").offset().top
    }, 400);
  },300);
  }
})

$(document).on('click','.reply_btn',function(e){
  var commInfo = $(this).siblings('.comment-info').html();
  var username = commInfo.split('\">')[1].split('</a>')[0];
  var uid = commInfo.split('#')[1].split('&')[0];
  var comment_id = $(this).parent().parent().attr('id').split('_')[1];
  $('#reply_to_field').val(comment_id).change();
  // console.log(username);
  // console.log(uid);
  $('#reply-to-info').html('Ответ пользователю '+username+'#'+uid);
  $('#reply-to-info').show();
  $('.comm_area').val('@' + username + '#' + uid + ',' + ' ').change();
})

$('#reply-to-info').mouseup(function(){
  $('#reply_to_field').val('').change();
  $('#reply-to-info').hide();
})

$(document).on('click','.reply',function(e){
  var comm_id = $(this).attr('href');
  var comm = $(comm_id);

  $(comm_id)[0].scrollIntoView({
    behavior: 'smooth'
  });

  setTimeout(function(){
    comm.css('background-color','rgba(14,88,76,0.1)')
  },200);
  setTimeout(function(){
    comm.css('background-color','rgba(14,88,76,0.3)')
  },250);
  setTimeout(function(){
    comm.css('background-color','rgba(14,88,76,0.5)')
  },300);
  setTimeout(function(){
    comm.last().css('background-color','rgba(15,64,59,0.4)')
  },1850);
  setTimeout(function(){
    comm.last().css('background-color','rgba(16,44,49,0.3)')
  },1900);
  setTimeout(function(){
    comm.css('background-color','rgba(17,34,39,0.2)')
  },1950);
  setTimeout(function(){
    comm.css('background-color','rgba(17,24,39,0)')
  },2000);
})

$('#up_background').mouseup(function(e){
  if(!$('#up_modal').is(e.target) && $('#up_modal').has(e.target).length == 0 && !$('#comm_modal').is(e.target) && $('#comm_modal').has(e.target).length == 0){
    $('#up_background').hide();
    $('#userpost_m').html('');
    clearComm();
  }
})

function getCurrentPost(post_id){
  $.ajax({
    url: '/get-current-post',
    method: 'POST',
    data: {pid: post_id},
    success: function(response){
      var post = $.parseJSON(response);
      // console.log(post.post);
      $('#userpost_m').html('');

      var media = '';
      if(post.images.length != 0){
        media = '<div class="flex p-3 border-t-[1px] border-teal-800/25 mt-1 w-full">\
              <div class="flex flex-col w-full">';

        for(let i = 0; i < post.images.length; i++){
          var image = post.images[i];
          media += '<div class="flex _box mb-1">\
                  <img class="mini_pic mod_pic" src="'+image.image+'" alt="">\
                  </div>';
        }
        media += '</div></div>'
      }
        // console.log(post.post.content);
        var content = post.post.content.replaceAll('\n','<p>');
        var regexp = 'https\\:\\/\\/www\\.youtube\\.com\\/\\S+';
        var yt_link = content.match(regexp);
        var video;
        if (yt_link != null){
          video = '<div class="flex flex-row p-3 border-t-[1px] border-teal-800/25 mt-1">\
          <div class="border-teal-800/25 bb_col mx-auto">';
          for (let i = 0; i < yt_link.length && i < 4; i++){
            var yt_block_id = yt_link[i].split('watch?v=')[1].split('&')[0];
            video += '<div id="'+ yt_block_id +'" class="big_box" style="max-width: 600px">\
            </div>';
          }
          video += '</div></div>';
        }
        var edit_btn = '';

        if ($('#authId').attr('content') == post.post.user_id){
          edit_btn = '\
          <div class="edit_post_btn h-8 w-8">\
            <svg class="menu_btn fill-current h-8 w-8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">\
                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />\
            </svg>\
            <div class="post_menu absolute" style="display:none">\
              <button class="del_btn bg-teal-500/75" id="'+ post.post.id +'">Удалить</button>\
            </div>\
          </div>';

        }

        $('#userpost_m').append('\
\
      <div id="'+ post.post.id +'" class="upm border-b-[1px] border-teal-600/75 w-full flex flex-col p-1">\
        <div class="flex flex-row">\
          <div class="w-full text-neutral-500">\
            <span>Пост №'+ post.post.id +'</span>\
            <span>от '+ post.username +'</span>\
          </div>\
        '+ edit_btn +'\
        </div>\
\
      <div class="w-full my-3">\
        <h2 class="text-[26px] font-bold ml-2">'+ post.post.subject +'</h2>\
      </div>\
      <div class="w-full my-4 ml-3 px-2 text-lg">\
        '+ content +'\
      </div>\
      '+ media + video +'\
      <div class="text-neutral-500 w-full text-right">\
        '+ new Date(post.post.created_at).toLocaleString() +'\
      </div>\
    </div>\
        ')
        if (yt_link != null){
          for (let i = 0; i < yt_link.length && i < 4; i++){
            var videoId = yt_link[i].split('watch?v=')[1].split('&')[0];
            var player;
            window.YT.ready(function(){
                player = new window.YT.Player(String(videoId), {
                  height: '360',
                  width: '640',
                  videoId: videoId,
                });
            })
          }
        }
    }
  })
}

//Комментарии

$(document).ready(function(){
  $('.comm_submit').mouseup(function(){
    sendComment();
    clearComm();
    updateComments();
  })
})
$(document).ready(function() {
    $('.comm_area').keyup(function(e){
        if (e.ctrlKey && e.keyCode == 13){
          e.preventDefault();
          sendComment();
          clearComm();
          updateComments();
        }
    });
});

function clearComm(){
  $('.comm_area').val('').change();
  $('#reply_to_field').val('').change();
  $('#reply-to-info').hide();
}

function sendComment(){
  var form_data = new FormData();
  // console.log(form_data);
  form_data.append('_token', $('input[name="_token"]').attr('value'));

  // var match = $('.comm_area').val().match('\@[a-zA-Z0-9\#0-9]+')[0];
  // var content = $('.comm_area').val().replace(match,'<a class="text-teal-600" href="/profile/'+match.split('#')[1]+'">'+match.split('@')[1].split('#')[0]+'</a>');

  form_data.append('content', $('.comm_area').val());
  form_data.append('reply_to', $('#reply_to_field').val());
  form_data.append('pid', $('.upm').attr('id'));
  $.ajax({
    url: '/send-comment',
    method: 'POST',
    data: form_data,
    processData: false,
    contentType: false,
    success: function(response){

    }
  })
}



function updateComments(){
  $.ajax({
    url: '/update-comments',
    method: 'POST',
    data: {pid: $('.upm').attr('id')},
    success: function(response){
      var result = $.parseJSON(response);
      // console.log(result);
      $('#comments').html('');
      for (var i = 0; i < result.length; i++){
        var comment = result[i];
        var match = comment.content.match('\@[a-zA-Z0-9\#0-9]+');
        // console.log(match);
        // try{
        // }
        // catch (e){}
        if (match != null){
          match = match[0];
          var content = comment.content.replace(match,'<span class="float-left h-[28px] reply bg-teal-900 px-1 rounded" href="#comment_'+ comment.reply_to +'">'+match.split('@')[1].split('#')[0]+'</span>');
        } else{
          var content = comment.content;
        }
        content = content.replaceAll('/n','<br>')

        if (comment.reply_to != null){
          var reply_to = '<span class="flex ml-auto">В ответ на&nbsp<span class="cursor-pointer reply text-teal-600" href="#comment_'+ comment.reply_to +'">#'+comment.reply_to+'</span></span>';
        } else{
          var reply_to = '';
        }

        $('#comments').append('\
        \
        <div id="comment_'+ comment.id +'" class="flex-col w-full text-white px-3 pt-2 pb-3 rounded-md border-b-[1px] border-red-900/25">\
            <div class="w-full text-neutral-500 mb-2 flex flex-row">\
              <span class="flex comment-info"><a href="/profile/'+ comment.user_id +'">'+ comment.username +'</a>#'+ comment.user_id +'&nbsp</span>\
              <span class="flex">'+ new Date(comment.created_at).toLocaleString() +'</span>\
              <button class="flex reply_btn underline ml-2 hover:text-red">Ответ</button>\
              '+ reply_to +'\
            </div>\
            <div class="flex w-full">\
              '+ content +'\
            </div>\
          </div>\
          \
        ')
      }
      if (result.length === 0){
        $('#comments').append('\
        <span class="flex my-auto self-center text-lg font-semibold">Пока нет комментариев</span>\
        ')
      }
    }
  })
}
