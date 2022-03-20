<style type="text/css">
	#side-menu{
		position: absolute;
		z-index: -1;
		top: 0;
		left: 0px;
		width: 244px;
		background: #fff;
		height: 100vh;
		padding-top: 120px;
		border-right: 1px solid #D7DEFF;
		box-shadow: 1px 0 0 #DCDCDC inset;
		display: none;
	}
	#side-menu.active{
		display: block;
	}
	#side-menu-bg{
		display: none;
		width: 1440px;
		top: 0; 
		left: 0;
		max-width: 100%;
		height: 100vh;
		background: rgba(0,0,0,0);
		position: absolute;
		z-index: -2;
	}
	#side-menu.active + #side-menu-bg{
		display: block;
		
	}
	.smi-item{
		font-family: Nunito Sans;
font-size: 16px;
font-style: normal;
font-weight: 400;
line-height: 19px;
letter-spacing: 0px;
text-align: left;
color: #202020;
padding: 9px 24px;
transition: 0.3s;
	}
	.smi-item:hover{
		background-color: #F1F4FF;;
		color: #202020;
	}
	.smf-block{
		position: absolute;
		z-index: -2;
		top: 0;
		left: 0px;
		width: 100%;
		background: #fff;
		height: 100vh;
		overflow: auto;
		padding-bottom: 80px;
		padding-top: 120px;
		padding-left: 254px;;
		box-shadow: -1px 0 1px #DCDCDC inset;
		display: none;
	}
	.smf-block.active{
		display: flex;
	}
	.smf-block-body{
		height: 100%;
		overflow: auto;
		width: 100%;
	}
	/* width */
.smf-block-body::-webkit-scrollbar {
  width: 5px;
}

/* Track */
.smf-block-body::-webkit-scrollbar-track {
  background: #F1F4FF;;
}

/* Handle */
.smf-block-body::-webkit-scrollbar-thumb {
  background: #2848DA;;
}

/* Handle on hover */
.smf-block-body::-webkit-scrollbar-thumb:hover {
  background: #555;
}
	.smf-block-footer{
		position: absolute;
		bottom: 0;
		left: 0;
		width: 100%;
		height: 72px;
		background: #F1F4FF;
		padding-left: 254px;;
	}
	.smf-filtered-count{
		font-family: Nunito Sans;
font-size: 16px;
font-style: normal;
font-weight: 400;
line-height: 19px;
letter-spacing: 0px;
text-align: left;
color: #546DE0;
	}
	.smf-filtered-count span{
		color: #202020;
	}
	.no-btn{
		font-family: Nunito Sans;
font-size: 16px;
font-style: normal;
font-weight: 400;
line-height: 19px;
letter-spacing: 0px;
text-align: left;
color: #2C50F2;
padding: 15px;
cursor: pointer;


	}
</style>
<div id="side-menu">
	
@foreach($menu_catalogs as $mc)
    <a href="{{ route('products', ['id' => $mc->id, 'alt_title' => $mc->alt_title]) }}" class="smi-item d-flex justify-content-between" data-id="{{ $mc->id }}">
    	<div>{{ $mc->language->menu }}</div>
    	<div><i class="fas fa-chevron-right"></i></div>
    </a>

@endforeach	
</div> 
<div id="side-menu-bg"></div>
<style type="text/css">
	.smf-filter-title{
		font-family: Nunito Sans;
font-size: 16px;
font-style: normal;
font-weight: 700;
line-height: 19px;
letter-spacing: 0px;
text-align: left;
margin-bottom: 12px;
color: #202020;
	}
	.smf-fvalue-card{
		background-color: #F1F4FF;
		border: 2px solid #fff;
		cursor: pointer;
		height: 114px;
	}
	.smf-fvalue-title{
		font-family: Nunito Sans;
font-size: 12px;
font-style: normal;
font-weight: 400;
line-height: 14px;
letter-spacing: 0px;
text-align: center;
color: #202020;
height: 2em;
	}
	.smf-fvalue-preview{
		margin-bottom: 18px;
		height: 40px;
		position: relative;
	}
	.smf-fvalue-preview img{
		max-width: 100%;
		position: absolute;
		top: 50%;
		left: 50%;
		transform: translate(-50%, -50%);
	}
    [type="checkbox"]:not(:checked).catalog-fvalue-side-menu,
    [type="checkbox"]:checked.catalog-fvalue-side-menu {
        position: absolute;
        left: -9999px;
    }

    [type="checkbox"]:checked + div.smf-fvalue-card {
	    background: #D7DEFF;
	    border: 2px solid #2C50F2;
        cursor: pointer;
    }


