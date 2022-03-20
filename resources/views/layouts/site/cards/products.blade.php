<style type="text/css">

</style>
@foreach($items as $product)
<div class="col-xl-4 col-lg-4 col-md-6 product-block p-0 product-catalog-id-{{ $product->catalog_id }}"  id="product-block-{{ $product->id }}" >
@if($product->promo == 1)
	<div class="promo-flag">
		@lang('TOP sales')
	</div>
@endif
@if($product->discount != 0)
	<div class="sale-flag">
		@lang('Sale')
	</div>
@endif
@if(\Request::route() != null && \Request::route()->getName() != 'product')
    <button data-toggle="modal" class="btn btn-primary show-cart-modal-button"  data-id="{{ $product->id }}" data-price="{{ $product->final_price }}"> @lang('Add to cart')</button>
@endif
	<div class="product-card">
		<div class="add-to-favorite-button atfb @if(in_array($product->id, $favorites_content)) active @endif" data-id="{{ $product->id }}"> <i class="@if(in_array($product->id, $favorites_content)) ri-heart-fill @else ri-heart-line @endif"></i></div>

		<div class="add-to-compare-button atcb @if(in_array($product->id, $compare_content)) active @endif" data-id="{{ $product->id }}"><i class="icon-Pillow-Chart---1"></i> </div>

		<a href="{{ route('product', ['id_catalog' => $product->catalog_id, 'alt_catalog' => $product->catalog->alt_title, 'id' => $product->id, 'alt_title' => $product->alt_title]) }}" class="product-title">
			{!! $product->language->title !!}
		</a>
		<a href="{{ route('product', ['id_catalog' => $product->catalog_id, 'alt_catalog' => $product->catalog->alt_title, 'id' => $product->id, 'alt_title' => $product->alt_title]) }}" class="product-preview">
			<img src="{{ $product->picture->tree_preview }}" alt="">
		</a> 
		<div class="product-price-block row">
		@if($product->discount == 0)
			<div class="product-price col-7">
				{{ $product->final_price }} грн
			</div>
		@else
		    <div class="product-new-price col-3">
				{{ $product->final_price }} грн
			</div>
			<div class="product-old-price col-3">
				{{ $product->price }} грн
			</div>
		@endif

		</div>
	</div>	
</div>
@endforeach
<script type="text/javascript">

</script>