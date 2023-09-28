$.ajaxSetup({
  headers: {
      'X-CSRF-TOKEN': $('input[name="_token"]').attr('value')
  }
});

var file = undefined;
var maxFileSize = 2 * 1024 * 1024;
var cUrl = new URL(window.location);
getThreads(cUrl.pathname.split('/')[2]);
getReplies();

//FORUM
$(document).ready(function(){
  $('#new_thread').click(function(){
    $('#thread_form').slideDown('slow');
  })
})

paintCurrentPageButton()
function paintCurrentPageButton(){
  var cUrl = new URL(window.location);
  console.log(cUrl);
  $('.current-btn').each(function(){
    // console.log(cUrl.pathname.startsWith($(this).attr('href')));
    if (cUrl.pathname.startsWith($(this).attr('href'))){
      $(this).css('color','rgba(13,168,136,1)');
      $(this).css('border-bottom','2px solid');
      $(this).css('border-color','rgba(209,213,219,1)');
    }
  })
}

$(document).ready(function(){
  $('#thread_submit').click(function(){
    if(file == undefined){
      file = 'nopic';
    }
    if($('.subject').val() != '' && $('.txt_area').val() != ''){
      if($('.subject').val().length > 50){
        $('.subject').css('border-color', 'red');
      }else{
        createThread(file);
        $('#thread_form').slideUp('slow');
        clearTF();
      }
    } else{
      $('.subject').css('border-color', 'red');
      $('.txt_area').css('border-color','red');
    }
    $('.subject').focus(function(){
      $('.subject').css('border-color', 'rgba(13,148,136,0.75)');
    });
    $('.txt_area').focus(function(){
      $('.txt_area').css('border-color', 'rgba(13,148,136,0.75)');
    });
  })
})

$(document).mouseup(function(e){
  if(!$('#thread_form').is(e.target) && $('#thread_form').has(e.target).length == 0 && !$('#new_thread').is(e.target)){
    $('#thread_form').slideUp('slow');
    clearTF();
    console.log('closed by click on outside el')
  };
})

$(document).on('click','.reply_btn',function(){
  $('#thread_form').slideDown();
  var replytoid = $(this).attr('id');
  $('.reply_field').html('>>#'+replytoid);
  $('#reply_to').attr('value',replytoid);
})
$(document).ready(function(){
  $('.reply_field').click(function(){
    $('.reply_field').html('');
    $('#reply_to').attr('value','');
  })
})

$(document).ready(function(){
  $('#add_pic').on('change', function(){
    $('.eim_error').html('');
    file = this.files[0];
    if ( file.size > maxFileSize) {
      alert('Размер фотографии не должен превышать 2 Мб');
      $('#add_pic').prop('value', null);
    }else{
      if ( !file.type.match(/image\/(jpeg|jpg|png|gif)/) ) {
        alert('Фотография должна быть в формате jpg, png или gif');
        $('#add_pic').prop('value', null);
      }else{
        preview(file);
      }
    }
  });

$('.preview').click(function(){
  file = undefined;
  $('.preview').attr('src', '');
  $('.eim_error').html('');
  $('#add_pic').prop('value', null);
  $('.preview_popup').attr('src', '');
  $('.preview').hide();
  $('.p_popup').hide();
})
});

$(window).scroll(function() {
  if ($(this).scrollTop()>250){
    $('#scrollUp').fadeIn();
  } else{
    $('#scrollUp').fadeOut();
  }
 });

$(document).ready(function(){
  $('#scrollUp').click(function(){
    $('html,body').animate({scrollTop:0},'300');
  })
})

//reply section script
$(document).ready(function(){
  $('#reply_submit').mouseup(function(){
    if($('.txt_area').val() != ''){
      sendReply(files);
      $('#thread_form').slideUp();
      clearTF();
      setTimeout(getReplies, 200);
      setTimeout(scrollToLastReply,400);
    }else{
      $('.txt_area').css('border-color','red');
    }
  })
  $('.txt_area').focus(function(){
    $('.txt_area').css('border-color','rgb(13,148,136)');
  })
})

