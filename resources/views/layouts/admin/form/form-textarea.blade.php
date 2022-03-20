<?php

$editor = $editor ?? null;
$languages = isset($languages) ? false : true;
$rows = $rows ?? 5;
$value = $value ?? null;
$info = isset($info) ? '<p class="text-info px-3">'.$info.'</p>' : NULL;

foreach($site_languages as $k => $sl)
{
    $input_value[$k] = ($value != null && $value->languages->where('language', $sl->locale)->first() != null) ? $value->languages->where('language', $sl->locale)->first()->{$name} : '';
    $input_value[$k] = old('languages.'.$k.'.'.$name) ?? $input_value[$k];
}

?>

<div class="form-block row my-2">
@foreach($site_languages as $k => $sl)
    <div class="form-group col-12" >
        <label for="languages-{{ $name }}-{{ $sl->locale }}" >@lang($title) @if($site_languages->count() > 1)({{$sl->shot }}) @endif:</label>
        <textarea  class="form-control languages-{{ $name }}" data-locale="{{ $sl->locale }}" id="languages-{{ $name }}-{{ $sl->locale }}" name="languages[{{ $loop->index }}][{{ $name }}]" {{ $required ?? null }} rows="{{ $rows }}">{{ $input_value[$k] ?? null }}</textarea>
    </div>
@if($editor == 'ckeditor')
<script>
    var editor = CKEDITOR.replace('languages-{{ $name }}-{{ $sl->locale }}', {
        filebrowserBrowseUrl : '/elfinder/ckeditor'  
                });
</script>
@elseif($editor == 'tinymce') 
<script>
    tinymce.init({ selector:'#languages-{{ $name }}-{{ $sl->locale }}',toolbar: 'codesample | bold italic sizeselect fontselect fontsizeselect | hr alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | insertfile undo redo | forecolor backcolor emoticons | code', plugins:["lists", "link"],font_size_style_values: "12px,13px,14px,16px,18px,20px", menubar: false});
</script>
@endif
@endforeach
@if($site_languages->count() > 1 && $languages && $editor == null)
        <div class="py-2 col-12 text-center">
            <button type="button" class="btn btn-sm btn-outline-info make-translation-button" data-name="{{ $name }}" data-locale="{{ App::getLocale() }}">Перевести </button>
        </div>
@endif
    {!! $info !!}
</div>