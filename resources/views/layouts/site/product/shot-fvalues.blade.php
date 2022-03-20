<style type="text/css">
	.area-item{
		display: block;
		padding: 5px;
		border: 1px solid #ddd;
		margin: 0 10px;
		color: #333;
		background: #5bb3e634;
		font-family: fnormal;
	}
	.area-item.active{
		background: #3481be;
		color: #fff;
		font-family: fbold;
		border: 1px solid #3481be;
		pointer-events: none;
	}
	.shot-fvalues td{
		padding: 5px;
		vertical-align: middle;
		width: 50%;
	}
	.shot-fvalues tr td:first-child{
		font-family: fbold;
		color: #333;
	}
	.shot-fvalues tr td:nth-child(2){
		font-family: fitalic;
		color: #666;
	}
@media screen and (max-width: 580px) {
	.shot-fvalues tr td{
		font-size: 12px;
	}

	
}
</style>
@if(count($area_items) > 1)
<div class="py-2">
	<h5>Обслуживаемая площадь (м2)</h5>
	<div class="d-flex">
	@foreach($area_items->unique() as $ai)
		<a href="{{ route('product', ['id_catalog' => $ai->catalog->id, 'alt_catalog' => $ai->catalog->alt_title, 'id' => $ai->id, 'alt_title' => $ai->alt_title]) }}" class="area-item @if(route('product', ['id_catalog' => $ai->catalog->id, 'alt_catalog' => $ai->catalog->alt_title, 'id' => $ai->id, 'alt_title' => $ai->alt_title]) == url()->current()) active @endif">{{ $ai->area }}</a>
	@endforeach
	</div>
</div>
@endif
<table class="table shot-fvalues">
@foreach($product->catalog->filters->where('active', 1) as $filter)
    @if($product->fvalues->where('filter_id', $filter->id)->count() >0)
	<tr>
       	<td>{{ $filter->language->title.':' }}</td>
       	<td>
   		@foreach($product->fvalues->where('filter_id', $filter->id)->unique() as $fvalue)
    		{{ $fvalue->language->title }}
  		@endforeach
      	</td>
    </tr>
	@endif
@endforeach
</table>
<!--
<div class="py-3 text-center">
	<a href="#" style="border-bottom: 1px dashed #333; color: #c7003d; font-family: fnormal;">@lang('All characteristics')</a>
</div>-->