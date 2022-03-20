<style type="text/css">
    .abv-title{
    	font-family: fbold;
    	color: #333;
    	font-size: 16px;
    }
    .abv-icon img{
    	width: 50px;
    }
    .abv-body{
    	font-family: fnormal;
    	font-size: 14px;
    	color: #444;
    }
    .cbb-title{
    	font-size: 24px;
    	font-family: fbold;
    	color: #fff;
    }
    .call-back-button-block{
    	border: 1px solid #fff;
    }
@media screen and (max-width: 580px) {
	.abv-icon img{
		width: 60px;
	}
	
}
	
</style>
@foreach($items as $i)
<div class="col-lg-4 col-md-4 abv-block mt-2 mt-md-0 py-2">
	<div class="abv-head d-flex justify-content-between align-items-center">
		<div class="abv-icon">
			<img src="{{ $i->mini_preview }}" alt="">
		</div> 
		<div class="abv-title pr-3">
			{{ $i->language->title ?? null }}			
		</div>
		
	</div>
	<div class="abv-body mt-3">
		{{ $i->language->text1 ?? null }}
	</div>
</div>
@endforeach
<div class="col-lg-12 mt-2 mt-md-5 py-3">
	<div class="call-back-button-block text-center"  style="background: url({{ $site_option['cbb_bg']['one']}}) center no-repeat; padding: 10px; border:1px solid #ddd;" >
		<div style="background:rgba(0,0,0,0.2); border:1px solid #fff; padding: 50px 0;">
		    <p class="cbb-title">
			    {{ $site_option['cbb_title'] }}
		    </p>
		    <button class="btn btn-primary btn-lg mt-3" data-toggle="modal" data-target="#callbackModal">{{ $site_option['cbb_modal_title'] ?? null }}</button>	
	    </div>
	</div>
</div>