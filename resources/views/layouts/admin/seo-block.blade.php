@php
$value = $value ?? null;
@endphp
<h3 class="text-center">@lang('СЕО')</h3>

@include('layouts.admin.form.form-input', ['title' => 'Tag заголовок', 'name' => 'tag_title', 'value' => $value])

@include('layouts.admin.form.form-textarea', ['title' => 'Tag описание ', 'name' => 'description', 'value' => $value])