// upload reply media preview
var files = [];
$(document).ready(function(){
  $('#reply_pic').on('change', function(){
    var temp = Array.from(this.files);
    if (temp.length > 4){
      for(i = 0; i < 4;i++){
        files.push(temp[i])
      }
    }else{
      files = temp;
    }
    console.log(files);
    var elem = document.querySelector('.preview_reply');
    for (var i = 0;i < files.length;i++){
      if ( files[i].size > maxFileSize) {
        alert('Размер файла не должен превышать 2 Мб');
        $('#reply_pic').prop('value', null);
        break
      }else{
        if ( !files[i].type.match(/image\/(jpeg|jpg|png|gif)/) ) {
          alert('Файл должен быть в формате jpg, png или gif');
          $('#reply_pic').prop('value', null);
          break
        }else{
          var clone = elem.cloneNode(true);
          clone.id = 'preview_' + i;
          elem.after(clone);
          var element = $('#preview_' + i);
          previewMultiple(files[i], element);
        }
      }
    }
  });
});

  $(document).on('click','.preview_reply', function(){
    var elemfullId = $(this).attr('id');
    var elemId = elemfullId.split('_', 1)[1];
    console.log(typeof(files));
    console.log(files);
    files.splice(elemId, 1);
    $(this).remove();
    $('.p_popup').hide();
    $('.preview_popup').attr('src','');
  })

  function previewMultiple(file,elem) {
      var reader = new FileReader();
      reader.addEventListener('load', function(event) {
      elem.attr('src', event.target.result);
      elem.show();
          // $('.preview_popup').attr('src', event.target.result);
      });
      reader.readAsDataURL(file);
  }

// functions
function preview(file) {
    var reader = new FileReader();
    reader.addEventListener('load', function(event) {
        $('.preview').attr('src', event.target.result);
        $('.preview_popup').attr('src', event.target.result);
        $('.preview').show();
    });
    reader.readAsDataURL(file);
}

function createThread(image){
  var form_data = new FormData();
  form_data.append('subject',$('.subject').val());
  form_data.append('content',$('.txt_area').val());
  form_data.append('cid',$('#cid').val());
  form_data.append('image',image);
  $.ajax({
    url: '/create-thread',
    method: 'POST',
    data: form_data,
    dataType: 'json',
    cache: false,
    processData: false,
    contentType: false,
    success: function(response){
      $('#tc_list').html('');
      $('#tc_list').html(response);
    }
  })
}

function sendReply(images){
  var form_data = new FormData();
  form_data.append('content',$('.txt_area').val());
  form_data.append('thid',$('#thid').val());
  if($('#reply_to').val() != ''){
    form_data.append('reply_to',$('#reply_to').val());
  }else{
    form_data.append('reply_to','none');
  }
  for (var i = 0;i < images.length;i++){
    form_data.append('images[]', images[i]);
  }
  $.ajax({
    url: '/send-reply',
    method: 'POST',
    data: form_data,
    dataType: 'json',
    cache: false,
    processData: false,
    contentType: false,
    success: function(response){

    }
  });
}

