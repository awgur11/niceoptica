@extends('site.base')

@section('content')

<div class="container-fluid" >
	<div class="row mb-3">
		<div class="col-12" style="overflow: hidden;">
			@include('layouts.site.path-block')
		</div>
	</div>
	<div class="row">
		<div class="col-12">
			<h1 class="catalog-title">@lang('Cart')</h1>
		</div>
	</div>
<style type="text/css">
	.cp-block{
		background: #FFFFFF;
        border: 1px solid #DCDCDC;
        margin-bottom: 15px;
	}
	.cp-block-preview{
		height: 178px;
		width: 178px;
		padding: 15px;
		
	}
	.cp-block-preview img{
		width: 100%;
	}
	.cp-block-body{
		padding: 15px;
		border-left: 1px solid #DCDCDC;
	}
	.cp-title{
		font-family: Nunito Sans;
        font-size: 24px;
        font-style: normal;
        font-weight: 400;
        line-height: 29px;
        margin-bottom: 7px;
	}
	.cp-param{
		margin-right: 24px;
		font-family: Nunito Sans;
        font-size: 14px;
        font-style: normal;
        font-weight: 300;
        line-height: 17px;
	}
	.cp-param-title{
		color: #898989;
	}
	.cp-param-value{
		color: #202020;
	}
	.cp-block-price{
		margin-top: 31px;

	}
	.cp-block-price-title{
		font-family: Nunito Sans;
        font-size: 14px;
        font-style: normal;
        font-weight: 300;
        line-height: 17px;
        color: #898989;
        margin-bottom: 12px;
	}
	.cpb-new-price{
		font-family: Nunito Sans;
        font-size: 20px;
        font-style: normal;
        font-weight: 600;
        line-height: 24px;
        color: #62D5BC;
	}
	.cpb-old-price{
		font-family: Nunito Sans;
        font-size: 16px;
        font-style: normal;
        font-weight: 300;
        line-height: 19px;
        text-decoration: line-through;
	}
	.cp-block-count-button{
		width: 32px;
		height: 32px;
		font-size: 18px;
		text-align: center;
		padding: 3px;
		color: #202020;
		border: 1px solid #dcdcdc;
		border-radius: 0;

	}
	.cp-block-count-value{
		font-family: Nunito Sans;
        font-size: 20px;
        font-style: normal;
        font-weight: 300;
        line-height: 24px;
        padding: 4px 16px ;
	}
	.cp-sum-value,
	.cpb-no-discount-price{
		font-family: Nunito Sans;
        font-size: 20px;
        font-style: normal;
        font-weight: 600;
        line-height: 24px;
        color: #202020;
	}
	.cp-trash-button{
		color: #898989;
		cursor: pointer;
		font-size: 25px;
	}
	.cp-trash-button:hover{
		color: #d33;;
	}
@media screen and (max-width: 580px) {
	.cp-block-body{
		padding: 15px;
		border-left: none;
	}
	.cp-block-preview{
		height: 50px;
		width: 50px;
		padding: 5px;
		border-right: 1px solid #DCDCDC;
		border-bottom: 1px solid #DCDCDC;
	}
}
</style>
<style type="text/css">

</style>
	<div class="row">
		<div class="col-xl-8" id="cart-page-content-block">
			
	    </div>
	    <div class="col-xl-4 pl-lg-0">
	    	@include('layouts.site.cart.cart-content-block-grey')	
	        @auth 
				<a href="{{ route('cart.checkout') }}" class="btn btn-primary btn-block atc-answer-button-checkout">
					@lang('Checkout')
				</a>
			@else
			    <a href="{{ route('cart.auth') }}" class="btn btn-primary btn-block atc-answer-button-checkout">
					@lang('Checkout')
				</a>
			@endif	
	    </div> 
	</div>
</div>
<script type="text/javascript">
	 function cart_content(response)
    {
                total = 0;
                total_count = 0
                $('#cart-page-content-block').html('');
                response.cart_arr.forEach(function(item, index){
                    total += item.count*item.price;
                    total_count += Number(item.count);
 

                    $('#cart-page-content-block').append('\
                        <div class="cp-block d-flex" id="cp-block-' + index + '">\
				<div class="cp-block-preview">\
					<img src="' + item.product.picture.four_preview + '" <="" div="">\
				</div>\
				<div class="cp-block-body col">\
					<div class="cp-title"> ' + item.product.language.title + ' </div>\
					<div class="cp-block-params d-md-flex">' + item.params + '</div>\
					<div class="cp-block-price d-md-flex justify-content-between">\
						<div class="cp-block-price-first ">\
							<div class="cp-block-price-title mb-md-3">@lang('Price')</div>\
							<div class="cp-block-price-value d-flex">' + item.price_prepare + '</div>\
						</div>\
						<div class="cp-block-price-second mt-3 mt-md-0">\
							<div class="cp-block-price-title">@lang('Count')</div>\
							<div class="cp-block-counter d-flex">\
								<div class="cp-block-count-button btn btn-outline-dark btn-sm  change-count-in-cart" data-id="' + item.product.id + '" data-index="' + index + '" data-change="-1"><span class="icon-Remove"></span></div>\
								<div class="cp-block-count-value">' + item.count + '</div>\
								<div class="cp-block-count-button btn btn-outline-dark btn-sm change-count-in-cart" data-id="' + item.product.id + '" data-index="' + index + '" data-change="1"><span class="icon-Add"></span></div>\
							</div>\
						</div>\
						<div class="cp-block-price-third  mt-3 mt-md-0">\
							<div class="cp-block-price-title mb-md-3">@lang('Sum')</div>\
							<div class="cp-sum-value">' + item.sum + ' грн</div>\
						</div>\
					</div>\
				</div>\
				<div class="cp-block-trash pl-md-5 pl-1 pr-0 text-right">\
					<div class="cp-trash-button btn delete-from-cart" data-index="' + index + '">\
						<i class="icon-Trash"></i>\
					</div>\
				</div>\
			</div>\
                    ');
                }); 

                $('#cart-page-content-table tfoot').append('\
                        <tr class="cart-foot">\
                            <td></td>\
                            <td class="text-right" colspan="2">Итого: <b>' + total + '</b> грн</td>\
                        </tr>\
                    ');
                $('#cart-link-count').html(total_count);

                if(cart_content.length == 0)
                {

                    $('#cart-full-container').addClass('d-none');
                    $('#cart-empty-container').removeClass('d-none');
                }
                else
                {
                    $('#cart-full-container').removeClass('d-none');
                    $('#cart-empty-container').addClass('d-none');
                }

                $('#cp-total-products-count').text(total_count);
                $('#cp-total-products-amount').text(total + ' грн');

                $('#cp-member-discount').text(Math.round(-total*(response.member_discount/100)) + ' грн')

                $('#cp-total-with-member-discount').text(total + Math.round(-total*(response.member_discount/100)) + ' грн')

                if(total_count == 0)
                {
                    $('.cart-link-count').addClass('d-none');
                    $('.atc-answer-button-checkout').addClass('d-none');
                }
                else
                    $('.cart-link-count').removeClass('d-none');
          
    } 
    $(function(){
		cart_content({!! $cart_content !!});
	});
</script>





@endsection