@php

$label_width = $label_width ?? 5;


@endphp
@php
   $required = isset($required) ? 'required' : NULL;
@endphp
<div class="form-block @if($errors->has($name))) has-error @endif">
    <div class="form-group">
        <label for="{{ $name }}" class="col-sm-{{ $label_width }} col-form-label text-right" style="padding-top: 5px;">@lang($title):</label>
        <div class="col-sm-{{ 12 - $label_width }}">
            <input type="file" name="{{ $name }}" class="form-control @if($errors->has($name)) is-invalid @endif" id="{{ $name }}" {{ $required }}>
    @if($errors->has($name))
            <span class="invalid-feedback text-danger" role="alert">
                <strong>{{ $errors->first($name) }}</strong>
            </span>
    @endif
        </div>
    </div>
@isset($value->{$name})
    <div class="form-group text-center">
        <img src="{{ asset('storage/images'.$value->{$name}) }}" style="max-width: 350px; margin-top: 10px; border-radius: 5px; box-shadow: 0 0 25px rgba(0,0,0,.4);">
    </div>
    @if($value->{$name} != null)
    <div class="checkbox">
        <label><input type="checkbox" name="delete_picture" value="1">Удалить</label>
    </div>
    @endif
@endisset
</div>