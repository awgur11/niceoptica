<style type="text/css">
	#footer{
		padding: 32px 26px;
		background: #F8F8F8;
		margin-top: 124px;
	}
	#footer-desc-logo{
		width: 170px;
	}
	#footer-address{
		font-family: Nunito Sans;
font-size: 16px;
font-style: normal;
font-weight: 400;
line-height: 19px;
letter-spacing: 0px;
text-align: left;
color: #202020;
	}
	#footer-address i{
		margin-right: 12px;
	}
	#footer-phones{
		font-family: Nunito Sans;
font-size: 16px;
font-style: normal;
font-weight: 400;
line-height: 19px;
letter-spacing: 0px;
text-align: left;
margin-top: 33px;
color: #202020;
	}
	#footer-phones .fp-item{
		display: block;
		color: #202020;
	}
	#footer-phones  i{
		margin-right: 12px;
	}
	#footer-all-rights{
		font-family: Arial;
font-size: 16px;
font-style: normal;
font-weight: 400;
line-height: 18px;
letter-spacing: 0em;
text-align: left;
color: #C4C4C4;
	}
	.footer-mp-item{
		padding: 0 16px;
		font-family: Nunito Sans;
font-size: 16px;
font-style: normal;
font-weight: 400;
line-height: 19px;
letter-spacing: 0px;
text-align: left;
color: #202020;
display: inline-block;
	}
@media screen and (max-width: 320px) {
	#footer{
		padding: 32px 15px;
	}
	#footer-desc-logo{
		width: 120px;
	}
}
</style>
<div class="container-fluid" id="footer">
	<div class="row">
		<div class="col-md-6">
			<div id="footer-address">
				<i class="fas fa-map-marker-alt"></i> {{ $site_option['address'] ?? null }}
			</div>
			<div id="footer-phones">
		@foreach($site_option['phones'] as $ph)
		         <a class="fp-item" href="tel: {{ $ph['phone'] }}">
		         	<i class="fas fa-phone-alt" @if(!$loop->first) style="opacity:0" @endif></i> {{ $ph['phone'] }}
		         </a>
		@endforeach				
			</div>
			<div id="footer-socialites" style="margin-top: 38px;" class="text-center text-md-left">
				@include('layouts.site.contacts.socialites')
			</div>
			
		</div>
		<div class="col-md-6 text-md-right text-center mt-5 mt-md-0" style="position: relative; top: -2px;">
	    @foreach($menu_pages as $mp)
	        <a href="{{ route('page', ['alt_title' => $mp->alt_title]) }}" class="footer-mp-item">
	        	{{ $mp->language->title }}
	        </a>
	    @endforeach
			
		</div>
	</div>
	<div class="row" style="margin-top:150px;">
		<div class="col-7">
			<div id="footerl-rights">
				© Niceoptica. 2021
			</div>
		</div>
		<div class="col-5 text-right">
			<img src="/images/Vector2.svg" alt="" id="footer-desc-logo" style=" max-width: 100%; transform: translateY(-2px);">
		</div>
	</div>
</div>