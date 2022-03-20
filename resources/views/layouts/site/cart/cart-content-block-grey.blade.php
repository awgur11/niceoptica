<style type="text/css">
#cart-content-block-grey{
	background: #F8F8F8;
	padding: 40px 32px;
}
.scc-preview{
	width: 96px;
	height: 96px;
	
}
.scc-preview img{
	max-width: 96px;
	height: auto;
	background: #fff;
	border: 1px solid #dcdcdc;
}
.scc-body{
	padding-left: 10px;
}
.scc-title{
	font-family: Nunito Sans;
    font-size: 16px;
    font-style: normal;
    font-weight: 400;
    line-height: 19px;
    letter-spacing: 0px;
    text-align: left;
    color: #202020;
}
.scc-param-title, 
.scc-param-value{
	font-family: Nunito Sans;
    font-size: 14px;
    font-style: normal;
    font-weight: 300;
    line-height: 17px;
}
.scc-param-title{
    color: #898989;
}
.scc-param-value{
	color: #202020;
}
.scc-param{
	padding: 0px;
}
.css-count-price-block{
	font-family: Nunito Sans;
    font-size: 16px;
    font-style: normal;
    font-weight: 700;
    line-height: 19px;
    color: #202020;
}
@media screen and (max-width: 580px) {
	#cart-content-block-grey{
		padding: 22px 15px;
	}
	
}
	
</style>
<div id="cart-content-block-grey" class="mb-3">
				<div class="d-flex justify-content-between align-items-center mb-3">
					<h4>@lang('Your order')</h4>
				@if(url()->current() != route('cart'))
					<a href="{{ route('cart') }}" class="d-block"><i class="icon-Pencil"></i> @lang('Edit order')</a>
				@endif
				</div>
				<div id="shot-content-cart">
					
				</div>
				<div class="my-2">
					<table class="table mt-4" id="cp-total-table">
	    			<tr>
	    				<td>@lang('Productss'):</td>
	    				<td id="cp-total-products-count">0</td>
	    			</tr>
	    			<tr>
	    				<td>@lang('For the amount'):</td>
	    				<td id="cp-total-products-amount">0</td>
	    			</tr>
	    			<tr>
	    				<td>@lang('Member discount'):</td>
	    				<td id="cp-member-discount">0</td>
	    			</tr>
	    			<tr>
	    				<td class="pt-3"><b>@lang('Total'):</b></td>
	    				<td class="pt-3" id="cp-total-with-member-discount">0</td>
	    			</tr>
	    		</table>
				</div>
			</div>
@if(url()->current() != route('cart'))
<script type="text/javascript">
function cart_content(response)
{
       
                total = 0;
                total_count = 0
                $('#cart-page-content-block').html('');
                response.cart_arr.forEach(function(item, index){
                    total += item.count*item.price;
                    total_count += Number(item.count);
                    console.log(item)

                    $('#shot-content-cart').append('\
                    	<div class="scc-block row mx-0 mb-3">\
						<div class="scc-preview col-4 col-md-2 col-lg-3 px-0">\
							<img src="' + item.product.picture.four_preview + '" alt="">\
						</div>\
						<div class="scc-body col-8">\
							<div class="scc-title">' + item.product.language.title + '</div>\
							<div class="scc-block-params row m-0">\
							' + item.params_shot + '\
							</div>\
							<div class="css-count-price-block mt-3">\
							    ' + item.count + ' шт | ' + item.price + ' грн\
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
                    $('.cart-link-count').addClass('d-none');
                else
                    $('.cart-link-count').removeClass('d-none');
          
    } 
    $(function(){
		cart_content({!! $cart_content !!});
	});
</script>
@endif