<style type="text/css">
    #catalogs-block{
    	border: 1px solid #ddd;
    	position: relative;
    }
    .cb-item{
    	transition: 0.3s;
    	color: #333;
    	font-family: fnormal;
    	display: block;
        text-decoration: none;
        color: #1c1c1c;
        padding: .7em 1.6em .7em .8em;
        line-height: 1.4em;
    }
    .cb-item:not(:last-child){
    	border-bottom: 1px solid #ddd;
    }

    .cb-item i{
    	color: #999;
    }
    .cb-item:hover{
    	background-color: #f9f9f9;
    	color: #c7003d;
    }
    .cb-item:hover i{
    	color: #c7003d;
    	
    }
    a:hover{
    	text-decoration: none;
    }
    .cbc-blocks{
    	position: absolute;
    	top: -1px;
    	right: 0;
    	transform: translateX(100%);
    	background-color: #fff;
    	border: 1px solid #ddd;
    	z-index: 999;
    	height: 100%;
    }
    .cbc-block{
    	display: block;
    	color: #333;
    	font-family: fnormal;
        text-decoration: none;
        color: #1c1c1c;
        padding: .7em 1.6em .7em .8em;
        line-height: 1.4em;

    }
    .cbc-block:not(:last-child){
    	border-bottom: 1px solid #ddd;
    }
    .cbc-block:hover{
    	color: #c7003d;;
    }
	
</style>
<div id="catalogs-block">
@foreach($menu_catalogs->where('parent_id', 0) as $mc)

    <a class="cb-item p-3" href="{{ route('products', ['id' => $mc->id, 'alt_title' => $mc->alt_title]) }}" data-id="{{ $mc->id }}">
       	<div class="d-flex justify-content-between align-items-center">
     		<div> 

     			<img src="{{ $mc->mini_preview }}" alt="" style="max-width: 35px; max-height: 30px;">

       			{{ $mc->language->title }}	
      		</div>
     		<div>
    			<i class="fas fa-arrow-right"></i>
	   		</div>
	   	</div>
	</a>
	<div class="cbc-blocks d-none" id="cbc-blocks-{{ $mc->id }}">
	@foreach($mc->children as $mcc)
	    	<a href="{{ route('products', ['id' => $mcc->id, 'alt_title' => $mcc->alt_title]) }}" class="cbc-block p-3">{{ $mcc->language->title }}</a>
	@endforeach
	    </div>
@endforeach
</div>
<script type="text/javascript">
	$(document).on('mouseover', '.cb-item', function(){
		var id = $(this).data('id');
		$('.cbc-blocks').addClass('d-none');
		$('#cbc-blocks-' + id).removeClass('d-none');
	});
	$(document).on('mouseleave', '.cbc-blocks', function(){
		$(this).addClass('d-none');
	});
</script>