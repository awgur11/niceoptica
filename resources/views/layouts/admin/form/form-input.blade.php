<?php

$type = $input_type ?? 'text';
$languages = $languages ?? true;
$required = $required ?? null;
$data = $data ?? null;
$maxlength = $maxlength ?? 255;
$label_width = $label_width ?? 2;
$input_width = $input_width ?? 12 - $label_width;
$value = $value ?? null;

if(!$languages)
{
    $input_value = $value != null ? $value->{$name} : '';
    $input_value = old($name) ?? $input_value;
}
else
{
    foreach($site_languages as $k => $sl)
    {
        $input_value[$k] = ($value != null && $value->languages->where('language', $sl->locale)->first() != null) ? $value->languages->where('language', $sl->locale)->first()->{$name} : '';
        $input_value[$k] = old('languages.'.$k.'.'.$name) ?? $input_value[$k];
    }

}


?>

<div class="form-block my-2 row d-flex align-items-center">
    <div class="col-sm-{{ $label_width }} p-3">
        <label for="{{ $name }}" class="text-right">{{ $title }}:</label><br/>
@if($site_languages->count() > 1 && $languages)
        <div class="mt-3 text-center">
            <button type="button" class="btn btn-sm btn-outline-info make-translation-button" data-name="{{ $name }}" data-locale="{{ App::getLocale() }}">Перевести </button>
        </div>
@endif
    </div>

    <div class="col-sm-{{ $input_width }}">
@if(!$languages)
       <input type="{{ $type }}" class="form-control " id="{{ $name }}" name="{{ $name }}" {{ $required }}  value="{{ $input_value }}" maxlength="{{ $maxlength }}" {{ $data }} >
    @error($name)
       <div class="alert alert-danger mt-1">
            {!! str_replace(str_replace('_', ' ', $name), '<b>"'.$title.'"</b>', $message) !!}
        </div>
    @enderror
@else 
    @foreach($site_languages as $sl)
        <div class="input-group my-3" style="">
        @if($site_languages->count() > 1)
            <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon1">{{ $sl->shot }}:</span>
            </div>
        @endif
            <input type="{{ $type }}" class="form-control languages-{{ $name }}" data-locale="{{ $sl->locale }}" id="languages-{{ $name }}-{{ $sl->locale }}" {{ $required }} name="languages[{{ $loop->index }}][{{ $name }}]" @if($site_languages->count() > 1) placeholder="{{ $sl->title }}" @endif maxlength="{{ $maxlength }}" {{ $data }} value="{{ $input_value[$loop->index] }}">
                
        </div>
        @error('languages.'.$loop->index.'.'.$name)
            <div class="alert alert-danger mt-1">
                {!! str_replace('languages.'.$loop->index.'.'.str_replace('_', ' ', $name), '<b>"'.$title.' ('.$sl->locale.')"</b>', $message) !!}
            </div>
        @enderror
    @endforeach       
@endif
    </div>
</div>
