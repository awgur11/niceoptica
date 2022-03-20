@php
   $type = $type ?? 'text';
   $required = isset($required) ? 'required' : NULL;
   $maxlength = $maxlength ?? 255;
   $data = $data ?? NULL;
   $languages = $languages ?? true;
   $label_width = $label_width ?? 2;
   $input_width = $input_width ?? 10;

   $radio_place = [
       ['value' => 1, 'title' => 'для всего сайта'],
       ['value' => 2, 'title' => 'для главной страницы'],
       ['value' => 3, 'title' => 'для отдельных страниц']
   ];

@endphp 

<form action="javascript:void(null);" onsubmit="option_update('{{ $name }}')" id="{{ $name }}" class="form-horizontal">

    <input type="hidden" name="key" value="{{ $name }}">
<div class="form-block my-2 py-1 row d-flex align-items-center">
    <div class="col-sm-{{ $label_width }} p-3">
        <label for="{{ $name }}" class="text-right">{{ $title }}:</label><br/>
@if($site_languages->count() > 1 && $languages)
        <div class="mt-3 text-center">
            <button type="button" class="btn btn-sm btn-outline-info make-translation-button" data-name="{{ $name }}" data-locale="{{ App::getLocale() }}">Перевести </button>
        </div>
@endif
    </div>

    <div class="col-sm-{{ $input_width }}">
        <span class="text-info">{{ $note ?? null }}</span>
@if(!$languages)
       <input type="hidden" name="type" value="nol">
       <input type="{{ $type }}" class="form-control " id="{{ $name }}"  name="value" {{ $required }}  maxlength="{{ $maxlength }}" {{ $data }} value="{{ $site_option[$name]['value'] ?? null }}">
@else 
    @foreach($site_languages as $sl)
        <input type="hidden" name="languages[{{ $loop->index }}][language]" value="{{ $sl->locale }}">
        <div class="input-group my-3" style="">
        @if($site_languages->count() > 1)
            <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon1">{{ $sl->shot }}:</span>
            </div>
        @endif
            <input type="{{ $type }}" class="form-control languages-{{ $name }}" data-locale="{{ $sl->locale }}" id="languages-{{ $name }}-{{ $sl->locale }}" {{ $required }} name="languages[{{ $loop->index }}][value]" placeholder="{{ $sl->title }}" maxlength="{{ $maxlength }}" {{ $data }} value="{{ $site_option[$name]['text'][$sl->locale] ?? null }}">
                
        </div>
    @endforeach       
@endif
    </div>
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

