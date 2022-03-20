<style type="text/css">
.catalogs-card{
    height: 289px;
    background-position: 80% 100%;
    background-size: auto 85%;
    background-repeat: no-repeat;
    border-bottom: 1px solid #DCDCDC;
    border-right: 1px solid #DCDCDC;
    display: block;
    padding: 24px;
    transition: 0.6s;
}
.catalogs-card:first-child{
    border-left: 1px solid #DCDCDC;

}
.catalogs-card:hover{
    background-size: auto 90%;

}

.catalog-title{
    font-family: Nunito Sans;
    font-size: 24px;
    font-style: normal;
    font-weight: 400;
    line-height: 29px;
    letter-spacing: 0px;
    text-align: left;
    color: #202020;
    max-width: 205px;
    height: 220px;

}
.catalog-products-count{
    font-family: Nunito Sans;
    font-size: 16px;
    font-style: normal;
    font-weight: 300;
    line-height: 19px;
    letter-spacing: 0px;
    text-align: left;
    color: #898989;

}
@media screen and (max-width: 580px) {

.catalogs-card{
    height: 189px;
  //  background-size: auto 90%;
}
.catalog-title{
    font-size: 14px;
    max-width: 105px;
    height: 130px;
}
.catalog-products-count{
    font-size: 12px;
}

    
}

	
</style>
@foreach($items as $catalog)
<div class="col-6 col-lg-4 col-xl-3 catalog-block  p-0">
	<a href="{{ route('products', ['id' => $catalog->id, 'alt_title' => $catalog->alt_title]) }}" class="catalogs-card" style="background-image: url({{ $catalog->four_preview }});">
		<div class="catalog-subcard ">
			<div class="catalog-title">
				{{ $catalog->language->title }}
			</div>
            <div class="catalog-products-count">
                {{ $catalog->products_count }} @lang('productss')
            </div>
    	</div>
    </a>
</div>

@endforeach