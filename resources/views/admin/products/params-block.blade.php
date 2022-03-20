
@if($catalog->languages[0]->params != [''])
<div class="row form-block">
    <div class="col-12">
        <h3 class="text-center">Параметры</h3>
    </div>
@foreach($site_languages as $k => $lang)
    @if($loop->index > 0)
    <div class="col-12">
        {{ $lang->title }}
    </div>
    <hr/>
    @endif
    @foreach($catalog->languages[$k]->params as $param)
    <div class="col-3 pt-3 text-right">{{ $param }}:</div>
    <div class="col-9 py-1">
        <div class="form-froup">
            <input type="text" class="form-control" name="languages[{{ $k }}][params][{{ $param }}]" value="{{ $value->languages[$k]->params[$param] ?? null }}">
        </div>
    </div>
    @endforeach
@endforeach
</div>
@endif