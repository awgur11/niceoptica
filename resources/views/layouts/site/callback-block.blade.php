<style type="text/css">
	#callback-block{
		background-size: cover;
		background-position: center;
	}
	#callback-block h3{
		font-family: fbold;
		color: #333;
	}
	#callback-block p{
		font-size: fnormal;
		color: #333;
		font-size: 16px;
	}
	#callback-block a{
		color: #333;
		font-size: 20px;
		font-family: fnormal;
	}
</style>
<div class="container-fluid p-0" style="background-image: linear-gradient(#5bb3e634, #5bb3e634);">
<div class="container mt-5 py-5" id="callback-block" style="background-image:  url({{ $site_option['ing_block_bg']['fhd'] ?? null }});">
	<div class="row">
		<div class="col-lg-3 col-md-6 order-md-1 order-lg-1 text-center text-md-left">
			<img src="{{ $site_option['ing_block_img']['five'] ?? null }}" alt="" style="border-radius: 50%; max-width: 100%;">
		</div>
		<div class="col-lg-6 col-md-12 order-md-3 order-lg-2">
			<h3>{{ $site_option['ing_block_title'] ?? null }}</h3>
			<p>{{ $site_option['ing_block_subtitle'] ?? null }}</p>
			<div class="py-3 d-flex justify-content-around">
				<div data-target="#callbackModal" data-toggle="modal" class="btn btn-danger"><i class="far fa-question-circle"></i> @lang('ask a question')</div>
				<div>
					@foreach($messengers_links as $ml)
					<a href="{{ $ml['link'] }}">
						<img src="{{ $ml['icon']}}" alt="" style="width: 40px; border-radius:50%">
					</a>
					@endforeach
				</div>
			</div>
		</div>
		<div class="col-lg-3 col-md-6 order-md-2 order-lg-3 contacts">
			<h4>@lang('Phones')</h4>
			@foreach($site_option['phones'] as $phone)
			<div class="my-2">
			    <a href="tel:{{ $phone['phone'] ?? null }}">
					{{ $phone['phone'] ?? null }}
				</a>
			</div>
			@endforeach
			<div class="my-2">
				<h4>Email</h4>
				{{ $site_option['site_email'] ?? null }}
			</div>
		</div>
	</div>
</div>
</div>