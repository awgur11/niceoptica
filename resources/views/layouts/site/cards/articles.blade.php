<style type="text/css">
	.art-card{
		padding: 15px;
		border: 1px solid #DCDCDC;
		display: block;
	}
	.art-block-big{
		padding: 0;
		border: 1px solid #DCDCDC;
		overflow: hidden;
		position: relative;
		height: 528px;
	}
	.art-block-big img{
		min-width: 100%;
		min-height: 100%;
	}
	.art-preview{
		position: relative;
		height: 210px;
		overflow: hidden;
		
	}
	.art-preview-big{
		height: 528px;
		overflow: hidden;
	}
	.art-preview img{
		position: absolute;
		top: 50%;
		left: 50%;
		transform: translate(-50%, -50%);
		width: 100%;
	}
	.art-title{
		font-family: Nunito Sans;
font-size: 24px;
font-style: normal;
font-weight: 400;
line-height: 29px;
letter-spacing: 0px;
text-align: left;
margin: 24px 0 16px 0;
height: 58px;
overflow: hidden;
color: #202020;
	}
	.art-shot{
		font-family: Nunito Sans;
font-size: 18px;
font-style: normal;
font-weight: 400;
line-height: 27px;
letter-spacing: 0px;
text-align: left;
height: 108px;
overflow: hidden;
color: #5E5E5E;
	}
	.art-date{
		margin-top: 54px;
		font-family: Nunito Sans;
font-size: 18px;
font-style: normal;
font-weight: 400;
line-height: 27px;
letter-spacing: 0px;
text-align: left;
color: #898989;

	}
@media screen and (max-width:  768px) {
	.art-block:nth-child(2){
		border-bottom: 1px solid #DCDCDC;;
	}
	
}
</style>
@foreach($items as $item)
    @if($loop->first && Request::route() != null && Request::route()->getName() == 'index')
<a class="art-block-big p-0 col-lg-3 col-md-6 d-none d-md-block" style="overflow: hidden;" href="{{ route('page', ['alt_title' => $item->alt_title ]) }}">

			<img src="{{ $item->tree_preview }}" alt="">			

</a>
<div class="art-block col-lg-3 p-0 col-md-6 d-none d-md-block">
	<a class="art-card" href="{{ route('page', ['alt_title' => $item->alt_title ]) }}">
		<div class="art-date" style="margin-top: 54px;">
			{{ $item->created_at_custom }}
		</div>
		<div class="art-title">{{ $item->language->title }}</div>
		<div class="art-shot">
			{{ $item->language->content }}
		</div>
		<div class="art-preview">
		</div>
	</a>
</div>
<div class="art-block p-0 col-lg-3 col-md-6 d-md-none">
	<a class="art-card" href="{{ route('page', ['alt_title' => $item->alt_title ]) }}">
		<div class="art-preview">
			<img src="{{ $item->tree_preview }}" alt="">
		</div>
		<div class="art-title">{{ $item->language->title }}</div>
		<div class="art-shot">
			{{ $item->language->content }}
		</div>
		<div class="art-date">
			{{ $item->created_at_custom }}
		</div>
	</a>
</div>

    @else
<div class="art-block p-0 col-lg-3 col-md-6">
	<a class="art-card" href="{{ route('page', ['alt_title' => $item->alt_title ]) }}">
		<div class="art-preview">
			<img src="{{ $item->tree_preview }}" alt="">
		</div>
		<div class="art-title">{{ $item->language->title }}</div>
		<div class="art-shot">
			{{ $item->language->content }}
		</div>
		<div class="art-date">
			{{ $item->created_at_custom }}
		</div>
	</a>
</div>
   @endif
@endforeach