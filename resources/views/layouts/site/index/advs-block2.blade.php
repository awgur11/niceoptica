<style type="text/css">
	#abvs{
		background: linear-gradient(rgba(255,255,255,.4), rgba(255,255,255,.4)), url({{ $site_option['advs_bg']['fhd'] }}) center no-repeat;
		background-size:cocver;
		overflow: hidden;
	}
	#abvs .row{
		min-height: 400px;
	}
	#abvs .block-title{
		color: #fff;
		font-family: fbold;
		font-size: 55px;
		max-width: 250px;
		margin: auto;
	}
	.abvs-list{
		background: rgba(0,0,0, 0.7);
		transform: skew(20deg);
	}
	.abvs-list .abv-l{
		transform: skew(-20deg);

	}
	.abvs-list .abv-l p{
		margin-bottom: 0;
		font-family: fbold;
		padding-left: 20px;
		color: #fff;

	}
	.abvs-list .abv-l img{
		width: 50px;
	}
@media screen and (max-width: 580px) {
	.abvs-list{
		background: rgba(0,0,0, 0);
		transform: skew(0deg);
	}
	.abvs-list .abv-l{
		transform: skew(0deg);

	}
	#abvs{
		background: linear-gradient(rgba(0,0,0,.4), rgba(0,0,0,.4)), url({{ $site_option['advs_bg']['fhd'] }}) center no-repeat;
	
}
</style>
<div class="container-fluid mt-5 pt-5 pt-md-0" id="abvs">
	<div class="row justify-content-center align-items-center">
		<div class="col-12 col-md-4 col-lg-4 col-xl-3">
			<h2 class="block-title" >{{ $site_option['advs_title']}}</h2>
		</div>
		<div class="col-12 col-md-8 col-lg-5 col-xl-5">
			<div class="abvs-list row">
	@foreach($advs as $adv)
	            <div class="col-6 abv-l d-flex align-items-center my-5 ">
	            	<img src="{{ $adv->mini_preview}}" alt="">
	            	<p>{{ $adv->language->title }}</p>
	            </div>       
	@endforeach		
	        </div>	
		</div>
	</div>
</div>