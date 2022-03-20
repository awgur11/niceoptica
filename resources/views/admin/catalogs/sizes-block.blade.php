@if(isset($sizes) && $sizes->count() > 0)
<h3 class="text-center">@lang('Select catalog`s sizes')</h3>
<div class="col-sm-12 form-block">
@foreach($sizes as $size)
    <div class="form-check-inline">
        <label class="form-check-label">
            <input type="checkbox" class="form-check-input" name="sizes[]" value="{{ $size->id }}" @if(isset($catalog) && $catalog->sizes()->find($size->id) != null) checked @endif>{{ $size->title }}
        </label>
    </div>
@endforeach
</div>
@endif