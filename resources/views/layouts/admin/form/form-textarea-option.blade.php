<?php

$editor = $editor ?? null;
$languages = isset($languages) ? false : true;
$rows = $rows ?? 5;
$value = $value ?? null;

$radio_place = [
       ['value' => 1, 'title' => 'для всего сайта'],
       ['value' => 2, 'title' => 'для главной страницы'],
       ['value' => 3, 'title' => 'для отдельных страниц']
   ];

?>
<form action="javascript:void(null);" onsubmit="option_update('{{ $name }}')" id="{{ $name }}" class="form-horizontal">
    <input type="hidden" name="key" value="{{ $name }}">
<div class="form-block row my-2">
@if(!$languages)
<div class="form-group col-12" >
    <label for="languages-{{ $name }}" >@lang($title) :</label>
    <input type="hidden" name="type" value="nol">
    <textarea  class="form-control languages-{{ $name }} my-2"  id="languages-{{ $name }}" name="value" {{ $required ?? null }} rows="{{ $rows }}">{{ $site_option[$name]['value'] ?? null }}</textarea>
</div>
@else
@foreach($site_languages as $k => $sl)
    <input type="hidden" name="languages[{{ $loop->index }}][language]" value="{{ $sl->locale }}">
    <div class="form-group col-12" >
        <label for="languages-{{ $name }}-{{ $sl->locale }}" >@lang($title) @if($site_languages->count() > 1)({{$sl->shot }}) @endif:</label>
        <textarea  class="form-control languages-{{ $name }}" data-locale="{{ $sl->locale }}" id="languages-{{ $name }}-{{ $sl->locale }}" name="languages[{{ $loop->index }}][value]" {{ $required ?? null }} rows="{{ $rows }}">{{ $site_option[$name]['text'][$sl->locale] ?? null }}</textarea>
    </div>
@if($editor == 'ckeditor')
<script>
    var editor = CKEDITOR.replace('languages-{{ $name }}-{{ $sl->locale }}', {
        filebrowserBrowseUrl : '/elfinder/ckeditor'  
                });
</script> 
<div class="ckeditor-block" data-ckeditor="languages-{{ $name }}-{{ $sl->locale }}"></div>
@elseif($editor == 'tinymce') 
<script>
    tinymce.init({ 
        selector:'#languages-{{ $name }}-{{ $sl->locale }}',
        toolbar: 'codesample | bold italic sizeselect fontselect fontsizeselect | hr alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | insertfile undo redo | forecolor backcolor emoticons | code', 
        plugins:["lists", "link"],
        font_size_style_values: "12px,13px,14px,16px,18px,20px", 
        menubar: false,
        setup: function (editor) {
            editor.on('change', function () {
                editor.save();
            });
        }
    });
</script>
<div class="tinymce-block" data-tinymce="languages-{{ $name }}-{{ $sl->locale }}"></div>
@endif
@endforeach
@endif

@if($site_languages->count() > 1 && $languages && $editor == null)
        <div class="py-2 col-12 text-center">
            <button type="button" class="btn btn-sm btn-outline-info make-translation-button" data-name="{{ $name }}" data-locale="{{ App::getLocale() }}">Перевести </button>
        </div>
@endif

    <div class="col-12">
    <div class="row justify-content-end">
@if(auth()->id() == 1)
    @foreach($radio_place as $radio)
        <div class="form-check col-3 d-flex align-items-center">
            <label class="form-check-label">
                <input type="radio" name="place" class="change-radio-ajax" data-key="{{ $name }}" data-table="option" data-id="{{ $site_option[$name]['id'] ?? null }}" data-column="place" data-value="{{ $radio['value'] }}" value="{{ $radio['value'] }}" @if(isset($site_option[$name]['place']) && $site_option[$name]['place'] == $radio['value']) checked @endif> {{ $radio['title'] }}
            </label>
        </div>
    @endforeach
@endif
        
    </div>
    <div class="row justify-content-end mt-2 pb-2">
        <div class="col-3 text-right">
            <button class="btn btn-primary">Сохранить</button>
        </div>
    </div>
    </div>

</div>
</form>