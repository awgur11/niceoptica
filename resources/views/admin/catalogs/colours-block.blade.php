@if(isset($colours) && $colours->count() > 0)
<h3 class="text-center">@lang('Select catalog`s colours')</h3>
<div class="col-sm-12 form-block">
@foreach($colours as $colour)
    <div class="form-check-inline">
        <label class="form-check-label">
            <input type="checkbox" class="form-check-input" name="colours[]" value="{{ $colour->id }}" @if(isset($catalog) && $catalog->colours()->find($colour->id) != null) checked @endif>{{ $colour->title }}
        </label>
    </div>
@endforeach
</div>
@endif