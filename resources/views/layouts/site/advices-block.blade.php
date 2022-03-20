<style type="text/css">
    .ser-items-block:hover .ser-item{
    	width: 15%;
    }
	.ser-item{
		height: 450px;
		background-size: cover;
		background-position: center;
		position: relative;
		overflow: hidden;
		transition: 0.5s;
		display: inline-block;
		width: 20%;
		box-shadow: 0 0 1px rgba(0, 0, 0, 0.1);
	}
	.ser-item:hover{
		width: 40%!important;
		box-shadow: 0 0 5px rgba(0, 0, 0, 0.4);
	}
	.ser-sub-item{
		transition: 0.3s;
		height: 100%;
	}
	.ser-item:hover .ser-sub-item{
		background-color: rgba(0, 0, 0, 0.4);
	}
	.ser-title{
		display: block;
		position: absolute;
		top: 50%;
		left: 50%;
		width: 450px;
		color: #fff;
		font-family: fbold;
		transform: translate(-50%, -10%);
		text-center;
		opacity: 0;
		font-size: 28px;
		
	}
	.ser-item:hover .ser-title{
		opacity: 1;
		color: #fff;
		transition: 0.5s 0.3s;
		transform: translate(-50%, -50%);
	}
@media screen and (max-width: 1300px) {
	.ser-item,
	.ser-item:hover{
		height: 350px;
	}
	.ser-title{
		width: 300px;
	}
	.ser-title{
		font-size: 20px;
	}
}
@media screen and (max-width: 768px) {
	.ser-items-block:hover .ser-item,
	.ser-item,
	.ser-item:hover{
		width: 50%;
		border: 1px solid #fff;
	}
	.ser-item:last-child,
	.ser-items-block:hover .ser-item:last-child{
		width: 100%;
	}
	.ser-title{
		width: 250px;
		opacity: 1;
		transform: translate(-50%, -50%);
	}
	.ser-item .ser-sub-item{
		background-color: rgba(0, 0, 0, 0.4);
	}
}
@media screen and (max-width: 580px) {
	.ser-items-block:hover .ser-item,
	.ser-item{
		width: 100%;
	}
}
</style>
<div class="container mb-5">
	<div class="row">
		<div class="col-12">
			<h2 class="block-title">
				{{ $site_option['advices_title'] ?? null }}
			</h2>
		</div>
	</div>
	<div class="row ser-items-block" >

	@foreach($advices as $advice)

	    <div class="ser-item" style="background-image: url({{ $advice->one_preview }});">
	    	<div class="ser-sub-item">
	    	    <a class="ser-title" href="{{ route('page', ['alt_title' => $advice->alt_title]) }}">
	    		    {{ $advice->language->title }}
	    	    </a>
	        </div>

	         	
	    </div>
	@endforeach

	</div>
</div>