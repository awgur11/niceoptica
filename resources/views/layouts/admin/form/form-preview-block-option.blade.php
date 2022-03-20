<?php

    $file_type = $file_type ?? 'image';
    $thumbs = $thumbs ?? 'fhd, one, two, tree, four, five, six, mini';
    if(isset($allowed_ext))
        $allowed_ext = $allowed_ext;
    else
    {
        if($file_type == 'image')
            $allowed_ext = 'jpg, jpeg, png, gif, webp';
        elseif($file_type == 'video')
            $allowed_ext = 'mp4, webm';
        elseif($file_type == 'file')
            $allowed_ext = 'doc, docx, xls, xlsx, pdf';
    }
    $max_file_size = $max_file_size ?? 10

?> 
<div class="form-block my-2 py-1 row d-flex align-items-center">
    <div class="col-sm-12" >
	    <div class="custom-file mb-3 mt-3">
            <input type="file" class="custom-file-input"  name="preview" onchange="ajax_picture_option_save(event, '{{ $name }}');" id="{{ $name }}" data-_token="{{ csrf_token() }}" data-key="{{ $name }}" data-thumbs="{{ $thumbs ?? null }}" data-file_type="{{ $file_type }}" data-allowed_ext="{{ $allowed_ext }}" data-max_file_size="{{  $max_file_size }}">
           <label class="custom-file-label" for="customFile">@lang($title)</label>
        </div>
        <div class="col-12 text-info">
            <b>@lang('Allowed extensions'):</b> <i>{{ $allowed_ext }}</i><br/>
            <b>@lang('Max file size'):</b> <i>{{ $max_file_size }} Mb</i>
        </div>
    <div class="text-center" id="{{ $name }}_result">
        <div class="result-block">

@if($file_type == 'video')
    @if(isset($site_option[$name]))
    <video muted class="wrapper__video" controls="controls" style="width: 250px;">
        <source src="{{ $site_option[$name]['url'] ?? null }}">
    </video> 
    @else
    <img src="{{ url('/images/video-camera.png') }}" style="width: 150px;">
    @endif
@elseif($file_type == 'file')
    @isset($site_option[$name])
    <a href="{{ $site_option[$name]['url'] }}" download>
        <img src="/images/full-folder.png" style="width: 150px;" title="@lang('Download')">
    </a>
    <div class="file-extension">{{ pathinfo($site_option[$name]['url'], PATHINFO_EXTENSION) }}</div>
    @else
    <img src="/images/empty-folder.png" style="width: 150px;">
    @endisset
@elseif($file_type == 'image')
    @isset($site_option[$name])
    <img src="{{ $site_option[$name]['five'] ?? null}}" id="img-{{ $name }}" style="width: 150px;">
    @else
    <img src="{{ url('/storage/images/no-photo.jpg') }}" style="width: 150px;">
    @endisset
@endif
        </div>
    <div class="col-12 text-right">
    	<button class="btn btn-outline-danger btn-sm delete-option-picture @if(!isset($site_option[$name])) d-none @endif" data-key="{{ $name }}" data-file_type="{{ $file_type }}">Удалить</button>
    </div>
  </div>
</div>
</div> 

