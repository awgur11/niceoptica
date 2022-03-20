@php

    $required = isset($required) ? 'required' : null;
    $label_width = $label_width ?? 2;
    $default_title = $default_title ?? 'not chosen';

@endphp
<script type="text/javascript">
    $(document).on('change', '.custom-select', function(){
        console.log($(this).val());
    });
</script>
 
<div class="form-block my-2 py-3 row d-flex align-items-center">
 
    <div class="input-group">
        <div class="input-group-prepend">
            <label class="input-group-text" for="inputGroup{{ $name }}">@lang($title)</label>
        </div>
        <select class="custom-select" id="inputGroup{{ $name }}" name="{{ $name }}" {{ $required ?? null }}>
            <option value="{{ $default_value ?? 0 }}">@lang($default_title)</option>
@foreach($option as $op)
            <option value="{{ $op->id }}" @if(isset($value) && $value->{$name} == $op->id) selected @endif>{{ $op->language->title }}</option>
@endforeach
        </select>
    </div>
</div>

