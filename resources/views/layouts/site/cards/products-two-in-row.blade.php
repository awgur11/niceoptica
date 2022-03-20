<style type="text/css">
    .pr-card{
    	position: relative;
    }
    .pr-preview{
    	height: 400px;
    	background-size: cover;
    	background-position: center;
    	padding: 10px;
    	transition: 0.5s;
    }
    .pr-sub-preview{
    	border: 1px solid #fff;
    	background: rgba(0, 0, 0, 0.0);
    	height: 100%;
    	transition: 0.5s;
    }
    .pr-sub-preview div{
    	color: #fff;
    	text-transform: uppercase;
    	transform: scale(0.98);
    	font-family: fbold;
    	letter-spacing: 2px;
    	font-size: 22px;
    	opacity: 0;
    	transition: 0.5s;
    }
    .pr-title{
    	text-align: center;
    	text-transform: uppercase;
    	font-size: 15px;
    	font-family: fnormal;
    	padding: 10px;
    	margin-top: 10px;
    	border: 1px solid #ddd;
    	transition: 0.3s;
    }
    .pr-card:hover .pr-preview{
    	padding: 0;
    }
    .pr-card:hover .pr-preview .pr-sub-preview{
    	border: 1px solid #fff;
    	background: rgba(0, 0, 0, 0.2);
    }
    .pr-card:hover .pr-sub-preview div{
    	transform: scale(1);
    	opacity: 1;
    }
	a:hover{
		text-decoration: none;
	}
	.pr-card:hover .pr-title{
		background: #42a01f;
		border: 1px solid #258301;
		color: #fff;
	}
	.add-to-favorite-button{
		position: absolute;
		color: #d33;
		padding: 5px 10px;
		border-radius: 50%;
		background: #fff;
		border: 1px solid #d33;
		right: -10px;
		top: -10px;
		display: inline-block;
		cursor: pointer;
	}
@media screen and (max-width: 768px) {
	.pr-card .pr-sub-preview div{
		transform: scale(1);
    	opacity: 1;
	}
	.pr-card .pr-title{
		background: #42a01f;
		border: 1px solid #258301;
		color: #fff;
	}
	.pr-card .pr-preview .pr-sub-preview{
		background: rgba(0, 0, 0, 0.4);
	}

	
}
</style>
@foreach($products as $product)
<div class="col-md-6 pr-block mb-3" id="pr-block-{{ $product->id }}">
	<div class="pr-card">
		@if(\Request::route() != null && \Request::route()->getName() == 'favorites')
		<div class="add-to-favorite-button" data-id="{{ $product->id }}">X</div>
		@endif
		<div class="pr-preview"style="background-image: url({{ $product->picture->two_preview }});">
			<div class="pr-sub-preview text-center d-flex align-items-center justify-content-center">
				<a href="{{ route('product', ['id_catalog' => $product->catalog->id, 'alt_catalog' => $product->catalog->alt_title, 'id' => $product->id, 'alt_title' => $product->alt_title]) }}"><div>Подробнее</div></a>				
			</div>
		</div>
		<div class="pr-title" >
			{{ $product->language->title }}
		</div>
	</div>
</div>
@endforeach