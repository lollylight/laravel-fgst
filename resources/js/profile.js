$.ajaxSetup({
  headers: {
      'X-CSRF-TOKEN': $('input[name="_token"]').attr('value')
  }
});

var file = undefined;
var maxFileSize = 2 * 1024 * 1024;
var cUrl = new URL(window.location);
var user_id = cUrl.pathname.split('/')[2];
getAllPosts(user_id);
checkFriendStatus(user_id);
checkFriendsRequests();
getFriends(user_id);

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

//USER PROFILE

// user post logic
$('#new_post').mouseup(function(){
  $('#user_post_form').show('slow');
  console.log('clicked')
})
$(document).mouseup(function(e){
  if(!$('#user_post_form').is(e.target) && $('#user_post_form').has(e.target).length == 0 && !$('#new_post').is(e.target) && !$('#new_post').children('span').is(e.target)){
    clearPF();
    // console.log('closed by click on outside el')
  };
})
$(document).ready(function(){
  $('#post_submit').click(function(){
    if ($('.subject').val() != '' && $('.subject').val().length < 50){
      createUserPost(files);
      getAllPosts(user_id);
      clearPF();
    } else{
      $('.subject').css('background-color','rgba(167,29,29,0.75)');
    }
  });
  $('.subject').focus(function(){

    $('.subject').css('background-color','rgba(23,23,23,0.75)');
  })
})


// edit info logic
$('#edit_info_btn').mouseup(function(){
  $('#eim_bg').show()
})
$(document).ready(function(){
  $('#eim_bg').mouseup(function(e){
    if(!$('#eim_modal').is(e.target) && $('#eim_modal').has(e.target).length == 0){
    $('#eim_bg').hide();
    clearEIM();
  };
  });

  $('#eim_cancel').click(function(){
    $('#eim_bg').hide();
    clearEIM();
  });

  $('#eim_save').click(function(){
    $('#eim_bg').hide();
    updateUserInfo();
    clearEIM();
  });

  $('#eim_upload').click(function(){
    updateUserpic(file);
  });
})

