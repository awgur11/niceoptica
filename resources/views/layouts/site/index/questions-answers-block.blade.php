<style type="text/css">
	#accordion .card-link .plus{
		font-size: 30px;
		transition: 0.5s;
		display: inline-block;
		transform: rotate(45deg);
		color: #ff8300;

	}
	#accordion .card-link.collapsed .plus{
		transform: rotate(0);
		color: #000;
	}
	#accordion .card{
		border-radius: 0;
	}
	#accordion .card-body{
		border-bottom: none;
	}
	#accordion .card-body span,
	#accordion .card-body p{
		font-family: fnormal!important;
		font-size: 16px!important;
	}
	#accordion .card a {
		color: #333;
		font-family: fbold;
	}
	#accordion .card-header{
		border-bottom: none;
		background-color: #fff;
	}
	#accordion .card:not(:last-child){
		border-bottom: none;
	}

</style>
<div class="container">
	<div class="row">
		<div class="col-12">
			<h2 class="block-title">Frequently Asked Questions</h2>
		</div>
	</div>
	<div class="row">
		<div class="col-12">
			<div id="accordion">
			@foreach($qas as $q)
                <div class="card">
                    <div class="card-header">
                        <a class="card-link d-flex justify-content-between align-items-center @if(!$loop->first) collapsed @endif" data-toggle="collapse" href="#collapse{{ $loop->index }}">
                            <span>{{ $q->language->title ?? null }}</span><span class="plus">+</span>
                        </a>
                    </div>
                    <div id="collapse{{ $loop->index }}" class="collapse @if($loop->first) show @endif" data-parent="#accordion">
                        <div class="card-body">
                            {!! $q->language->text1 ?? null !!}
                        </div>
                    </div>
                </div>
            @endforeach
            </div>  
		</div>
	</div>
</div>