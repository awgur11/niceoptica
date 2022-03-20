<style type="text/css">
	#header{
		min-height: 87vh;
		background-image: linear-gradient(rgba(0,0,0,.8), rgba(0,0,0,.8)), url({{ $site_option['header_bg']['fhd'] }});
		background-size:cover;
		background-position:center;
		padding-top:60px;
	}
	#header .row:first-child{
		min-height: 87vh;
	}
	#header h1{
		color: #fff;
		font-size: 65px;
		font-family: fbold;
		width: 600px;
		max-width: 100%;
	}
	#header h2{
		color: #fff;
		font-size: 20px;
		font-family: fnormal;
		width: 600px;
		max-width: 100%;
	}
	.ct-item p{
		font-family: fitalic;
		color: #ddd;
		font-size: 25px;
		margin-bottom: 0;

	}
	.ct-item img{
		width: 70px;

	}
@media screen and (max-width: 1024px) {
	.ct-item img{
		width: 50px;

	}
	.ct-item p{
		font-size: 20px;
	}
	#header h1{
		font-size: 45px;
}
</style>
<div class="container-fluid" id="header">
	<div class="row justify-content-center align-items-center">
		<div class="col-12 col-lg-6  col-md-7 col-xl-5">
			<h1>{{ $site_option['site_head_title'] ?? null }}</h1>
			<h2 class="my-4">{{ $site_option['site_head_subtitle'] ?? null }}</h2>
			<div class="my-3">
				<a href="/" class="btn btn-primary btn-lg">
                    Calculate Shipping Cost
				</a>
			</div>
		</div>
		<div class="col-lg-1 d-none d-lg-block"></div>
		<div class="col-12 col-lg-5 col-md-5 col-xl-4 d-none d-md-block">
	@foreach($car_types as $ct)
	        <div class="ct-item d-flex align-items-center my-3 py-3">
	        	<img src="{{ $ct->mini_preview }}" alt="" class="mr-3">
	        	<p class="pl-5">{{ $ct->language->title ?? null }}</p>
	        </div>
	@endforeach
		</div>
	</div>
	<div class="row">
		<div class="col-12 text-right pb-2">
			@include('layouts.site.contacts.socialites')
		</div>
	</div>
</div>