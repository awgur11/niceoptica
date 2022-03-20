<style type="text/css">
	.delivery-block-item{
		background: #F8F8F8;
		padding: 40px 30px;
	}
	h3.block-title{
		font-family: Nunito Sans;
        font-size: 24px;
        font-style: normal;
        font-weight: 400;
        line-height: 29px;
        margin-bottom: 14px;
	}
	div.del-name{
		font-family: Nunito Sans;
        font-size: 16px;
        font-style: normal;
        font-weight: 300;
        line-height: 19px;
        color: #898989;
        padding-right: 20px;
  	}
  	div.del-value{
  		font-family: Nunito Sans;
        font-size: 16px;
        font-style: normal;
        font-weight: 600;
        line-height: 19px;
        color: #202020;
  	}
  	.del-delete-button{
  		color: #202020;
  		transition: 0.3s;
  		cursor: pointer;
  	}
  	.del-delete-button i{
  		font-size: 24px;
  	}
  	.del-delete-button:hover{
  		color: #d33;
  	}
</style>
@foreach($deliveries as $delivery)
<div class="row  delivery-block-item mb-3" id="item-{{ $delivery->id }}">
		<div class="col-lg-8">
			<h3 class="block-title">@lang('Delivery address')</h3>
		<div class="row">
			<div class="del-item p-3 d-flex col-md-6">
                <div class="del-name">@lang('Delivery method'):</div>
	        	<div class="del-value">{{ $delivery->option }}</div>
	        </div>
	@if($delivery->option == __('Pickup'))
	        <div class="del-item p-3 d-flex col-md-6">
	        	<div class="del-name">@lang('Address'):</div>
	        	<div class="del-value">{{ $site_option['address'] ?? null }}</div>
	        </div>
	@endif
	@if($delivery->city != null)
	        <div class="del-item p-3 d-flex col-md-6">
	        	<div class="del-name">@lang('City'):</div>
	        	<div class="del-value">{{ $delivery->city }}</div>
	        </div>
	@endif
	@if($delivery->warehouse != null)
	        <div class="del-item p-3 d-flex col-md-12">
	            <div class="del-name">@lang('Warehouse'):</div>
	        	<div class="del-value">{{ $delivery->warehouse }}</div>
	        </div>
	@endif
	@if($delivery->street != null)
	        <div class="del-item p-3 d-flex col-md-6">
	        	<div class="del-name">@lang('Street'):</div>
	        	<div class="del-value">{{ $delivery->street }}</div>
	        </div class="del-item p-3 d-flex col-md-6">
	@endif
	@if($delivery->house != null)
	        <div class="del-item p-3 d-flex col-md-6">
	        	<div class="del-name">@lang('House'):</div>
	        	<div class="del-value">{{ $delivery->house }}</div>
	        </div class="del-item p-3 d-flex col-md-6">
	@endif
	@if($delivery->flat != null)
	        <div class="del-item p-3 d-flex col-md-6">
	        	<div class="del-name">@lang('Flat'):</div>
	        	<div class="del-value">{{ $delivery->flat }}</div>
	        </div>
	@endif
	</div>
		</div>
		<div class="col-lg-4">
		@if(url()->current() != route('cart.checkout'))
			<span class="delete-item del-delete-button" data-url="{{ route('delivery.delete', ['id' => $delivery->id])}}" data-id="{{ $delivery->id }}"><i class="icon-Trash"></i> @lang('Delete')</span>
		@endif

                <p class="mt-3">
                    <input type="radio" data-id="{{ $delivery->id }}" class="del-select-main select-main" id="del-main-{{ $delivery->id }}" name="delivery_id" @if($delivery->main == 1) checked @endif name="select_main" value="{{ $delivery->id }}">
                    <label for="del-main-{{ $delivery->id }}">@lang('Select main')</label>
                </p>

		</div>
	</div>
@endforeach
<script type="text/javascript">
	$(document).on('change', '.del-select-main', function(){
		var id = $(this).data('id');

		$.ajax({
            
            method: 'GET',
            
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            
            url: '/delivery/select-main/' + id, 
            
            success: function(response){
                
            },
            error: function(response){
     
            }
        });
	});
</script>
