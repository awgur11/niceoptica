<?php
    
    $value = $value ?? null;

    $array = $array ?? false;
    $name = $name ?? 'preview';
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


?>

<div class="form-block row my-2">
	<div class="col-md-4 col-lg-3 text-center py-2" style="">
        <input type="hidden" name="file_type" value="{{ $file_type }}">
        <input type="hidden" name="thumbs" value="{{ $thumbs }}">
        <input type="hidden" name="allowed_ext" value="{{ $allowed_ext }}">


    @if($file_type == 'image')
        <div class="image-templet">
        @if($value != null && $value->preview_path != null)
            <img src="{{ asset($value->five_preview) }}" class="img-thumbnail">
        @else
            <img src="{{ asset('storage/images/no-photo.jpg') }}" class="img-thumbnail">
        @endif  
        </div>     
    @elseif($file_type == 'video')
        <div class="video-templet">
        @if($value != null && $value->preview_path != null)
            <video muted class="wrapper__video" controls="controls" style="width: 250px;">
                <source src="{{ '/storage/videos'.$value->preview_path.$value->preview_name }}">
            </video>
        @else
            <img src="/images/video-camera.png" style="width: 150px;">
        @endif
        </div>
    @elseif($file_type == 'file')
        <div class="file-templet">
        @if($value != null && $value->preview_path != null)
            <img src="/images/full-folder.png" style="width: 150px;">
            <div class="file-extension">{{ pathinfo($value->origin_preview, PATHINFO_EXTENSION) }}</div>
        @else
            <img src="/images/empty-folder.png" style="width: 150px;">
        @endif
        </div>
    @endif
@if($value != null)
        <input type="hidden" name="old_path" value="{{ $value->preview_path }}">
        <input type="hidden" name="old_name" value="{{ $value->preview_name }}">
@else

        <input type="hidden" id="old_path" name="old_path" value="">
        <input type="hidden" id="old_name" name="old_name" value="">
@endif
	</div>
	<div class="col-lg-9 col-md-8 th">
		<div class="custom-file mb-3 mt-3">
            <input type="file" class="custom-file-input" id="customFile" name="{{ $name }}">
            <label class="custom-file-label" for="customFile">@lang('Select file on Your computer')</label>
        </div>
    @error($name)
        <div class="alert alert-danger mt-1">
            {{ $message }}
        </div>
    @enderror

        <div class="form-group">
            <input type="text" class="form-control" id="{{ $name }}_link" name="{{ $name }}_link" placeholder="@lang('Or paste the link')"  >
            <small class="form-text text-muted">@lang('Some images are protected from downloading')</small>
            <p class="text-info">@lang('Allowed extensions') : <b>{{ $allowed_ext }}</b></p>
        </div>
        <div class="form-check @if(!isset($value->{$name.'_path'})) d-none @endif" id="delete-picture-checkbox-block">
            <input type="checkbox" class="form-check-input" id="delete_picture" name="delete_picture" value="1">
            <label class="form-check-label" for="delete_picture">@lang('Delete')</label>
        </div>
	</div>
</div>