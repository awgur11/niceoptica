<style type="text/css">
	#page-header{
		
		height: 500px;
		padding-top:  200px;
		margin-top: 50px;
		background: url({{ $page->fhd_preview }}) center no-repeat;
		background-size: cover;
	}
	.page-title{
		font-family: fbold;
		font-size: 45px;
		letter-spacing: 2px;
		text-transform: uppercase;
		color: #fff;
		padding: 50px 0;
		text-shadow: 1px 1px 1px #666;
		background: linear-gradient(130deg, transparent 0%, transparent  50%, #f3f3f374 50%, #f3f3f354 55%, transparent  55%);
	}
@media screen and (max-width: 1024px) {
	.page-title{
	    background: linear-gradient(130deg, transparent 0%, transparent  50%, #f3f3f374 50%, #f3f3f354 65%, transparent  65%);
	}
}
@media screen and (max-width: 580px) {
	#page-header{
		height: 300px;
		padding-top:  90px;
	
}

</style>
<div class="container-fluid" id="page-header">
	<div class="row">
		<div class="col-12 text-center">
			<h1 class="page-title">{{ $page->language->title ?? null }}</h1>
		</div>
	</div>
</div>