<style type="text/css">
	#licensing img{
		max-width: 100%;
		filter: grayscale(80%);
		opacity: 0.8;
		transition: 0.3s;
	}
	#licensing img:hover{
		opacity: 1;
		filter: grayscale(0%);
	}
	#licensing{
		font-family: fnormal;
		font-size: 18px;
		text-align: center;
	}
	#licensing-text{
		background: linear-gradient(120deg, #fff 0%, #fff 20%, #f3f3f3 20%, #f3f3f3 40%, #fff 40%);
		padding-top: 50px;
		padding-bottom: 50px;
	}
@media screen and (max-width: 1024px) {
	#licensing img{
		max-width: 60%;
		filter: grayscale(0%);
	
	
}
</style>
<div class="container" id="licensing">
	<div class="row justify-content-center">
		<div class="col-12">
			<h2 class="block-title">
				{{ $site_option['licensing_title'] }}
			</h2>
		</div>
		<div class="col-12 col-lg-8 my-5 text-center" id="licensing-text">
			{{ $site_option['licensing_text'] }}
		</div>
	</div>
	<div class="row justify-content-center align-items-center">
	@foreach($licensing as $li)
	    <div class="col-6 col-md-4 col-lg-2 mt-md-3 mt-5">
	    	<img src="{{ $li->tree_preview }}" alt="">
	    </div>
	@endforeach
	</div>
</div>