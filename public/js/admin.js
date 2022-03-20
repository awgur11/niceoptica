    // arrange values in table
function sortingTableAjax(model, ids)
{
  $.ajax({
    url: "/adminzone/admin/sorting",
    data: {
      ids: ids,
      model: model,
    },
    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
    error: function(error){
      console.log(error);
    },
  });
}
$(document).ready(function(){
  $(".sorting-items").sortable({
    axis: 'y',
    opacity: 0.6,
     
    update: function( event, ui ){
      var ids = [],
          model = $(this).data('model');

      $(this).children().each(function(index) {
        ids.push($(this).children('.item-position').data('id'));
      });
      sortingTableAjax(model, ids); 
    }
  });
});
// Add the following code if you want the name of the file appear on select
$(document).on("change", ".custom-file-input", function() {
  var fileName = $(this).val().split("\\").pop();
  console.log(fileName);
  $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
});
//CHANGE TABLE CELL VALUE BY AJAX
function change_cell(data)
{
  var data = jQuery.param(data);

  $.ajax({
    url: '/adminzone/change_cell',
    method: 'GET',
    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
    data: data,
    error: function(error){
      console.log(error.responseJSON.message);
    },
    success: function(){
      saved_window_show();
    }
  });
}
$(document).on('click', '.change_checkbox_ajax', function(){

  var data = $(this).data();

  if($(this).prop('checked')) 
    data.value = 1;
  else 
    data.value = 0;

  change_cell(data);
});

$(document).on('change', '.change-select-ajax, .change-radio-ajax', function(){

  var data = $(this).data();

  data.value = $(this).val();

  change_cell(data);
});

$(document).on('keyup', '.change-input-ajax', function(e){
  if(e.key === "Enter")
  {
    var data = $(this).data();

    data.value = $(this).val();

    change_cell(data);
  }
});

$(document).on('click', '.delete-item', function(){
  var confirmaion_q = 'Вы уверены что хотите удалить данный элемент?';

//confirm_var = confirm(confirmaion_q );
//if (!confirm_var) return false;

  var id = $(this).data('id'),
      url = $(this).data('url'),
      item = $("#item-" + id);
 
  $.ajax({
    method: 'GET',
    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
    url:url, 
    success: function(response){
      item.hide(500,function(){$(this).remove()});
      saved_window_show(response, true);
    },
    error: function(response){
      saved_window_show(response.responseText, false);
    }
  });
});

//SORTING DATA IN TABLES 
$(document).ready(function(){  
  $( "#sortable-table tbody" ).sortable({
    axis: 'y',
    opacity: 0.6,
    update: function( event, ui ){

      var first_item_position = Number($(this).find('.item-position-first').data('position'));
      
      $(this).children().each(function(index) {

        if($(this).find('.item-position').length > 0)
        {
          data = $(this).find('.item-position').first().data();
          data.value = first_item_position + index;

          setTimeout(change_cell, 300*index, data);

    //      change_cell(data);
        }
      }); 
    }
  });

});
$(document).on('click', '.make-translation-button', function(){

  var name = $(this).data('name'),
      phrase = '',
      from = '';

  $('.languages-' + name).each(function(index){
    if($(this).val().trim() != '')
    {
      phrase = $(this).val().trim();
      from = $(this).data('locale');
      return false;
    }
  });
  $('.languages-' + name).each(function(index){
    if($(this).val().trim() == '')
    {
      var to = $(this).data('locale'),
          input = $(this);

      setTimeout(make_translation, 1000*index, from, to, phrase, input)
    }
  });
});

function make_translation(from, to, phrase, input)
{
  $.ajax({
    url: '/adminzone/translations/translate-one-phrase',
    method: 'POST',
    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
    data: {
      to: to,
      from: from,
      phrase: phrase
    },
    error: function(error){
      console.log(error.responseJSON.message);
    },
    success: function(result){
      console.log(from+ ' ' + to + ' ' + phrase);
      input.val(result);
    }
  });
}
//OPTION UPDATE AJAX
function option_update(id) {

  if($('#' + id + ' .ckeditor-block').length > 0)
  {
    $('#' + id + ' .ckeditor-block').each(function(){
      ckeditor = $(this).data('ckeditor');
      CKEDITOR.instances[ckeditor].updateElement();
    });
  }

  if($('#' + id + ' .tinymce-block').length > 0)
  {
    $('#' + id + ' .tinymce-block').each(function(){
      tinymce_id = $(this).data('tinymce');
      console.log(tinymce_id);
      tinymce.init({
        selector: '#' + tinymce_id,
        setup: function (editor) {
          editor.on('change', function () {
            editor.save();
          });
        }
      });
    });
  }

  var msg   = $('#' + id).serialize();

  $.ajax({
    method: 'POST',
    url: "/adminzone/option/update",
    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
    data: msg,
    success: function(data)
    {
      saved_window_show();
    },
    error:  function(xhr, str)
    {
      alert('Возникла ошибка: ' + xhr.responseCode);
    }
  });
}
  // CUSTOM STYLE FOR FILE UPLOAD INPUTS
