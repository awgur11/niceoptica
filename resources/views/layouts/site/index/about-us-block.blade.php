<style type="text/css">
	.aboutme_exp{
		font-family: fnormal;
		color: #fff;
		font-size: 40px;
		margin-top: 30px;
		text-shadow: 1px 1px 0 #333;
		width: 350px;
		max-width: 100%;
	}
	.aboutme-text{
		font-family: fnormal;
		font-size: 16px;
		text-align: justify;
		color: #333 ;
		margin: 30px 0;
	}
	.btn-neon{
		border: 2px solid #f609c8;
		box-shadow: 0 0 5px #f609c8, 0 0 5px #f609c8 inset;
		text-shadow: 0 0 5px #e33;
		color: #f609c8;
		font-family: fhand;
		padding: 20px;
		font-size: 20px;
		text-transform: lowercase;
	//	border-radius: 15px;
		transition: 0.3s;
	}
	.btn-neon:hover{
		color: #d108aa;
		border: 2px solid #1d1d1d;

	}
	.au-picture{
		padding: 10px;
		background: url({{ $site_option['aboutus_photo']['one'] }}) center no-repeat;
		background-size:cover;
		border: 1px solid #ddd;
		height:600px;
	}
@media screen and (max-width: 580px) {
	.au-picture{
		height: 400px;
	}
	
}
</style>

<div class="container-fluid" style="background: linear-gradient(to bottom, #fff 0, #fff 50%, #f3f3f3 50%, #f3f3f3 100%);">
<div class="container" id="aboutme-block" >
	<div class="row">
		<div class="col-12">
			<h2 class="block-title" >{{ $site_option['aboutme_title'] ?? null }}</h2>
		</div>
	</div>
	<div class="row justify-content-center">
		<div class="col-12 p-0">
			<div class="au-picture">
		@isset($site_option['aboutus_photo']['one'])
			<div style="width: 100%; height: 100%; border: 1px solid #fff; padding: 20px; background: rgba(0, 0, 0, 0.2);" class="d-flex align-items-center">
				<p class="aboutme_exp">{{ $site_option['aboutme_exp'] ?? null }}</p>
			</div>
		@endisset
		    </div>
		</div>
	</div>
</div>
</div>

<div class="container-fluid" style="background: #f3f3f3;">
<div class="container  mb-3 pb-3" id="aboutme-block" >
	<div class="row mb-2">
		<div class="col-12">
			
			
			 
		</div>
	</div>
	<div class="row align-items-center">
		<div class="col-md-8">			
			<div class="aboutme-text" style="">
				{{ $site_option['aboutme_text'] ?? null }} ...
			</div>
		</div>
		<div class="col-md-4 text-center p-5 mt-3 p-md-2">
			<a class="btn btn-primary" href="{{ url($site_option['aboutus_link']) }}" >
					@lang('Read more') </a>
			
		</div>
	</div>
</div>
</div>