<?php

$onsubmit = isset($onsubmit) ? 'onsubmit="'.$onsubmit.'"' : null;
$action = isset($action) ? 'action='.$action : null;
$data = $data ?? null; 





?>
<form method="{{ $method ?? 'POST'}}" {{ $action ?? null }} enctype="multipart/form-data" {!! $onsubmit !!} {!! $data ?? null !!} id="{{ $id ?? null }}">
    @csrf
@foreach($site_languages as $k => $sl)
<input type="hidden" name="languages[{{ $loop->index }}][language]" value="{{ $sl->locale }}">
@endforeach 
