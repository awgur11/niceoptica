<style type="text/css">
	#add-to-cart-body{
		width: 100%;
		height: 100vh;
		background: rgba(0, 0, 0, 0.7);
		padding-top: 100px;
		display: none;
		position: fixed;
		z-index: 9999999;
		
		
	}
	#add-to-cart-body.active{
		display: block;
	}
	#add-to-cart-modal{
		background-color: #fff;
		width: 997px;
		max-width: 100%;
		margin: auto;
		max-height: calc(100vh - 100px);

		box-shadow: 0 0 1px rgb(0,0,0);
	}
	.atc-close-button{
		font-size: 30px;
		cursor: pointer;
	}
	.atc-body{
		padding: 48px;
		padding-top: 0;
	}
	.atc-title{
		font-family: Nunito Sans;
        font-size: 32px;
        font-style: normal;
        font-weight: 400;
        line-height: 38px;
        margin-bottom: 50px;
	}
	.atc-preview{
		padding: 15px;
	}
	.atc-preview img{
		max-width: 100%;
	}
@media screen and (max-width: 820px) {
	.atc-body{
		padding: 15px;
	}
	.atc-preview img {
        max-width: 100%;
        width: 200px;
    }
}
@media screen and (max-width: 768px) {
	.atc-preview img {
        max-width: 100%;
        width: 160px;
    }
}
@media screen and (max-width: 580px) {
	.atc-preview img {
        width: 100%;

    }
    #add-to-cart-body{
    	padding-top: 0;
    }
    #add-to-cart-modal{
    	height: 100vh!important;
    	max-height: 100vh;
    	overflow: auto;
    }
}

</style>
<div id="add-to-cart-body">
	<div id="add-to-cart-modal">
		<div class="text-right p-3">
			<div class="atc-close-button">
				<div class="icon-Cross"></div>
			</div>
		</div>
		<div class="atc-body d-none">
		    <div class="atc-title">
			
		    </div>
		    <div class="d-md-flex ">
			    <div class="atc-preview">
				    <img src="" alt="">
			    </div>
			    <div class="atc-price-block">
			        <div class="atc-price-params-block">
				
			        </div>
			        <div id="add-to-cart-block" class="d-md-flex d-block justify-content-between align-items-center mt-3 pt-3" style="border-top: 1px solid #dcdcdc;">
    	                <div id="atc-price-block-no-discount">
    		                <span class="atc-price-value"></span>
    		                <span class="atc-price-currency mr-2">грн</span>
    	                </div>
                        <div id="atc-price-block-with-discount">
        	                <div id="atc-price-block-new-price">
    		                    <span class="atc-new-price-value"></span>
    		                    <span class=".atc-price-currency mr-2">грн</span>
    		                </div>
    		                <div id="atc-price-block-old-price">
    		                    <span class="atc-old-price-value"></span>
    		                    <span class=".atc-price-currency mr-2">грн</span>
    		                </div>
    	                </div>
                    	<div class="text-center text-md-right mt-3 mt-md-0">
    		                <div class="ml-1 btn btn-primary add-to-cart-button" style="width: auto!important;">@lang('Add to cart')</div>
                        </div>
		            </div>
		        </div>
		    </div>
		</div>
		<div class="atc-body-answer d-flex align-items-end">
			<div class="atc-answer-text">
			    @lang('This product was added to the cart')
			</div>
			<div class="atc-answer-buttons-block d-flex justify-content-between">
				<div class="btn btn-outline-primary atc-answer-botton-proceed">
					@lang('Proceed')
				</div>

				<a href="{{ route('cart') }}" class="btn btn-primary atc-answer-button-checkout">
					@lang('Checkout')
				</a>

			</div>
			
		</div>
	</div>
</div>
<style type="text/css">
    .atc-body-answer{
    	height: 450px;
    	padding: 24px;
    	position: relative;
    }
	.atc-answer-text{
		font-family: Nunito Sans;
        font-size: 42px;
        font-style: normal;
        font-weight: 600;
        line-height: 54px;
        letter-spacing: 0px;
        position: absolute;
        left: 50%;
        top: 40%;
        color: #2C50F2;;
        transform: translate(-50%, -50%);
        text-align: center;
        width: 100%;
	}
	.atc-answer-buttons-block{
		bottom: 24px;
		width: 100%;


	}
@media screen and (max-width: 580px) {
	.atc-body-answer{
		padding: 15px;
	}
	.atc-body-answer{
		height: calc(100vh - 60px);
	}
	
}
</style>
<script type="text/javascript">
	$(document).on('click', '.atc-close-button, .atc-answer-botton-proceed', function(){
		$('#add-to-cart-body').removeClass('active');
	});
</script>