// upload userpic preview
$(document).ready(function(){
  $('#add_pic').on('change', function(){
    $('.eim_error').html('');
    file = this.files[0];
    if ( file.size > maxFileSize) {
      $('.eim_error').html('Размер фотографии не должен превышать 2 Мб');
      $('#add_pic').prop('value', null);
    }else{
      if ( !file.type.match(/image\/(jpeg|jpg|png|gif)/) ) {
        $('.eim_error').html('Фотография должна быть в формате jpg, png или gif');
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

function preview(file) {
    var reader = new FileReader();
    reader.addEventListener('load', function(event) {
        $('.preview').attr('src', event.target.result);
        $('.preview_popup').attr('src', event.target.result);
        $('.preview').show();
    });
    reader.readAsDataURL(file);
}

// upload postpic preview
var files = [];
$(document).ready(function(){
  $('#post_pic').on('change', function(){
    var temp = Array.from(this.files);
    if (temp.length > 4){
      for(i = 0; i < 4;i++){
        files.push(temp[i])
      }
    }else{
      files = temp;
    }
    console.log(files);
    var elem = document.querySelector('.preview_post');
    for (var i = 0;i < files.length;i++){
      if ( files[i].size > maxFileSize) {
        alert('Размер файла не должен превышать 2 Мб');
        $('#post_pic').prop('value', null);
        break
      }else{
        if ( !files[i].type.match(/image\/(jpeg|jpg|png|gif)/) ) {
          alert('Файл должен быть в формате jpg, png или gif');
          $('#post_pic').prop('value', null);
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
  $(document).on('mouseover','.preview_post', function(){
    $('.p_popup'). show();
    $('.preview_popup').attr('src',this.getAttribute('src'));
  })
  $(document).on('mouseleave','.preview_post',function(){
    $('.p_popup').hide();
    $('.preview_popup').attr('src','');
  })
});
$(document).on('click','.preview_post', function(){
  var elemfullId = $(this).attr('id');
  var elemId = elemfullId.split('_', 1)[1];
  console.log(typeof(files));
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



//User Post modal logic

$(document).on('click','.edit_post_btn',function(){
  $('.post_menu').slideDown();
  $('.menu_btn').slideUp();
})

$(document).mouseup(function(e){
  if(!$('.edit_post_btn').is(e.target) && $('.post_menu').has(e.target).length == 0){
      $('.post_menu').slideUp();
      $('.menu_btn').slideDown()
  }
})
$(document).on('click','.del_btn',function(){
  $('#up_background').fadeOut();
  $('#userpost_m').html('');

  deleteUserPost($(this).attr('id'));
  getAllPosts(user_id);
})

// friends list logic

$('#fl_background').mouseup(function(e){
  if(!$('#fl_modal').is(e.target) && $('#fl_modal').has(e.target).length == 0){
    $('#fl_background').fadeOut();
  }
})
$('.flm_button').mouseup(function(){
  $('#fl_background').show();
  $('.friends_tab').css('font-size','22px');
  $('.friends_tab').css('font-weight','bold');
  $('.friends_tab').css('color','rgba(13,148,136,1)');
  $('.flm_header').css('border-color','rgba(13,148,136,0.25)');
  $('.requests_tab').css('font-size','18px');
  $('.requests_tab').css('font-weight','semibold');
  $('.requests_tab').css('color','white');
  $('#friends_list_modal').show();
  $('#requests_list_modal').hide();
});
$('.friends_tab').mouseup(function(){
  $('.friends_tab').css('font-size','23px');
  $('.friends_tab').css('font-weight','bold');
  $('.friends_tab').css('color','rgba(13,148,136,1)');
  $('.flm_header').css('border-color','rgba(13,148,136,0.25)');
  $('.requests_tab').css('font-size','18px');
  $('.requests_tab').css('font-weight','semibold');
  $('.requests_tab').css('color','white');
  $('#friends_list_modal').show();
  $('#requests_list_modal').hide();
});
$('.requests_tab').mouseup(function(){
  $('.requests_tab').css('font-size','23px');
  $('.requests_tab').css('font-weight','bold');
  $('.requests_tab').css('color','rgba(178,30,23,1)');
  $('.flm_header').css('border-color','rgba(178,30,23,0.25)');
  $('.friends_tab').css('font-size','18px');
  $('.friends_tab').css('font-weight','semibold');
  $('.friends_tab').css('color','white');
  $('#friends_list_modal').hide();
  $('#requests_list_modal').show();
});

$(document).ready(function(){
  $('.add_friend').click(function(){
    var fid = $(this).attr('id').split('_')[2];
    sendFriendRequest(fid);
    checkFriendStatus(fid);
  })
})

function manageFriendRequest(requestID, action){
  $.ajax({
    url: '/manage-friend-request',
    method: 'POST',
    data: {rid: requestID, action: action},
    success: function(response){

    }
  })
}

$(document).on('click', '.req_accept',function(){
  var reqID = $(this).attr('id').split('_')[1];
  manageFriendRequest(reqID, 'accept');
  $(this).parents('div.request_card').hide('slow');
  setTimeout(function(){
    getFriends(user_id);
  },300);
})
$(document).on('click', '#req_accept',function(){
  var reqID = $(this).attr('id').split('_')[2];
  manageFriendRequest(reqID, 'accept');
  setTimeout(function(){
    getFriends(user_id);
    checkFriendStatus(user_id);
    $('.pending').removeClass('pending');
  },300);
})
$(document).on('click', '.req_cancel',function(){
  var reqID = $(this).attr('id').split('_')[1];
  manageFriendRequest(reqID, 'cancel');
  $(this).parents('div.request_card').hide('slow');
  setTimeout(function(){
    getFriends(user_id);
  },300);
})

function deleteFriend(uid){
  $.ajax({
    url: '/delete-friend',
    method: 'POST',
    data: {uid: uid},
    success: function(response){
      setTimeout(function(){
        $('#delete_friend').attr('id','add_friend');
        $('.af_label').html('Добавить друга');
      },300)
    }
  })
}

$(document).on('click','#delete_friend',function(){
  deleteFriend(user_id);
  getFriends(user_id);

})
// functions
function clearEIM(){
  $('.name_field').val('').change();
  $('.age_field').val('').change();
  $('.country_field').val('').change();
  $('.preview').attr('src', '');
  $('#add_pic').prop('value', null);
  $('.preview').hide();
}
function clearPF(){
  $('#user_post_form').hide('slow');
  $('.txt_area').val('').change();
  $('.subject').val('').change();
  $('#post_pic').prop('value', null);
  for(var i = 0; i <= 3; i++){
    $('#preview_' + i).remove();
  }
  files = 'nopic';
}

function updateUserInfo(){
  $.ajax({
    url: '/update-profile',
    method: 'post',
    data: $('#userinfo_form').serialize(),
    success: function(response){
      var profile = $.parseJSON(response);
      $('.p_name').html(profile.name);
      $('.p_age').html(profile.age);
      $('.p_country').html(profile.country);
      if (profile.sex === 1){
        $('.p_sex').html('Мужской');
      }else{
        $('.p_sex').html('Женский');
      }
    }
  })
}

function updateUserpic(image){
  var form_data = new FormData();
  form_data.append('_token', $('input[name="_token"]').attr('value'));
  form_data.append('uid',$('.uid').attr('value'));
  form_data.append('image',image);
  // console.log(files)
  $.ajax({
    url: '/update-userpic',
    method: 'POST',
    data: form_data,
    dataType: 'json',
    cache: false,
    processData: false,
    contentType: false,
    success: function(response){
      // var result = $.parseJSON(response);
      $('#prof_pic').attr('src','');
      $('#prof_pic').attr('src',response.userpic_path)
      $('.eim_error').html('Профиль обновлен!');
    }
  })
}

function createUserPost(images){
  var form_data = new FormData();
  form_data.append('_token', $('input[name="_token"]').attr('value'));
  form_data.append('subject', $('.subject').val());
  form_data.append('content', $('.txt_area').val());
  for (var i = 0;i < images.length;i++){
    form_data.append('images[]', images[i]);
  }
  $.ajax({
    url: '/create-userpost',
    method: 'POST',
    data: form_data,
    dataType: 'json',
    cache: false,
    processData: false,
    contentType: false,
    success: function(response){
      // var result = $.parseJSON(response);

    }
  })
}

function getAllPosts(uid){
  $.ajax({
    url: '/get-all-posts',
    method: 'POST',
    data: {uid: uid},
    success: function(response){
      var result = $.parseJSON(response);
      // console.log(result);
      $('#user_posts').html('');
      for (let i = 0; i < result.length; i++){
        var post = result[i];
        var media = post.images;
        var pictures ='';

        if (media.length > 1){

          pictures = '\
          <div class="pictures flex flex-row p-3 border-t-[1px] border-teal-800/25 mt-1">\
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
        $('#user_posts').append('\
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
  })
}

function deleteUserPost(post_id){
  $.ajax({
    url: '/delete-userpost',
    method: 'POST',
    data: {pid: post_id},
    success: function(response){
      console.log(response);
      console.log('Post '+post_id+' Deleted');
    }
  })
}

function sendFriendRequest(uid){
  $.ajax({
    url: '/send-friend-request',
    method: 'POST',
    data: {sid: uid},
    success: function(response){
      console.log('Request sent');
    }
  })
}

function checkFriendStatus(uid){
  $.ajax({
    url: '/check-friend-status',
    method: 'POST',
    data: {sid: uid},
    success: function(response){
      var result = $.parseJSON(response);
      // console.log(result.status);
      if (result.info.status === 0 && result.info.first_user_id != uid){
        $('.add_friend').attr('id','pending').change();
        $('.af_label').html('Запрос отправлен');
        $('#pending').css('background-color','#0d9289')
      }
      else if (result.info.status === 1) {
        $('.add_friend').attr('id','delete_friend').change();
        $('.af_label').html('Удалить друга');
      }
      else if (result.info.status === 0 && result.info.first_user_id === uid){
        $('.add_friend').addClass('.pending');
        $('.add_friend').attr('id','req_accept_'+result.info.first_user_id).change();
        $('.af_label').html('Принять запрос');
        $('#pending').css('background-color','#0d9289')
      }
    }
  })
}

function checkFriendsRequests(){
  $.ajax({
    url: '/check-friends-requests',
    method: 'POST',
    data: {adata: 'check'},
    success: function(response){
      $('#r_list').html('');
      $('#r_list').html(response);
    }
  })
}
function getFriends(uid){
  $.ajax({
    url: '/get-friends',
    method: 'POST',
    data: {uid: uid},
    success: function(response){
      $('#f_list').html('');
      $('#f_list').html(response);
      $('.friends_list').html('');
      $('.friends_list').html(response);
    }
  })
 }
