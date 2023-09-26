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


//USER PROFILE

// user post logic
$('#new_post').mouseup(function(){
  $('#user_post_form').show('slow');
  console.log('clicked')
})
$(document).mouseup(function(e){
  if(!$('#user_post_form').is(e.target) && $('#user_post_form').has(e.target).length == 0 && !$('#new_post').is(e.target) && !$('#new_post').children('span').is(e.target)){
    clearPF();
    console.log('closed by click on outside el')
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
$(document).on('click','.userpost',function(e){
  if(!$('.mini_pic').is(e.target)){
    var upid = $(this).attr('id');
    $('#up_background').show()
    getCurrentPost(upid);
    setTimeout(updateComments,300);
  }
})
$('#up_background').mouseup(function(e){
  if(!$('#up_modal').is(e.target) && $('#up_modal').has(e.target).length == 0 && !$('#comm_modal').is(e.target) && $('#comm_modal').has(e.target).length == 0){
    $('#up_background').fadeOut();
    $('#userpost_m').html('');
    clearComm();
  }
})
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

//comment logic
$(document).on('input','.comm_area', function(){
  this.style.height = '57px';
  var applyNow = this.style.offsetHeight;
  this.style.height = this.scrollHeight - 20 + 'px';
})

$(document).ready(function(){
  $('.comm_submit').mouseup(function(){
    sendComment();
    clearComm();
    updateComments();
  })
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

function clearComm(){
  $('.comm_area').val('').change();
  $('#comm_pic').prop('value', null);
  console.log('comment field deleted');
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
  console.log(files)
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

function getCurrentPost(post_id){
  $.ajax({
    url: '/get-current-post',
    method: 'POST',
    data: {pid: post_id},
    success: function(response){
      console.log(response)
      $('#userpost_m').html('');
      $('#userpost_m').html(response);

    }
  })
}

function getAllPosts(uid){
  $.ajax({
    url: '/get-all-posts',
    method: 'POST',
    data: {uid: uid},
    success: function(response){
      $('#user_posts').html('');
      $('#user_posts').html(response);
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

function sendComment(){
  var form_data = new FormData();
  console.log(form_data);
  form_data.append('_token', $('input[name="_token"]').attr('value'));
  form_data.append('content', $('.comm_area').val());
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
      console.log(response);
      $('#comments').html('');
      $('#comments').html(response);
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