</style>
<script type="text/javascript">
	$(document).on('click', '.smf-fvalue-card', function(){
		var id = $(this).data('id'),
		    catalog_id = $(this).data('catalog_id');

		if($('#fvalue-' + id + '-' + catalog_id).prop('checked'))
			$('#fvalue-' + id + '-' + catalog_id).prop('checked', false);
		else
			$('#fvalue-' + id + '-' + catalog_id).prop('checked', true);

		calculate_products(catalog_id);
	});
	$(document).on('click', '.clear-filters', function(){
		var catalog_id = $(this).data('catalog_id');

		console.log(catalog_id);

		$('.catalog-fvalue-input-' + catalog_id).prop('checked', false);
		calculate_products(catalog_id);
	});
	function calculate_products(id)
	{
		data = $('#catalog-filters-' + id).serialize();

		if(data == '')
			data = 'ajax=calculate_products';
		else
		    data += '&ajax=calculate_products';

		$.ajax({
            url: "/products/" + id + '-catalog',
            data: data,
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            success: function(count){
            	$('#smf-filtered-count-' + id).text(count);

            },
            error: function(error){
                console.log(error);
            },
        });
	}
    $(document).on('mouseover', '.smi-item', function(){
    	var catalog_id = $(this).data('id');

    	$('.smf-block').removeClass('active');

    	$('#smf-block-' + catalog_id).addClass('active');
    });
    $(document).on('mouseleave', '.smf-block', function(){
    //	$(this).removeClass('active');
    });

	
</script>
@foreach($menu_catalogs as $mc)
    
    @if($mc->filters->count() > 0)
    <div class="smf-block m-0" id="smf-block-{{ $mc->id }}">
    	<div class="smf-block-body row m-0">
        @foreach($mc->filters->where('active', 1) as $filter)
            <div class="px-1 pb-3 col-lg-6">
        	    <p class="smf-filter-title">{{ $filter->language->title }}</p>
    	        <div class="row m-0">
       	    @foreach($mc->fvalues->where('filter_id', $filter->id) as $fvalue)
       	            <div class="col-md-3 smf-fvalue-block pr-1 pb-1 pl-0" >
       	            	<input type="checkbox" class="catalog-fvalue-side-menu catalog-fvalue catalog-fvalue-input-{{ $mc->id }}" data-catalog_id="{{ $mc->id }}" name="filter-{{ $filter->id }}[]" value="{{ $fvalue->id }}-{{ $fvalue->language->title ?? null }}" form="catalog-filters-{{ $mc->id }}" @if(app("request")->has('filter-'.$filter->id) && in_array($fvalue->id, app('request')->input('filter-'.$filter->id))) checked @endif id="fvalue-{{ $fvalue->id }}-{{ $mc->id }}">
       	        	    <div class="smf-fvalue-card text-center p-3 catalog-fvalue-card-{{ $mc->id }}"  data-id="{{ $fvalue->id }}" data-catalog_id="{{ $mc->id }}">
       	        @if($fvalue->origin_preview != url('/storage/images/no-photo.jpg'))
       	        		    <div class="smf-fvalue-preview">
       	        			   <img src="{{ $fvalue->origin_preview }}" alt="">
       	        		    </div>
       	        @else
       	        	        <div style="padding-bottom: 1.7rem!important;"></div>
       	        @endif
       	        		    <div class="smf-fvalue-title d-flex align-items-center justify-content-center">
       	        			    {{ $fvalue->language->title }}
       	        		    </div>
       	        	    </div>
       	            </div>
    	    @endforeach
    	        </div>
            </div>
        @endforeach
        </div>
        <div class="smf-block-footer d-flex justify-content-between align-items-center">
        	<div class="smf-filtered-count">
        		@lang('Productss') <span id="smf-filtered-count-{{ $mc->id }}">{{ $mc->products_count }}</span>
        	</div>
        	<div class="d-flex align-items-center pr-3">
        		<div class="no-btn clear-filters" data-catalog_id="{{ $mc->id }}">@lang('Clear filters')</div>
        		<form action="{{ route('products', ['id' => $mc->id, 'alt_title' => $mc->alt_title]) }}" id="catalog-filters-{{ $mc->id }}">
        		<button class="btn btn-primary">@lang('Pick up')</button>
        	    </form>
        	</div>
        </div>
    </div>
    @endif
@endforeach
<script type="text/javascript">
	
	$(function(){
		body_width = $('body').width();
		$('body').width(body_width);

		$(window).resize(function(){
			body_width = $(window).width();
		    $('body').width(body_width);
	    });
	}); 

	$(document).on('click', '#catalog-button', function(){
		
		if($(window).width() <= 768)
			return false;

		$('#side-menu').toggleClass('active');

		if(!$('#all-filters-side').hasClass('active'))
		   $('body').toggleClass('stop-scrolling');

		$('.smf-block').removeClass('active');	
	});

</script>