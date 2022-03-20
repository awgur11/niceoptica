<style type="text/css">
	.bb-item{
		padding: 10px;
		text-align: center;

	}
	.bb-preview img{
		width: 35px;
	}
	.bb-title{
		font-family: fnormal;
		//text-transform: uppercase;
		font-size: 12px;
		margin-top: 10px;
		color: #666;
	}
	.bb-text{
		font-family: fnormal;
		font-size: 12px;
		margin-top: 10px;
		color: #666;
		text-align: left;
	}
	
</style>
<div id="product-blocks-block" class="row pb-5 pt-5">
	@foreach($pBlocks as $pb)
	<div class="bb-item col-lg-3 col-md-6 col-6">
		<div class="bb-preview">
			<img src="{{ asset('storage/images'.$pb->preview) }}">
		</div>
		<div class="bb-title" >
			{{ $pb->language->title }}
		</div>
<!--		<div class="bb-text">
			{!! $pb->language->text1 !!}
		</div>-->
	</div>
	@endforeach
</div>