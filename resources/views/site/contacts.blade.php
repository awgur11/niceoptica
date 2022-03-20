@extends('site.base')

@section('content')


<style type="text/css">
    #contacts-map{
    	box-shadow: 0 0 5px rgba(0,0,0,.2);
    }
	#contacts-map iframe{
		width: 100%!important;
		height: 700px!important;

	}
	.contacts-block{
		height: 700px;
	}
	.contacts-text{
		position: relative;
		background: #fafafa;
		box-shadow: 0 0 5px #42a01f34, 0 0 5px #42a01f34 inset;
		z-index: 9;
		left: 50px;
		transform: translateX(50px);
		padding-left: 30px;
		width: 500px;
		max-width: 100%;
		padding: 20px;
		border: 1px solid #42a01f;;

	}
	.contacts-text .con-block:not(:last-child){
		border-bottom: 1px solid #ddd;
		padding-bottom: 20px;
	}
	.contacts-text .con-block .con-title{
		font-size: 17px;
		font-family: fbold;
		text-transform: uppercase;
		letter-spacing: 2px;
		color: #333;
		margin-bottom: 15px;
		

	}
	.contacts-text .con-block:not(:first-child) .con-title{
		margin-top: 25px;

	}
	.contacts-text .con-block .con-body,
	.contacts-text .con-block .con-body a{
		color: #333;
		font-family: fitalic;
		color: #666;
		font-size: 15px;
	}

	.contacts-text .con-block .con-body i{
		font-size: 20px;
		color: #42a01f;
		padding-right: 10px;
		width: 25px;
	}
@media screen and (max-width:  1024px) {
	.contacts-text{
		transform: translateX(25px);
	}
	#contacts-map{
    	transform: translateX(-25px);
    }
	
}
@media screen and (max-width: 580px) {
	.contacts-text{
		transform: translateX(0px);
		left: 0;
	}
	#contacts-map{
    	transform: translateX(0px);
    }
    #contacts-map iframe{
		width: 100%!important;
		height: 600px!important;

	}
	.contacts-block{
		max-height: 600px;
		width: 100%;
	}
	
}
</style>

<div class="container">
	<div class="row">
		<div class="col-12">
			<h1 class="page-title">{{ $page->language->title }}</h1>
		</div>
	</div>
	<div class="row ">
		<div class="col-md-5 contacts-block d-flex align-items-center">
			<div class="contacts-text">
				<div class="con-block">
					<div class="con-title">
						Телефоны					
					</div>
					<div class="con-body">
				@foreach($site_option['phones'] as $ph)
				        <div>

				            <i class="fas fa-phone-volume"></i> 

					        <a href="tel:{{ $phone['phone '] ?? null }}">
						        {{ $ph['phone'] ?? null }}
					        </a>
					    </div>
				@endforeach						
					</div>
				</div>

				<div class="con-block">
					<div class="con-title">
						Email					
					</div>
					<div class="con-body">
				        <i class="far fa-envelope"></i> {{ $site_option['site_email'] ?? null }}
					</div>
				</div>

				<div class="con-block">
					<div class="con-title">
						Как мы работаем				
					</div>
					<div class="con-body">
				        <i class="far fa-clock"></i> {{ $site_option['working_time'] }}
					</div>
				</div>

				<div class="con-block">
					<div class="con-title">
						Адрес					
					</div>
					<div class="con-body">
				        <i class="fas fa-map-marker-alt"></i> {{ $site_option['address'] }}
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-7">
			<div id="contacts-map">
				{!! $map ?? null !!}
				
			</div>
		</div>
	</div>
</div>

@endsection