<style type="text/css">
	#mcv-block{
		position: fixed;
		z-index: 9999;
		top: 45px;
		left: 0;
		width: 350px;
		max-width: 100%;
		background: #fff;
		height: 84vh;
		box-shadow: 10px 0 10px #5bb3e634;
		transition: 0.5s;
		transform: translateX(-120%);
		overflow: auto;
	}
	#mcv-block.show{
		transform: translateX(0);
	}
	.mvc-cat{
		font-family: fnormal;
	}
	.cat-open-button{
		font-size: 30px;
		color: #c7003d;;
		position: relative;
		top: -2px;
	}
	.mvc-cat-title{
		font-size: 18px;
		color: #333;
	}
	#mcv-block>.mvc-cat{
		border-bottom: 1px solid #ddd;
	}
</style>
<div id="mcv-block">
@foreach($menu_catalogs->where('parent_id', 0) as $mc)
	<div class="mvc-cat p-2 pr-4 d-flex justify-content-between align-items-center">
		<div >
		    <img src="{{ $mc->mini_preview }}" alt="" style="max-width: 35px; max-height: 30px;">
		    <a href="{{ route('products', ['id' => $mc->id, 'alt_title' => $mc->alt_title]) }}">
		       <span class="mvc-cat-title">{{ $mc->language->title }}</span>
		    </a>
	    </div>
	    <div class="cat-open-button" data-id="{{ $mc->id }}">+</div>
	</div>
	<div class="mvc-child-block d-none" id="mvc-child-block-{{ $mc->id }}">
	@foreach($mc->children as $ch)
	    <div class="mvc-cat p-2 pl-4">
	    	<a href="{{ route('products', ['id' => $ch->id, 'alt_title' => $ch->alt_title]) }}">
		       <span class="mvc-cat-title">{{ $ch->language->menu }}</span>
		    </a>	    	
	    </div>
	@endforeach
	</div>
@endforeach

    <div class="mvc-pages-block mt-5">
    @foreach($menu_pages as $mp)
        <div class="mvc-page-item p-3 text-center">
        	<a href="{{ route('page', ['alt_title' => $mp->alt_title]) }}">
        		{{ $mp->language->menu }}
        	</a>
        </div>
    @endforeach
    </div>
	
</div>
<style type="text/css">
	.mvc-page-item a{
		color: #333;
		font-size: 16px;
		font-family: fbold;
		text-transform: uppercase;
		letter-spacing: 2px;
	}
</style>
<script type="text/javascript">
	$(document).on('click', '.cat-open-button', function(){
		var id = $(this).data('id');

		if($(this).text() == '+')
		{
			$('#mvc-child-block-' + id).removeClass('d-none');
			$(this).text('-');
		}
		else
		{
			$('#mvc-child-block-' + id).addClass('d-none');
			$(this).text('+');
		}
	});
	$(document).on('click', '.open-side-menu-button', function(){
		if($('#mcv-block').hasClass('show'))
		{
			$('#mcv-block').removeClass('show');
			$(this).children('i').removeClass('fa-times').addClass('fa-bars');
		}
		else
		{
			$('#mcv-block').addClass('show');
			$(this).children('i').addClass('fa-times').removeClass('fa-bars');

		}

	})
</script>