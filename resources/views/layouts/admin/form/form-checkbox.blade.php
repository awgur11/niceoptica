<?php

$default = $default ?? false;

$input_value = $input_value ?? 1;

if($value != null)
{
    $checked = $input_value == $value->{$name} ? 'checked' : '';
}
else
   $checked = $default ? 'checked' : '';



?>
<div class="form-block row my-2">
    <div class="col-12 p-3 pl-5">
    	<label class="form-check-label">
            <input type="checkbox" class="form-check-input" value="{{ $input_value }}" name="{{ $name }}" id="{{ $name }}" {{ $checked }}>
            @lang($title)
        </label>
    </div>
</div>