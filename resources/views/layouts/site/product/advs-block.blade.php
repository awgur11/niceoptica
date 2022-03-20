<style type="text/css">
	.abv-icon{
		height: 48px;
		width: 48px;
		background: #2C50F2;
		text-align: center;
		font-size: 26px;
		padding: 6px 0;
		color: #fff;
	}
	.abv-title{
		font-family: Nunito Sans;
        font-size: 18px;
        font-style: normal;
        font-weight: 700;
        line-height: 22px;
        color: #202020;
	}
	.abv-subtitle{
		font-family: Nunito Sans;
        font-size: 18px;
        font-style: normal;
        font-weight: 400;
        line-height: 27px;
        color: #5E5E5E;
	}
	.abv-block.with-link{
		cursor: pointer;
	}
	.abv-link{
		display: none;
		font-family: Nunito Sans;
        font-size: 18px;
        font-style: normal;
        font-weight: 400;
        line-height: 27px;
        color: #2C50F2;
	}
	.abv-block.with-link:hover .abv-link{
		display: block;
	}
	.abv-block.with-link:hover .abv-subtitle{
		display: none;
	}

</style>
<div class="container-fluid my-5" >
	<div class="row" style="padding: 42px 0 15px; background-color: #F8F8F8;;">
@foreach($items as $item)
        <div class="col-lg-3 col-md-6 abv-block mb-3 @if($item->nol2 != '') with-link @endif">
        	<div class="abv-card d-flex">
        		<div class="abv-icon">
        			<i class="{{ $item->nol1 }}"></i>
        		</div>
        		<div class="abv-text pl-3">
        			<div class="abv-title">{{ $item->language->title }}</div>
        			<div class="abv-subtitle">{{ $item->language->text1 }}</div>
    @if($item->nol2 != '')
                    <a href="{{ $item->nol2 }}" class="abv-link">@lang('Read more')</a>
    @endif
        		</div>
        	</div>
         	
        </div>
@endforeach		
	</div>
</div>
