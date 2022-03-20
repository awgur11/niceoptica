<style type="text/css">
	#ch-table tr td:first-child{

		color: #333;
		font-family: fbold;
		font-size: 14px;
		padding: 5px;

	}
	#ch-table tr td:nth-child(2){
		color: #666;
		font-family: fitalic;
		font-size: 14px;
		padding: 5px;
	}

</style>
<!--<h4 class="mt-5" style="margin-bottom: 20px;">@lang("Specifications"):</h4>-->
<table class="table table-striped table-hover" id="ch-table">
@foreach($product->catalog->filters as $filter)
    @if($product->fvalues->where('filter_id', $filter->id)->count() == 0)
        @continue
    @endif
    <tr>
    	@if($filter->language != null)
    	<td>{{ $filter->language->title }}</td>
    	<td>{{ $product->fvalues->where('filter_id', $filter->id)->pluck('title')->implode(', ') }}</td>
    	@endif
    </tr>
@endforeach
</table>