function getThreads(cat){
  $.ajax({
    url: '/get-threads',
    method: 'POST',
    data: {'cid': cat},
    success: function(response){
      var result = $.parseJSON(response);
      console.log('Data loaded');
      for (let i = 0; i < result.content.length; i++){
        var thread = result.content[i];
        var media = thread.image;
        var opPic = '';
        var user_replies = thread.user_replies;
        if (media != 'nopic'){
          opPic = '\
                  <div class="flex w-[25%] items-start">\
                      <div class="thread-box">\
                          <img class="op_pic max-w-[170px] mini_pic" src="'+ media +'" alt="">\
                      </div>\
                  </div>';
        }

        var reply_block = '';
        if (user_replies.length != 0){
          reply_block = '<div class="replies w-full flex flex-col mt-2 pb-2 border-t-[1px] border-red-900/75">'
          for (let k = 0; k < user_replies.length && k < 3; k++){
            var reply = user_replies[k];
            var reply_to = '';
            if (reply.reply_to != 'none'){
              reply_to = '<span class=""><a class="reply_to" href="/forum/news/'+ thread.id +'#'+ reply.reply_to +'">>>#'+ reply.reply_to +'</a></span>';
            }
            reply_block += '\
            <a href="/forum/news/'+ thread.id +'#'+ reply.id +'">\
            <div id="'+ reply.id +'" class="reply_'+ reply.id +' flex-col w-[95%] text-white px-3 pt-2 pb-3 border-red-900/50 ml-auto border-l-[1px] border-b-[1px] rounded-md reply">\
              <div class="w-full text-neutral-500 mb-1">\
                <span>Ответ#'+ reply.id +'</span>\
                <span>'+ new Date(reply.created_at).toLocaleString() +'</span>\
              </div>\
              <div class="flex flex-col w-full">\
                <div class="flex w-full">\
                  '+ reply.content +'\
                </div>\
              </div>\
            </div>\
            </a>'
          }
          reply_block += '</div>';
        }

        $('#thread_list').append('\
        <div class="flex-col w-full text-white px-3 pt-2 rounded-md border-r-[1px] border-b-[1px] border-teal-600/50 bg-gray-900/50">\
          <div class="w-full text-neutral-500 mb-2">\
              <span>Тред#'+ thread.id +' от <a href="/profile/'+ thread.user_id +'">'+ thread.username +'</a></span>\
              <span>'+ new Date(thread.created_at).toLocaleString() +'</span>\
              <span class="ml-4"> Ответы: '+ thread.replies +'</span>\
          </div>\
          <div class="w-full flex flex-row">\
                '+ opPic +'\
              <a class="w-full ml-2" href="/forum/news/'+ thread.id +'">\
                  <div class="flex flex-col w-[99%]">\
                      <span class="w-full flex text-[22px] font-semibold mb-1">'+ thread.subject +'</span>\
                      <div class="flex w-full text-base mb-3">\
                        '+ thread.content.replaceAll('\n','<br>').substring(0,312) +'\
                      </div>\
                  </div>\
              </a>\
          </div>\
            '+ reply_block +'\
      </div>');
      console.log($('.replies').children());
      $('.replies').find('.reply').last().css('border-bottom','none');
      }
    }
  })
}

function getReplies(){
  $.ajax({
    url: '/get-replies',
    method: 'POST',
    data: {'thid': $('#thid').val()},
    success: function(response){
      console.log(response);
      $('.replies_list').html('');
      $('.replies_list').html(response);
    }
  })
}

function scrollToLastReply(){
  var uid = $('#uid').val();
  var reply = $('.reply_'+uid).last();
  reply.get(0).scrollIntoView({behavior: 'smooth'});
  reply.css('background-color','rgba(13,118,106,0.5)');

  setTimeout(function(){
    reply.css('background-color','rgba(14,88,76,0.5)')
  },1800);
  setTimeout(function(){
    reply.last().css('background-color','rgba(15,64,59,0.5)')
  },1850);
  setTimeout(function(){
    reply.last().css('background-color','rgba(16,44,49,0.5)')
  },1900);
  setTimeout(function(){
    reply.css('background-color','rgba(17,34,39,0.5)')
  },1950);
  setTimeout(function(){
    reply.css('background-color','rgba(17,24,39,0.5)')
  },2000);
}

function clearTF(){
  $('.txt_area').val('').change();
  $('.txt_area').css('border-color','rgb(13,148,136)');
  $('.subject').val('').change();
  $('.reply_field').html('');
  $('#reply_to').attr('value','');
  $('#reply_pic').prop('value', null);
  for(var i = 0; i < 4; i++){
    $('#preview_' + i).remove();
  }

  files = 'nopic';
}
