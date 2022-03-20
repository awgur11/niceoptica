<style type="text/css">
    #file-dropzone{
        padding: 3.2em 0;
        border:2px dashed #ddd;
        border-radius: 15px;
        background-color: #fff;
    }
    #file-dropzone.hover{
        background-color: #f3f3f3;
    }
    #file-dropzone.drop{
        background-color: #d4f1c8;
    }
    #download-pictures-zone>.picture-block{
        padding: 3px;
    }
    .picture-card{
        height: 150px;
        background-position: center;
        background-size: contain;
        transition: 0.5s;
        background-repeat: no-repeat;
        border: 1px solid #ddd;
    }
    .picture-block{
        overflow: hidden;
    }
    .picture-block>.picture-colour-button,
    .picture-block>.picture-fvalue-button{
        position: absolute;
        bottom: 0;
        right:-50px;
        transition: 0.5s;
        cursor: pointer;
        z-index: 99;
    }
    .picture-block:hover>.picture-colour-button,
    .picture-block:hover>.picture-fvalue-button{
        right: 3px;
    }
    .picture-block>.picture-title-button{
        position: absolute;
        bottom: -50px;
        left:0;
        transition: 0.5s;
        cursor: pointer;
        z-index: 99;
        left: 3px;
    }
    .picture-block:hover>.picture-title-button{
        bottom:3px;
    }
    .picture-block>.picture-move-button{
        position: absolute;
        top: 3px;
        left:-50px;
        transition: 0.5s;
        cursor: pointer;
        z-index: 99;
    }
    .picture-block:hover>.picture-move-button{
        left: 3px;
    }
    .picture-block>.picture-del-button{
        position: absolute;
        top: -50px;
        right: 3px;
        transition: 0.5s;
        cursor: pointer;
        z-index: 99;
    }
    .picture-block:hover>.picture-del-button{
        top: 3px;
    }
    .picture-card>.picture-rot-button{
        position: absolute;
        top: 40%;
        left: 40%;
        transition-delay: 0.3s;
        transition: 0.5s;
        cursor: pointer;
        transform: scale(0.5) rotateZ(-180deg);
        opacity: 0;
        border-radius: 50%;
    }
    .picture-card:hover>.picture-rot-button{
        opacity: 1;
        transform: scale(1) rotateZ(0deg);
    }

</style>
<script type="text/javascript">
$(document).on('click', '.picture-del-button', function(){

    var id = $(this).data('id');

    $.ajax({
        method: 'GET',
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url: "/adminzone/delete-picture-ajax/" + id,
        success: function()
        {
            $('#picture-block-' + id).addClass('flipOutX').addClass('animated');
        },
        error:  function(xhr, str)
        {
            alert('Error: ' + xhr.responseCode);
        }
    });
});

$(document).on('click', '.picture-rot-button', function(){

    var id = $(this).data('id'),
        deg = Number($('#picture-block-' + id).data('deg')),
        width = $('#picture-block-' + id).width(),
        height = $('#picture-block-' + id).height();

    $.ajax({
        method: 'GET',
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url: "/adminzone/rotate-picture-ajax/",
        data:{
            id: id,
        },
        success: function(uri)
        {
            deg = deg + 90;

            $('#picture-block-' + id).data('deg', deg);

            if(deg%180 == 90)
                background_size = '65%';
            else
                background_size = '120%';

            $('#picture-block-' + id + ' .picture-card').css({'transform': 'rotate(' + deg + 'deg)'});
            $('#picture-block-' + id + ' .picture-card').css({'background-size' : background_size});
            $('#picture-block-' + id).width('150px');
            console.log($('#picture-block-' + id).css('width'));
        },
        error:  function(xhr, str)
        {
            alert('Error: ' + xhr.responseCode);
        }
    });
});

$(function(){
    $(".sortable-pictures").sortable({
        cursor: "move",
        opacity: 0.6,
        update: function( event, ui ) {
            $('.picture-block').each(function(index) {

                $(this).find('.picture-move-button').data('value',index + 1);

                data = jQuery.param($(this).find('.picture-move-button').data());

                console.log(data);

                $.ajax({
                    url: '/adminzone/change_cell',
                    method: 'GET',
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    data: data,
                    error: function(){},
                    success: function(){}
                });
            });
        } 
    });
});

