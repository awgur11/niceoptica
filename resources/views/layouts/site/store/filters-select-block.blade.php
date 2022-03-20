<style type="text/css">
    .filter-select-block{
    	position: relative;
    	padding: 19px 16px;
		border: 1px solid #DCDCDC;
		display: inline-block;
		margin-right: 32px;
		margin-bottom: 15px;
		min-width: 208px  ;
    }
	.fsb-filter-title{
		font-family: Nunito Sans;
font-size: 16px;
font-style: normal;
font-weight: 300;
line-height: 19px;
letter-spacing: 0px;
text-align: left;
color: #202020;
cursor: pointer;
	}
	.filter-select-block .filter-select-fvalues-block{
		border: 1px solid #DCDCDC;
		padding: 0;
		position: absolute;
		top: 105%;
		left: -1px;
		background-color: #fff;
		width: calc(100% + 2px);
		background-color: #fff;
		z-index: 999;
		display: none;	
		
			
	}
	.filter-select-block.active .filter-select-fvalues-block{
		display: block;

	}
	.filter-select-block .filter-select-fvalues-block-body{
		max-height: 300px;
		overflow-y: auto;

	}
	.filter-select-block .filter-select-fvalues-block-body::-webkit-scrollbar {
        width: 5px;
    }
    .filter-select-block .filter-select-fvalues-block-body::-webkit-scrollbar-track {
        background: #ddd;
    }
    .filter-select-block .filter-select-fvalues-block-body::-webkit-scrollbar-thumb {
        background: #D7DEFF;
    }
    .filter-select-block .filter-select-fvalues-block-body::-webkit-scrollbar-thumb:hover {
        background: #2848da;
    }

	.filter-select-block.active .filter-select-fvalues-block-body{
		display: block;
	}
	.filter-select-block .filter-select-fvalues-block-footer{
		display: none;
	}
	.filter-select-block.active .filter-select-fvalues-block-footer{
		display: block;
	}

	.filter-select-block.active .dd{
		transform: rotate(180deg);
	}
	.fsf-item{
		color: #202020;
		padding: 14px;
		font-family: Nunito Sans;
font-size: 16px;
font-style: normal;
font-weight: 300;
line-height: 19px;
letter-spacing: 0px;
text-align: left;
cursor: pointer;
	}
	.filter-select-fvalues-block .fsf-item:not(:last-child){
		border-bottom: 1px solid #DCDCDC;
	}
	[type="checkbox"]:not(:checked) + label.fsf-item .icon-Tick{
		display: none;
	}
	[type="checkbox"]:checked + label.fsf-item {
		color: #2C50F2;
	    background: #F6F6F6;
    }
    [type="checkbox"]:not(:checked).fsf-input,
    [type="checkbox"]:checked.fsf-input {
        position: absolute;
        left: -9999px;
    }
    [type="checkbox"]:checked + label.fsf-item .icon-Tick{
		display: block;
	}
@media screen and (max-width: 768px) {
	.filter-select-block{
		min-width: 130px;
		margin-right: 13px;
		margin-bottom: 13px;

	}
	.filter-select-block{
		padding: 9px 6px;
	}
	.fsf-item{
		padding: 9px;
	}
	
}
</style>
<form action="{{ url()->current() }}" id="fsb-form"></form>

<div id="filters-select-block">
@foreach($catalog->filters->where('active', 1) as $filter)

		<div class="filter-select-block">
			<div class="fsb-filter-title d-flex justify-content-between">
				<div>{{ $filter->language->title }}</div>
				<div class="dd"><i class="icon-Chevron---Down"></i></div>
			</div>
			<div class="filter-select-fvalues-block">
				<div class="filter-select-fvalues-block-body">

	@foreach($catalog->fvalues->where('filter_id', $filter->id) as $fvalue)
	                <input type="checkbox" id="fsf-{{ $fvalue->id }}" class="fsf-input catalog-fvalue-input-{{ $catalog->id }}" data-catalog_id="{{ $catalog->id }}" name="filter-{{ $filter->id }}[]" value="{{ $fvalue->id }}-{{ $fvalue->language->title ?? null }}" form="fsb-form" @if(app("request")->has('filter-'.$filter->id) && in_array($fvalue->id, app('request')->input('filter-'.$filter->id))) checked @endif id="fvalue-{{ $fvalue->id }}">
	                <label class="fsf-item d-flex justify-content-between m-0" for="fsf-{{ $fvalue->id }}">
	            	    <div>{{ $fvalue->language->title }}</div>
	            	    <div><i class="icon-Tick"></i></div>
	                </label>  
	@endforeach 
	            </div>
	            <div class="filter-select-fvalues-block-footer">
	                <button class="btn btn-primary btn-sm btn-block" form="fsb-form">
	            	    @lang('Apply')
	                </button>
	            </div>
			</div>
		</div>
 
@endforeach
</div>
<script type="text/javascript">
	$(document).on('click', '.filter-select-block', function(){
		$(this).toggleClass('active');
	});
	$(document).on('mouseleave', '.filter-select-fvalues-block', function(){
		$(this).parent().removeClass('active');
	});
</script>