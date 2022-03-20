@isset($catalog)
<style type="text/css">
    #all-filters-side-bg{
    	position: absolute;
		z-index: -3;
		left: 0;
		top: 0;
    	width: 100%;
    	height: 100vh;
    	background: rgba(0, 0, 0, 0);
    	display: none;
    }
    #all-filters-side-bg.active{
    	display: block;
    }
	#all-filters-side{
		position: absolute;
		z-index: -2;
		top: 0;
		right: 0px; 
		width: 295px;
		background: #fff;
		height: 100vh;
		overflow: auto;
		padding:  120px 24px 24px;
		border-left: 1px solid #D7DEFF;
		border-right: 1px solid #DCDCDC;
		box-shadow: 1px 0 0 #DCDCDC inset;
		display: none;
	}
	#all-filters-side.active{
		display: block;
	}
	.afs-head,
	.afsf-head{
		font-family: Nunito Sans;
        font-size: 16px;
        font-style: normal;
        font-weight: 700;
        line-height: 19px;
        padding: 24px 0;
        cursor: pointer;
	}
	.afsf-head{
		padding: 24px;
	}
	.afs-item{
		font-family: Nunito Sans;
        font-size: 16px;
        font-style: normal;
        font-weight: 300;
        line-height: 19px;
        padding: 18px 0;
        cursor: pointer;
        border-bottom: 1px solid #DCDCDC;
    }
    .afs-item:hover{
    	color: #2C50F2;

    }
    .afs-fvalues-block{
        position: absolute;
		z-index: -1;
		top: 0;
		right: 0px;
		width: 295px;
		background: #fff;
		height: 100vh;
		padding-top: 120px;
		display: none;
		box-shadow: 1px 0 0 #DCDCDC inset;
		border-right: 1px solid #DCDCDC;
    }
    .afs-fvalues-block.active{
    	display: block;
    }
    .afsf-item{
    	font-family: Nunito Sans;
        font-size: 16px;
        font-style: normal;
        font-weight: 300;
        line-height: 19px;
        padding: 0 24px;
        cursor: pointer;
        margin-bottom: 0;
        
    }
    .afsf-item-sub{
    	padding: 14px 0;
    	border-bottom: 1px solid #DCDCDC;
    }
    [type="checkbox"]:not(checked) + label.afsf-item .icon-Tick{
		display: none;
	}
	[type="checkbox"]:checked + label.afsf-item{
		color: #2C50F2;

    background: #F6F6F6;
	}
    [type="checkbox"]:checked + label.afsf-item .icon-Tick{
		display: block;
	}
	[type="checkbox"]:not(:checked).afsf-input,
    [type="checkbox"]:checked.afsf-input {
        position: absolute;
        left: -9999px;
    }
    .afs-fvalues-block-body{
    	height: calc(100% - 134px);
    	overflow: auto;
    }
    .afs-fvalues-block-footer{
    	height: 72px;
    	padding: 11px 16px;
    	background-color: #F1F4FF;

    }
    	/* width */
.afs-fvalues-block-body::-webkit-scrollbar {
  width: 5px;
}

/* Track */
.afs-fvalues-block-body::-webkit-scrollbar-track {
  background: #F1F4FF;;
}

/* Handle */
.afs-fvalues-block-body::-webkit-scrollbar-thumb {
  background: #2848DA;;
}

/* Handle on hover */
.afs-fvalues-block-body::-webkit-scrollbar-thumb:hover {
  background: #555;
}
@media screen and (max-width: 580px) {
	#all-filters-side{
		width: 100%;
		padding:  100px 24px 24px;
	}
	.afs-fvalues-block{
		width: 100%;
		padding-top: 100px;
    }

}
</style>
<div id="all-filters-side-bg">
    <div id="all-filters-side">
    	<div class="afs-head d-flex justify-content-between">
	    	@lang('All filters')  <i class="icon-Cross"></i>
	    </div>
    @foreach($catalog->filters as $filter)
        <div class="afs-item d-flex justify-content-between" data-filter_id="{{ $filter->id }}">
    	    {{ $filter->language->title }} <i class="icon-Arrow---Right"></i>
        </div>
    @endforeach
    </div>
</div>
@foreach($catalog->filters as $filter)
    <div class="afs-fvalues-block" id="afs-fvalues-block-{{ $filter->id }}">
    	<div class="afsf-head d-flex justify-content-between" data-filter_id="{{ $filter->id }}">
    		<i class="icon-Arrow---Left"></i> {{ $filter->language->title }} <i class="icon-Cross"></i>
    	</div>
    	<div class="afs-fvalues-block-body">
    @foreach($catalog->fvalues->where('filter_id', $filter->id) as $fvalue)
      	    <input type="checkbox" id="afsf-{{ $fvalue->id }}" class="afsf-input"  name="filter-{{ $filter->id }}[]" value="{{ $fvalue->id }}-{{ $fvalue->language->title ?? null }}" form="fsb-form-mobile" @if(app("request")->has('filter-'.$filter->id) && in_array($fvalue->id, app('request')->input('filter-'.$filter->id))) checked @endif id="fvalue-{{ $fvalue->id }}">
            <label class="afsf-item d-block" for="afsf-{{ $fvalue->id }}">
        	    <div class="afsf-item-sub  d-flex justify-content-between m-0">
            	    <div>{{ $fvalue->language->title }}</div>
            	    <div><i class="icon-Tick"></i></div>
                </div>
            </label>
    @endforeach    	
        </div>
        <div class="afs-fvalues-block-footer d-flex justify-content-between">
        	<div class="no-btn clear-up-side-filters" data-filter_id="{{ $filter->id }}">
        	    @lang('Clear')
        	</div>

        		<button class="btn btn-primary btn-sm" form="fsb-form-mobile">@lang('Pick up')</button>

        </div>
    </div>
@endforeach
<form action="{{ url()->current() }}" id="fsb-form-mobile"></form>
<script type="text/javascript">

	$(document).on('mouseover', '#all-filters-side-bg', function(){
	//	$('.afs-fvalues-block').removeClass('active');
	//	$('#all-filters-side').removeClass('active');
	//	$('body').toggleClass('stop-scrolling');
	});

	$(document).on('click', '.clear-up-side-filters', function(){
		var filter_id = $(this).data('filter_id');
		$('#afs-fvalues-block-' + filter_id + ' input[type="checkbox"]').prop('checked', false);
	});

	$(document).on('click', '.afsf-head', function(){
		var filter_id = $(this).data('filter_id');
		$('#afs-fvalues-block-' + filter_id).removeClass('active');
		$('#all-filters-side-bg').addClass('active');
	});
	$(document).on('click', '.afs-item', function(){
		var filter_id = $(this).data('filter_id');
		$('#afs-fvalues-block-' + filter_id).addClass('active');
		$('#all-filters-side-bg').removeClass('active');

	})
	$(document).on('click', '.all-filters-button', function(){

		$('#all-filters-side-bg').toggleClass('active');

		$('#all-filters-side').toggleClass('active');
		$('body').toggleClass('stop-scrolling');

	});
	$(document).on('click', '.afs-head', function(){
		$('#all-filters-side').toggleClass('active');

		
		$('body').toggleClass('stop-scrolling');
		$('#all-filters-side-bg').toggleClass('active');
	})
</script>
@endisset