$(document).on('click', '.picture-title-button', function(){

    var data = $(this).data();

    $.ajax({
        url: data.edit,
        method: 'GET',
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        error: function(error){
            console.log(error);
        },
        success: function(data){
            console.log(data);

            $('#pictureModal .input-group input').val('');

            data.languages.forEach(function(value){
                $('#pictureModal #languages-title-' + value.language).val(value.title);

            });

            $('#pictureModal #id').val(data.id);

            data.languages.forEach(function(el){
                $('#pictureModal #languages-titlepicture-' + el.language).val(el.title);
            });
        }
    });
});

function update_picture_title(){
    
    var msg = $('#picture-title-form').serialize();

    $.ajax({
        method: 'POST',
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url: "{{ route('picture.update') }}",
        data: msg,
        success: function(data)
        {
            $('#pictureModal .close').click();
        },
        error:  function(xhr, str)
        {
            alert('Error: ' + xhr.responseCode);
        }
    });
}
@if(!isset($colours))
    $(function(){
        $('.picture-colour-button').css('display', 'none');
    });
@endif
</script>
<!-- The Modal PICTURE TITLE-->
<div class="modal fade" id="pictureModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">@lang('Picture Title')</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                
                @include('layouts.admin.form.form-start', ['action' => 'javascript:void(null);', 'onsubmit' => 'update_picture_title()', 'id' => 'picture-title-form'])
                
                <input type="hidden" name="id" id="id">

                @include('layouts.admin.form.form-input', ['title' => __('Title'), 'name' => 'title', 'required' => 'required', 'prefix_id' => 'picture'])
  
                @include('layouts.admin.form.form-end')
            </div>
        </div>
    </div>
</div>

<h3 class="text-center">@lang("Gallery block")</h3>
<div class="row">
    <div class="col-12 col-md-6">
        <div class="custom-file mb-3 mt-3">
            <input type="file" class="custom-file-input" id="preview-ajax" >
            <label class="custom-file-label" for="customFile">@lang('Choose file on Your computer')</label>
        </div>
        <div class="input-group mb-3 mt-3">
            <input type="text" class="form-control" placeholder="@lang('insert image link')" aria-label="Recipient's username" aria-describedby="basic-addon2" id="preview-link-upload-input">
            <div class="input-group-append">
                <button class="btn btn-outline-secondary" type="button" id="preview-link-upload-button">@lang('Upload')</button>
            </div>
        </div>
        <div>
            <small class="form-text text-muted">@lang('On some sites, images are protected from downloading')</small>
        </div>
    </div>
    <div class="col-6 mt-3">
        <div id="file-dropzone" class="text-center">
            <span>@lang('Drop file here')<br/><small>.jpg, .png, .gif</small></span>
        </div>
    </div>
</div>

<div class="row mt-3 sortable-pictures" id="download-pictures-zone" style="min-height: 50px; padding: 15px;">
</div>

<script type="text/javascript">
    $(function(){
        var pictures = {!! $pictures->toJson() !!};

        pictures.forEach(function(picture){
            insert_picture(picture);
        })
    })
</script>
<!--COLOURS BLOCK-->
@if(isset($colours) && $colours->count() > 1)
<style type="text/css">
    #coloursSelectBlock{
        position: absolute;
        top: 100%;
        left: 45%;
        z-index: -1;
        padding: 5px;
        box-shadow: 0 0 35px rgba(0,0,0,.2);
        width: 270px;
        background-color: #fff;
        transition: 0.5s;
        opacity: 0;
        transform: 
    }
    #coloursSelectBlock.show-block{
        opacity: 1;
        z-index: 999;
    }
</style>

<script type="text/javascript">
$(document).on('click', '.picture-colour-button', function(){
    var position = $(this).parent().position(),
        width = $(this).parent().width(),
        id = $(this).data('id'), 
        colour_id = $(this).data('colour_id');

    if(colour_id != null)
        $('#coloursSelect option[value="' + colour_id + '"]').prop('selected', true);

    $('#coloursSelect').data('id', id);

    $('#coloursSelectBlock').css({'top' : position.top + 150, 'left' : position.left, 'width' : width}).addClass('show-block');
});

$(document).on('change', '#coloursSelect', function(){
    var id = $(this).data('id'), 
        colour_id = $(this).val();

    $('#picture-colour-button-' + id).data('colour_id', colour_id);

    $.ajax({
        method: 'GET',
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url: '/adminzone/attach-colour-picture-ajax/' + id + '/' + colour_id,
        success: function()
        {
            $('#coloursSelectBlock').removeClass('show-block');
        },
        error:  function(xhr, str)
        {
            alert('Error: ' + xhr.responseCode);
        }
    });
});
    
