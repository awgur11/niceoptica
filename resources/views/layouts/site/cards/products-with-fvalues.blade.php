<style type="text/css">
.pr-block{
	border: 1px solid #fff;
	transition: 0.3s;
}
.pr-block:hover{
	border: 1px solid #5bb3e6;
}
.pr-card{
	padding: 5px;
}
.pr-code{
	font-family: fnormal;
	font-size: 13px;
	color: #666;
}
.pr-code b{
	color: #333;
}
.pr-preview{
	position: relative;
	height: 200px;
	overflow: hidden;
}
.pr-preview img{
	position: absolute;
	max-width: 100%;
	max-height: 100%;
	top: 50%;
	left: 50%;
	transform: translate(-50%, -50%);
}
.pr-title{
	height: 6em;
	overflow: hidden;
}
.pr-title a{
	color: #3481be;
	font-family: fnormal;
}
.pr-fvalues{
	height: 150px;
	overflow: hidden;
}
.pr-fvalues tr td{
	line-height: 1.1em;
	padding: 5px 0;
}
.pr-fvalues tr td:first-child{
	font-size: 13px;
	font-family: fbold;
	color: #333;
}
.pr-fvalues tr td:nth-child(2){
	font-size: 13px;
	font-family: fitalic;
	color: #555;
	padding-left: 5px;
}
.pr-price{
	font-family: fbold;
	font-size: 22px;
}
.pr-card .add-to-favorite-button.was-added{
	background: #5bb3e634;
	//border: none;
}
.pr-available-block{
	text-align: center;
	font-family: fnormal;
	text-transform: uppercase;
	font-size: 12px;
}
.pr-available-available{
	color: #00c521;
}
.pr-available-under-the-order, 
.pr-available-expected, 
.pr-available-on-request{
	color: #3785c1;
}
.pr-available-not-available{
	color: #d33;
}
@media screen and (max-width: 768px){
	.pr-card{
		border: 1px solid #ddd;
		padding: 10px;
	}
	
}
@if(\Request::route()->getName == 'favorites')
.add-to-favorite-button{
		position: absolute;
		color: #d33;
		padding: 5px 10px;
		border-radius: 50%;
		background: #fff;
		border: 1px solid #d33;
		right: -10px;
		top: -10px;
		display: inline-block;
		cursor: pointer;
	}
@endif
	
</style>
@foreach($products as $product)
<div class="col-md-4 col-xl-3  col-6 pr-block p-1 mb-3">
	@if(\Request::route() != null && \Request::route()->getName() == 'favorites')
		<div class="add-to-favorite-button" data-id="{{ $product->id }}">X</div>
	@endif
	<div class="pr-card pb-1">
		<div class="pr-code text-right">
			код товара: <b>{{ $product->id + 10000 }}</b>
		</div>
		<div class="pr-preview">
			<a href="{{ route('product', ['id_catalog' => $product->catalog->id, 'alt_catalog' => $product->catalog->alt_title, 'id' => $product->id, 'alt_title' => $product->alt_title]) }}">
			    <img src="{{ $product->picture->four_preview}}" alt="">
		    </a>
		</div>
		<div class="pr-title">
			<a href="{{ route('product', ['id_catalog' => $product->catalog->id, 'alt_catalog' => $product->catalog->alt_title, 'id' => $product->id, 'alt_title' => $product->alt_title]) }}">
			    {!! $product->language->title !!}
		    </a>
		</div>
		<div class="pr-fvalues mt-3">
			<table> 
	@foreach($product->fvalues->sortBy(function($q){ return $q->filter->position;})->unique()->slice(0, 4) as  $fvalue)
	        <tr>
	        	<td class="pt-1">{{ $fvalue->filter->language->title }}</td>
	        	<td class="pt-1">{{ $fvalue->language->title }}</td>
	        </tr>
	@endforeach
	        </table>
		</div>
		<div class="pr-available-block">
			@if($product->available == 1)
			  <div class="pr-available-available">
			  	@lang('available')
			  </div>
			@elseif($product->available == 2)
			  <div class="pr-available-under-the-order">
			  	@lang('under the order')
			  </div>
			@elseif($product->available == 3)
			  <div class="pr-available-not-available">
			  	@lang('not available')
			  </div>
			@elseif($product->available == 4)
			  <div class="pr-available-expected">
			  	@lang('expected')
			  </div>
			@elseif($product->available == 5)
			  <div class="pr-available-on-request">
			  	@lang('on request')
			  </div>
			@endif
		</div>
		<div class="pr-price my-4">
			{{ $product->final_price }} грн
		</div>
		<div class="pr-buttons-block d-flex justify-content-md-between justify-content-center">
			<div>
		@if($product->available != 3)
			    <button data-toggle="modal" data-target="#cartModal" class="btn btn-danger add-to-cart-button"  data-id="{{ $product->id }}" data-price="{{ $product->final_price }}"><i class="fas fa-cart-plus"></i> @lang('To cart')</button>

		@endif	
	        </div>
	        <div>
			    <button class="d-none d-md-block btn btn-outline-primary @if(in_array($product->id, $favorites_content)) was-added @endif add-to-favorite-button" data-id="{{ $product->id }}" ><i class="far fa-heart"></i></button>
		    </div>
		</div>
		
	</div>
</div>
@endforeach