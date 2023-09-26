$.ajaxSetup({
  headers: {
      'X-CSRF-TOKEN': $('input[name="_token"]').attr('value')
  }
});
var cUrl = new URL(window.location);
var user_id = $('#uid').val();
var contact = {};
var conn = new WebSocket('ws://localhost:8090');
conn.onopen = function(e) {
    console.log("Connection established!");
    conn.send(JSON.stringify({command: "register", userId: user_id}));
};

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

if (cUrl.hash != '' && cUrl.hash !='#contacts' && cUrl.hash != '#'+user_id){
  // $('.msg_window').show();
  let frId = cUrl.hash.split('#')[1];
  console.log(frId);
  getMessages(frId);
}
getContacts(user_id);
// friends list logic

$('#fl_background').mouseup(function(e){
  if(!$('#fl_modal').is(e.target) && $('#fl_modal').has(e.target).length == 0){
    $('#fl_background').fadeOut();
  }
})
$('.plus_icon').mouseup(function(){
  $('#fl_background').show();
  $('.friends_tab').css('font-size','22px');
  $('.friends_tab').css('font-weight','bold');
  $('.flm_header').css('border-color','rgba(13,148,136,0.25)');
  $('.requests_tab').hide();
  $('#friends_list_modal').show();
  $('#requests_list_modal').hide();
  getFriends(user_id);
});

$(document).on('click','.card',function(e){
  var contactId = $(this).attr('id').split('_')[1];
  var contactPic = $(this).find('.card-userpic').attr('src');
  var contactName = $.trim($(this).find('.card-username').text());
  contact = {id: contactId, userpic: contactPic, username: contactName};

  $('.card').css('border-color','rgba(13,148,136,0.5)');
  $('.card').css('background-color','rgba(38,38,38,0.25)');

  $(this).css('border-color','rgba(220,38,38,0.5)');
  $(this).css('background-color','rgba(82,82,82,0.25)');

  $('#msg_list_header').html(contactName);
  $('.msg-list').html('');
  $('.msg-list').attr('id','msg_list_'+contactId)
  $('#msg_field').val('').change();
  $('#add_pic').prop('value', null);
  $('#msg_window').show();
  $('#fl_background').fadeOut();
  getMessages(contact.id);
  for (var i = 0; i < 4; i++){
    $('#preview_' + i).remove();
  }
  console.log($('#msg_field').val() == '');
  setTimeout(scrollToLastMessage,300);
  location.hash = '#'+contact.id;
})
conn.onmessage = function(e) {
    console.log(e.data);
  var message = JSON.parse(e.data);
  var recieveDate = new Date(message.message.date);
  console.log(recieveDate);
    // Сообщение контакта
      $('#msg_list_'+message.from).append('\
      <div class="msg_box w-full rounded-md flex flex-row mb-2">\
        <div class="rc_pic_box p-1.5 shrink-0">\
          <img src="'+contact.userpic+'" alt="" class="rc_pic rounded-md">\
        </div>\
        <div class="flex flex-row mt-[8px]">\
          <div class="msg-text py-1 px-2 text-[16px] bg-red-900/50 rounded-md">\
            '+message.message.content+'\
          </div>\
          <div class="text-neutral-500 mx-2 pb-1 text-right self-end">\
            '+recieveDate.toLocaleTimeString().slice(0,-3)+'\
          </div>\
        </div>\
      </div>\
      ');
      scrollToLastMessage();
};