$(document).on('click', '#coloursSelectBlock-close-button', function(){
    $('#coloursSelectBlock').removeClass('show-block');
}); 
</script>

<div id="coloursSelectBlock">
    <div class="text-right">
        <div id="coloursSelectBlock-close-button" class="text-danger" style="cursor: pointer;">X</div>
    </div>
    <select class="form-control form-control-sm" id="coloursSelect">
        <option value="0">@lang('not chosen')</option>
    @foreach($colours as $colour)
        <option value="{{ $colour->id }}">{{ $colour->title }}</option>
    @endforeach
    </select>
</div>
@endif

<script type="text/javascript">

function insert_picture(picture)
{
    $('#download-pictures-zone').append('\
        <div class="col-6 col-md-4 col-lg-3 picture-block" id="picture-block-' + picture.id + '" data-deg="0">\
            <div class="picture-title-button btn btn-success" data-id="' + picture.id + '" data-edit="/adminzone/edit-picture-ajax/' + picture.id + '"  title="@lang("Picture title")" data-toggle="modal" data-target="#pictureModal"><i class="fas fa-pencil-alt"></i>\
            </div>\
            <div class="picture-move-button btn btn-warning" data-id="' + picture.id + '" data-value="0" data-column="position" data-table="pictures" title="@lang('Move')"><i class="fas fa-arrows-alt"></i>\
            </div>\
            <div class="picture-del-button btn btn-danger" data-id="' + picture.id + '" title="@lang('Delete')"><i class="fas fa-trash-alt"></i>\
            </div>\
            <div class="picture-card"  style="background-image: url(' + picture.five_preview + ')">\
                <div class="picture-rot-button btn btn-info" data-id="' + picture.id + '" title="@lang('Rotate')"><i class="fas fa-sync-alt"></i>\
                </div>\
            </div>\
        </div>');
}

function upload_file(file = null, file_link = null){
    var formData = new FormData();

    if(file != null){
        formData.append("preview", file);
    /*    if (file.size > 2*1024*1024)
        {
            alert('maximum file size is 2 MB');
            return false;
        } */
    }
    else if(file_link != null)
    {
        formData.append("preview_link", file_link);
    }
//    <div class="picture-colour-button btn btn-primary" data-id="' + picture.id + '" data-colour_id="0" title="@lang("Colours")" id="picture-colour-button-' + picture.id + '"><i class="fas fa-palette"></i></div><div class="picture-title-button btn btn-success" data-id="' + picture.id + '" data-edit="/adminzone/edit-picture-ajax/' + picture.id + '"  title="@lang("Picture title")" data-toggle="modal" data-target="#pictureModal"><i class="fas fa-pencil-alt"></i>\ </div>\

    $.ajax({
        method: 'POST',
        cache: false,
        contentType: false,
        processData: false,
        dataType: 'json', 
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url: "/adminzone/upload-picture-ajax",
        data: formData,
        success: function(picture)
        { 
            $('#preview-ajax').val(''); 
            $('#file-dropzone').removeClass('drop');

            insert_picture(picture);
            
             
        },
        error:  function(xhr, str)
        {
            alert('Error: ' + xhr.responseCode);
        }
    });
}
$(document).on('change', '#preview-ajax', function(){
    var file = $(this).prop('files')[0];
    upload_file(file);
});
$(document).ready(function(){
    if($('#file-dropzone').length > 0) 
    {
        var dropZone = $('#file-dropzone');
  
        dropZone[0].ondragover = function() {
            dropZone.addClass('hover');
            return false;
        }; 
    
        dropZone[0].ondragleave = function() {
            dropZone.removeClass('hover');
            return false;
        };

        dropZone[0].ondrop = function(event) {
            event.preventDefault();
            dropZone.removeClass('hover');
            dropZone.addClass('drop');
            var files = event.dataTransfer.files

            for($i=0; files.length>$i; $i++) {
                upload_file(files[$i]);
            }
        } 
    }
});
$(document).on('click', '#preview-link-upload-button', function(){
    var preview_link = $('#preview-link-upload-input').val();

    upload_file(null, preview_link);

    $('#preview-link-upload-input').val('');
});
</script>