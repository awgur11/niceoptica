<style type="text/css">
	#slider-block{
		min-height: 400px;

	}
</style>
<div class="container" id="header">
	<div class="row row-eq-height">
		<div class="col-md-5 d-none d-lg-block col-lg-3">
			@include('layouts.site.header.menu-catalogs-vertical')

		</div>
		<div class="col-md-12 col-lg-9 px-0 px-lg-2">
			<div id="slider-block" style="height: 100%;">
				@include('layouts.site.slider')
			</div>
		</div>
	</div>
</div>
