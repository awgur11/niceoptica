@if(isset($catalog) && $catalog->colours()->count() > 0)
<h3 class="text-center">@lang('Set product`s colours')</h3>
<div class="col-sm-12 form-block" id="colours-block">
@foreach($catalog->colours as $colour)
    <div class="form-check-inline">
        <label class="form-check-label">
            <input type="checkbox" class="form-check-input" name="colours[]" value="{{ $colour->id }}" @if(isset($product) && $product->colours()->find($colour->id) != null) checked @endif data-title="{{ $colour->title }}">{{ $colour->title }}
        </label>
    </div>
@endforeach
</div>
@endif