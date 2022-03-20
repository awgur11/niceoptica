<style type="text/css">
    #price-block{

    	min-height: 100%;
    	padding: 48px;
    	background: #f8f8f8;
    	border-top: 1px solid #DCDCDC;
    	border-right: 1px solid #DCDCDC;
    	border-bottom: 1px solid #DCDCDC;
    }
    #price-block-title{
    	font-family: Nunito Sans;
        font-size: 28px;
        font-style: normal;
        font-weight: 400;
        line-height: 34px;
        width: 425px;
        max-width: 75%;
    }
    #price-block-stars{
    	letter-spacing: 4px;
    	color: #FFD02C;
    }
    #price-params-blocks{
    	min-height: 269px;
    }
    .product-params-row-title{
    	font-family: Nunito Sans;
        font-size: 14px;
        font-style: normal;
        font-weight: 600;
        line-height: 17px;
        color: #202020;
        height: 34px;
        width: 49px;
        padding-top: 20px;
    }
@media screen and (max-width: 1360px) {
	#price-block{
		padding: 24px;
	}
	#price-block-title{
		font-size: 18px;
		max-width: 70%;
	}
	#price-block-stars{
    	letter-spacing: 3px;
    	font-size: 12px;
    }
}
@media screen and (max-width: 768px) {
	#price-block-stars{
    	letter-spacing: 2px;
    	font-size: 10px;
    }
    #price-block{
    	min-height: 364px;
    }
}
@media screen and (max-width: 580px) {
	.product-params-row-title{
		width: 100%;
		margin-bottom: 15px;
		font-size: 20px;
		background-color: #F1F4FF;
		padding: 10px 0;
	}

}
	
</style>
<div id="price-block">
	<div id="price-block-footer" class="d-flex justify-content-between">
		<div id="price-block-title">
			{{ $product->language->title }}
		</div>
		<div id="price-block-stars" class="text-right">
	@for($i=0; $i<5; $i++)
		@if($i <= $product->comments()->pluck('stars')->avg())
			<i class="fas fa-star"></i>
		@else
			<i class="far fa-star"></i>
		@endif
	@endfor
		</div>		
	</div>
<script type="text/javascript">
//заполнение ценовых блоков и расчёт суммы при загрузке
	$(function(){
		createAllData();
		calculateSum();
	});

	
</script>

@include('layouts.site.product.price-params-block')

    <div id="add-to-cart-block" class="d-md-flex d-block justify-content-between align-items-center">
    @if($product->discount == 0)
    	<div id="atc-price-block-no-discount">
    		<span class="atc-price-value">{{ $product->final_price }}</span>
    		<span class="atc-price-currency mr-2">грн</span>
    	</div>
    @else
        <div id="atc-price-block-with-discount">
        	<div id="atc-price-block-new-price">
    		    <span class="atc-new-price-value">{{ $product->final_price }}</span>
    		    <span class=".atc-price-currency mr-2">грн</span>
    		</div>
    		<div id="atc-price-block-old-price">
    		    <span class="atc-old-price-value">{{ $product->price }}</span>
    		    <span class=".atc-price-currency mr-2">грн</span>
    		</div>
    	</div>
    @endif
    	<div class="d-flex">
    		@include('layouts.site.product.buy-one-click')
    		<div class="ml-1 btn btn-primary add-to-cart-button">@lang('Buy')</div>
    	</div>
    </div>
</div>
<style type="text/css">


</style>
<!-- COUNT BLOCK --->
<script type="text/javascript">

</script>