function getFriends(uid){
  $.ajax({
    url: '/get-friends-to-contact',
    method: 'POST',
    data: {uid: uid},
    success: function(response){
      $('#f_list').html('');
      $('#f_list').html(response);
    }
  })
 }

 // upload message media preview
 var files = [];
 var maxFileSize = 2 * 1024 * 1024;
 $(document).ready(function(){
   $('#add_pic').on('change', function(){
     var temp = Array.from(this.files);
     if (temp.length > 4){
       for(i = 0; i < 4;i++){
         files.push(temp[i])
       }
     }else{
       files = temp;
     }
     // console.log(files);
     var elem = document.querySelector('.preview_post');
     for (var i = 0;i < files.length;i++){
       if ( files[i].size > maxFileSize) {
         alert('Размер файла не должен превышать 2 Мб');
         $('#add_pic').prop('value', null);
         break
       }else{
         if ( !files[i].type.match(/image\/(jpeg|jpg|png|gif)/) ) {
           alert('Файл должен быть в формате jpg, png или gif');
           $('#add_pic').prop('value', null);
           break
         }else{
           var clone = elem.cloneNode(true);
           $('.pic_counter').html(files.length);
           clone.id = 'preview_' + i;
           elem.after(clone);
           var element = $('#preview_' + i);
           previewMultiple(files[i], element);
         }
       }
     }
   });
   $(document).on('mouseover','#add_pic_icon', function(){
     $('#preview_modal'). show();
   })
   $(document).on('mouseleave','#preview_modal',function(){
     $('#preview_modal').hide();
   })
 });
 $(document).on('click','.preview_post', function(){
   var elemfullId = $(this).attr('id');
   var elemId = elemfullId.split('_', 1)[1];
   console.log(typeof(files));
   files.splice(elemId, 1);
   $(this).remove();
   $('.pic_counter').html(files.length);
   if (files.length === 0){
     $('#add_pic').prop('value', null);
   }
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

 function run(){
   var msg = $('#msg_field').val();
   var curUserpic = $('#auth_userpic').attr('src');
   if (msg === '' && $('#add_pic')[0].files.length === 0){
     $('#msg_field').css('border-color','red');
     setTimeout(function(){
       setTimeout(function(){
         $('#msg_field').css('border-color','rgba(240,10,10,0.9)');
       },300);
       setTimeout(function(){
         $('#msg_field').css('border-color','rgba(220,15,15,0.8)');
       },300);
       setTimeout(function(){
         $('#msg_field').css('border-color','rgba(200,20,20,0.7)');
       },300);
       setTimeout(function(){
         $('#msg_field').css('border-color','rgba(170,25,25,0.6)');
       },300);
       setTimeout(function(){
         $('#msg_field').css('border-color','rgba(127,29,29,0.5)');
       },300);
     },1500)
   }else{
     if (contact.id === undefined){
       var cid = cUrl.hash.split('#')[1];
     }else{
       var cid = contact.id;
     }
     if ($('#add_pic')[0].files.length != 0){
       sendMessage(user_id, cid, msg, files);
     } else{
       sendMessage(user_id, cid, msg);
     }
     $('#msg_field').val('').change();
     $('#add_pic').prop('value', null);
     for (var i = 0; i < 4; i++){
       $('#preview_' + i).remove();
     }
   }
 }
 //Send message
  var content;
  $('#send_msg').click(function(){
    run();
  });
  $(document).ready(function() {
      $('#msg_field').keyup(function(e){
          if (e.ctrlKey && e.keyCode == 13){
            e.preventDefault();
            console.log('sent')
            run();
          }
      });
  });
var date;
 function sendMessage(from, to, message, images=undefined){
   var form_data = new FormData();
     form_data.append('from', from);
     form_data.append('to', to);
     form_data.append('message', message);
   if (images != undefined){
     for (var i = 0;i < images.length;i++){
       form_data.append('images[]', images[i]);
     }
     console.log(images);
   }
   $.ajax({
     url: '/send-message',
     method: 'POST',
     data: form_data,
     dataType: 'json',
     cache: false,
     processData: false,
     contentType: false,
     success: function(response){
       $('#add_pic').prop('value', null);
       $('.pic_counter').html(0);
        if(response.content === null){
          content = '<br>'
        }else{
          content = response.content + '<br>';
        }
        date = response.date;
        console.log(date);
        if (response.images != undefined){
          var picture;
          for (var i = 0; i < response.images.length; i++){
            picture = '<img src="'+response.images[i]+'" class="my-1 mini_pic msg_pic">';
            content = content + picture;
          }
        }
     }
   }).done(function(){

     var curUserpic = $('#auth_userpic').attr('src');
     if (contact.id === undefined){
       var cid = cUrl.hash.split('#')[1];
     }else{
       var cid = contact.id;
     }
     console.log(cid);
     conn.send(JSON.stringify({command: "message", from: user_id, to: cid, message: {content:content, date: date}}));

     var msgDate = new Date(date)
     // Сообщение пользователя
       $('#msg_list_'+cid).append('\
       <div class="w-full msg_box w-full rounded-md flex flex-row justify-end mb-2">\
       <div class="flex flex-row-reverse mt-[8px]">\
         <div class="msg-text py-1 px-2 text-[16px] text-right bg-teal-900/50 rounded-md">\
           '+content+'\
         </div>\
         <div class="text-neutral-500 mx-2 pb-1 self-end">\
           '+msgDate.toLocaleTimeString().slice(0,-3)+'\
         </div>\
       </div>\
         <div class="rc_pic_box p-1.5 shrink-0">\
           <img src="'+curUserpic+'" alt="" class="rc_pic rounded-md">\
         </div>\
       </div>\
         ');
         scrollToLastMessage();
   });
 }

 function getMessages(cid){
   $.ajax({
     url: '/get-messages',
     method: 'POST',
     data: {cid: cid},
     success: function(response){
       var result = $.parseJSON(response);
       contact = {id: cid, userpic: result.userpic, username: result.username};
       var curUserpic = $('#auth_userpic').attr('src');
       $('#msg_list_header').html(result.username);
       $('.msg-list').html('');
       $('.msg-list').attr('id','msg_list_'+cid)
       $('#msg_field').val('').change();
       $('#add_pic').prop('value', null);
       $('#msg_window').show();
       for (var k = 0; k < result.messages.length; k++){
         var message = result.messages[k];
         var rawDate = new Date(message.created_at);
         if (message.created_at.split('T')[0] === result.date){
           var date = rawDate.toLocaleTimeString();
         } else{
           var date = rawDate.toLocaleString();
         }

         if(message.content === null){
           var text = '';
         }else{
           var text = message.content;
         }
         var media = message.media;
         var img_block = '';
         var pic_path;
         if (media.length != 0){
           for (let i = 0; i < media.length;i++){
             pic_path = media[i];
             img_block += '<img src="'+pic_path+'" class="my-1 mini_pic msg_pic">';
           }
         }
         if (message.from != user_id){
           $('#msg_list_'+message.from).append('\
           <div class="msg_box w-full rounded-md flex flex-row mb-2">\
             <div class="rc_pic_box p-1.5 shrink-0">\
               <img src="'+result.userpic+'" alt="" class="rc_pic rounded-md">\
             </div>\
             <div class="flex flex-row mt-[8px]">\
               <div class="msg-text py-1 px-2 text-[16px] bg-red-900/50 rounded-md">\
                 '+text+img_block+'\
               </div>\
               <div class="text-neutral-500 mx-2 pb-1 text-right self-end">\
                 '+date.slice(0,-3)+'\
               </div>\
             </div>\
           </div>\
           ');
         } else{
           $('#msg_list_'+message.to).append('\
           <div class="w-full msg_box w-full rounded-md flex flex-row justify-end mb-2">\
           <div class="flex flex-row-reverse mt-[8px]">\
             <div class="msg-text py-1 bg-teal-900/50 rounded-md px-2 text-[16px] text-right">\
               '+text+img_block+'\
             </div>\
             <div class="text-neutral-500 mx-2 pb-1 self-end">\
               '+date.slice(0,-3)+'\
             </div>\
           </div>\
             <div class="rc_pic_box p-1.5 shrink-0">\
               <img src="'+curUserpic+'" alt="" class="rc_pic rounded-md">\
             </div>\
           </div>\
             ');
         }
       }
       setTimeout(scrollToLastMessage,300);
     }
   })
 }

 function getContacts(id){
   $.ajax({
     url: '/get-contacts',
     method: 'POST',
     data: {uid: id},
     success: function(response){
       var result = $.parseJSON(response);
       console.log(result);
       $('#contacts_list').html('');
       for (var i = 0; i < result.length; i++){
         let contact = result[i];
         $('#contacts_list').append('\
         <div id="card_'+contact.id+'" class="card flex flex-row h-15 w-full rounded-md border-r-[1px] border-b-[1px] border-teal-600/50 bg-neutral-800/25 hover:bg-neutral-600/25 cursor-pointer">\
           <div class="fc_pic_box p-1.5">\
             <a href="/profile/'+contact.id+'">\
             <img src="'+contact.userpic+'" class="card-userpic rounded-md">\
             </a>\
           </div>\
           <div class="card-username text-xl font-bold pt-[14px] pl-2">\
             '+contact.username+'\
           </div>\
         </div>\
         ')
       }
       let frId = cUrl.hash.split('#')[1];
       $('#card_'+frId).css('border-color','rgba(220,38,38,0.5)');
       $('#card_'+frId).css('background-color','rgba(82,82,82,0.25)');
     }
   })
 }

 function scrollToLastMessage(){
   var msg_block = $('.msg-list');
   msg_block.scrollTop(msg_block.prop('scrollHeight'));
 }
