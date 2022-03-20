@if(isset($catalog) && $catalog->filters->where('active', 1)->count() > 0)
<style type="text/css">
	.form-check-label{

	/* Base for label styling */
}
[type="checkbox"]:not(:checked),
[type="checkbox"]:checked {
  position: absolute;
  left: -9999px;
}
[type="checkbox"]:not(:checked) + label,
[type="checkbox"]:checked + label {
  position: relative;
  padding-left: 1.95em;
  cursor: pointer;
}

/* checkbox aspect */
[type="checkbox"]:not(:checked) + label:before,
[type="checkbox"]:checked + label:before {
  content: '';
  position: absolute;
  left: 0; top: 0;
  width: 1.25em; height: 1.25em;
  border: 1px solid #ccc;
  transition: 0.5s;
  background: #fff;
  border-radius: 0px;
  box-shadow: inset 0 1px 3px rgba(0,0,0,.1);
}
[type="checkbox"]:checked + label:before{
	border: 1px solid #c7003d;

}
/* checked mark aspect */
[type="checkbox"]:not(:checked) + label:after,
[type="checkbox"]:checked + label:after {
  content: '\2713\0020';
  position: absolute;
  top: .15em; left: .22em;
  font-size: 1.3em;
  line-height: 0.8;
  color: #c7003d;
  transition: all .2s;
  font-family: 'Lucida Sans Unicode', 'Arial Unicode MS', Arial;
}
/* checked mark aspect changes */
[type="checkbox"]:not(:checked) + label:after {
  opacity: 0;
  transform: scale(0);
}
[type="checkbox"]:checked + label:after {
  opacity: 1;
  transform: scale(1);
}
/* disabled checkbox */
[type="checkbox"]:disabled:not(:checked) + label:before,
[type="checkbox"]:disabled:checked + label:before {
  box-shadow: none;
  border-color: #bbb;
  background-color: #ddd;
}
[type="checkbox"]:disabled:checked + label:after {
  color: #999;
}
[type="checkbox"]:disabled + label {
  color: #aaa;
}
/* accessibility */
[type="checkbox"]:checked:focus + label:before,
[type="checkbox"]:not(:checked):focus + label:before {
//  border: 2px dotted blue;
}

/* hover style just for information */
label:hover:before {
  border: 1px solid #d25912!important;
}
	.filters-top-head{
		font-family: fnormal;
		color: #000;
		letter-spacing: 2px;
		font-size: 16px;
		font-weight: 600;
		padding-bottom: 5px;
	}
	#filters-block{
		padding: 0 0 5px;
		background: #fff;
		z-index: 99999999;

	}
	.filter-title{
		padding: 15px;
		font-family: fnormal;
		font-size: 14px;
		text-transform: uppercase;
		border-top: 1px solid #3481be;
		font-weight: 100;

		margin-bottom: 10px;
		background:#5bb3e634 ;
	}
	.filter-title i{
		cursor: pointer;
	}
	.filter-body{
		//padding: 5px;
		border:1px solid #fff;
		//margin-bottom: 15px;
		max-height: 400px;
		overflow: auto;
	}
	#filter-button-block{
		padding: 15px;
		text-align: center;
	}
	.filter-body label{
		font-weight: 100;
		font-family: fnormal;
		font-size: 13px;
	}
	.filter-body::-webkit-scrollbar {
  width: 4px;
}
 
.filter-body::-webkit-scrollbar-track {
  box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.3);
  background-color: #5bb3e634;
}
 
.filter-body::-webkit-scrollbar-thumb {
  background-color: #3481be;
  outline: 1px solid slategrey;
}


	@media screen and (max-width: 992px){
		#filters-block{
			position: fixed;
			height: 100vh;
			overflow: auto;
			top: 0;
			left: 0;
			z-index: 999999;
			width: 100%;
			transform: translateX(-150%);
			transition: 0.5s ease-in;
			border-right: 1px solid #3481be;
		}
		#filters-block.show-filters{
			transform: translateX(0);
			transition: 0.6s;
		}
	}
</style>

 

<form method="GET" action="{{ url()->current() }}" name="order-filters-form" id="order-filters-form">
<div id="filters-block">
	<div class="d-lg-none p-2 text-right">
		<div class="btn btn-sm btn-outline-danger d-lg-none mb-3" id="hide-filters-button">
	        <i class="fas fa-arrow-left"></i>
	    </div>
	</div>


	@foreach($catalog->filters->where('active', 1) as $filter)

	<div class="filter-block">
		<div class="filter-title d-flex justify-content-between">
			<b>{{ $filter->language->title ?? null }}</b> <span class="show-filters-button"  data-toggle="collapse" data-target="#filter-{{ $filter->id }}"><i class="fas fa-chevron-down"></i></span>
		</div>
		<div class="filter-body collapse px-2 px-lg-0" id="filter-{{ $filter->id }}">
	    @foreach($catalog->fvalues->where('filter_id', $filter->id) as $fvalue)

	        <p>
	        	
	        	<input type="checkbox" class="form-check-input" name="filter-{{ $filter->id }}[]" value="{{ $fvalue->id }}-{{ $fvalue->language->title ?? null }}" 
	        	@if(app("request")->has('filter-'.$filter->id) && in_array($fvalue->id, app('request')->input('filter-'.$filter->id))) checked @endif id="fvalue-{{ $fvalue->id }}">
	        	<label class="form-check-label" for="fvalue-{{ $fvalue->id }}">{{ $fvalue->language->title ?? null }}</label>
	        </p>

	    @endforeach
		</div>
	</div>
	@endforeach

	<div id="filter-button-block">
		<button class="btn btn-danger">@lang('Apply')</button>
	</div>


</div>
</form>
@endif
<script type="text/javascript">
	$(function(){
		$('.show-filters-button').first().click();
	})
	$(document).on('click', '#show-filters-button', function(){
		$('#filters-block').addClass('show-filters');
	});
	$(document).on('click', '#hide-filters-button', function(){
		$('#filters-block').removeClass('show-filters');
	});
</script>
<script type="text/javascript">
	$(document).on('click', '.show-filters-button', function(){
		if($(this).hasClass('collapsed'))
			$(this).html('<i class="fas fa-chevron-down"></i>');
		else
			$(this).html('<i class="fas fa-chevron-up"></i>');
	})
</script>

