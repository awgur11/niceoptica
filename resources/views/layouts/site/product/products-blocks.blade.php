<style type="text/css">
	#pBlocks{
		padding: 5px;
		border-radius: 5px;
		background-color: #fff;
	//	box-shadow: 1px 1px 4px rgba(0,0,0,.4);
	}
	#pBlocks .pb-block{
		
	}
	.pb-head{

		padding: 10px;
		transition: 0.3s;
	}
	.pb-head:hover{
		background-color: #f3f3f3;
	}
	.pb-head>span{
		cursor: pointer;
	}
	.pb-block{
		margin-bottom: 10px;
		width: 100%;
		//min-height: 100px;

	}
	.pb-image{
		width: 50px;
		margin-right: 10px;
	}
	.pb-title{
		color: #333;
		font-family: fbold;
		font-size: 16px;
	}
	.pb-content p, .pb-content{
		color: #666;
		font-family: fnormal;
		font-size: 14px;
		
	}
	.pb-content{

	}
</style>
<div id="pBlocks" class="row">
@foreach($pBlocks as $pb)
    <div class="pb-block col-md-6 col-sm-12 d-flex align-items-center">
    	<div class="pb-head">
    	    <img src="{{ asset($pb->preview) }}" class="pb-image">
    	    
    	</div>
    	<div class="pb-content" >
    		{!! $pb->language->title !!}
    	</div>
    	
    </div>
@endforeach
</div>