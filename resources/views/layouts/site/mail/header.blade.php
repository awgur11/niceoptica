<div style="padding: 5px 20px; background-color: #F1F4FF;; color: #333; font-weight: 600; text-align: center; border:1px solid #2C50F2;">
    @isset($site_option['firm_logo']['five'])
		<img src="{{ $site_option['firm_logo']['five'] }}" style="max-height: 50px; max-width:200px;">
	@else
	    <h1 class="text-center">{{ env('APP_NAME', '') }}</h1>
    @endisset
	</div>