$(".custom-file-input").on("change", function() {
  var fileName = $(this).val().split("\\").pop();
  $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
});
// SAVING PICTURE BY AJAX BY IN OPTION
function ajax_picture_option_save(event, id){

    var file = $('#' + id).prop('files')[0],
        formData = new FormData(),
        key = $('#' + id).data('key'),
        thumbs = $('#' + id).data('thumbs'),
        file_type = $('#' + id).data('file_type'),
        allowed_ext = $('#' + id).data('allowed_ext'),
        input = $('#' + id),
        max_file_size = $('#' + id).data('max_file_size');

    extension = $('#' + id).val().split('.').pop();
 
    formData.append("preview", file);
    formData.append("key", key);
    formData.append("thumbs", thumbs);
    formData.append("file_type", file_type);

    if (file.size > max_file_size*1024*1024)
    {
      alert('maximum file size is ' + max_file_size + ' MB');
        return false;
    }

    //var file_name = $('#' + id).val();

    if (!allowed_ext.split(', ').includes(extension)) {
        alert('the file format must be ' + allowed_ext);
        return false;
    }
    $('#' + id).val('');
    $.ajax({
      method: 'post',
      dataType: 'json',
      cache: false,
      contentType: false,
      processData: false, 
      headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
      url: "/adminzone/option/update_preview",
      data: formData,
      success: function(data)
      {
        if(data.success === false)
          return alert(data.errors);

        if(file_type == 'video')
        { 
          $('div#' + id + '_result .result-block').html('<video muted class="wrapper__video" controls="controls" style="width: 250px;">\
            <source src="'  + data.response + '">\
          </video>');
          $('div#' + id + '_result .delete-option-picture').removeClass('d-none').css('display', 'inline-block');
          $('#' + id).val('');
        }
        else if(file_type == 'file')
        {
          $('div#' + id + '_result .result-block').html('<a href="' + data.response + '" download><img src="/images/full-folder.png" style="width: 150px;"></div>\
            <div class="file-extension">' + data.response.split('.').pop() + '</div> ');
          $('div#' + id + '_result .delete-option-picture').removeClass('d-none');
          $('#' + id).val('');
        }
        else
        {
          $('div#' + id + '_result .result-block').html('<img src="' + data.response + '" id="img-' + id + '" style="width: 150px;">'); 
          $('div#' + id + '_result .delete-option-picture').removeClass('d-none').css('display', 'inline-block');
          $('#' + id).val('');
        }
      },
      error:  function(xhr, str)
      {
        alert('Error: some error ' + xhr.responseCode);
      }
    });
  }
  //DELETE OPTION PICTURE
$(document).on('click', '.delete-option-picture', function(){
  var key = $(this).data('key'),
      button = $(this),
      file_type = $(this).data('file_type');
  $.ajax({
    url: '/adminzone/option/delete_preview',
    method: 'POST',
    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
    data: {
      key : key,
    },
    success: function()
    {
      if(file_type == 'image')
        $('#' + key + '_result .result-block').html('<img src="/storage/images/no-photo.jpg" style="width: 150px;">');
      else if(file_type == 'file')
        $('#' + key + '_result .result-block').html('<img src="/images/empty-folder.png" style="width: 150px;">');
      else if(file_type == 'video')
        $('#' + key + '_result .result-block').html('<img src="/images/video-camera.png" style="width: 150px;">');

      button.css('display', 'none');

    },
    error: function()
    {
    //$('#message').fadeIn(400).text("Успешно сохранено!").fadeOut(1200);
    }
  });
});
//скачивание картинок которые присутствуют в тексте
  $(document).on('click', '.transfer-pictures-button', function(){
    var data = $(this).data();
    data = $.param(data);

    $.ajax({
      url: '/adminzone/transfer-pictures',
      method: 'GET',
      headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
      data: data,
      success: function(){
        document.location.reload();
        
      },
      error: function(error){
        console.log(error.responseJSON.message);
      }
    });
  });