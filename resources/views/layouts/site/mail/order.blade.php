<div style="padding: 10px;  color: #333; margin: 20px 0; border: 1px solid #ddd;">
		<table style="width: 100%;">
			<?php $total = 0; ?> 
		@foreach($order as $item)
		    <?php $total += $item['count']*$item['price']; ?>
			<tr style="">
				<td style="border-bottom: 1px solid #ddd; padding: 6px;"><img src="{{ $item['product']['picture']['five_preview'] }}" style="width: 80px;" /></td>
				<td style="border-bottom: 1px solid #ddd; padding: 6px;">
					<b>{{ $item['product']['language']['title'] }}</b><br/>
					{{ $item['count'] }}х{{ $item['price'] }} грн
				</td>
			</tr>
		@endforeach
		    <tr>
		    	<td style="border-bottom: 1px solid #ddd; padding: 6px;">
		    	   <b> @lang('Sum'):</b>
		    	</td>
		    	<td style="border-bottom: 1px solid #ddd; padding: 6px; text-align: right;">
		    		<b>{{ $total }} грн</b>
		    	</td>
		    </tr>
		    <tr>
		    	<td style="border-bottom: 1px solid #ddd; padding: 6px;">
		    	   <b> @lang('Members discount'):</b>
		    	</td>
		    	<td style="border-bottom: 1px solid #ddd; padding: 6px; text-align: right;">
		    		<b>-{{ $loyalty_percent }}%</b>
		    	</td>
		    </tr>
		    <tr>
		    	<td style="text-align: right; background-color: #f3f3f3; padding:5px" colspan="2">
		    		@lang('Total'): <b>{{ $total*(1-$loyalty_percent/100) }}</b> грн
		    	</td>
		    </tr>
		</table>
	</div>