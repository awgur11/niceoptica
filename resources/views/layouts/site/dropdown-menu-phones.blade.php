<style type="text/css">
    #dropdown-menu-phones{
    	display: inline-block;
    	cursor: pointer;
    	position: relative;
    	font-family: fnormal;
    	font-size: 18px;
    	letter-spacing: 2px;
    	padding: 8px 5px;
    }
    #dmp-block{
    	position: absolute;
    	background: #fff;

    	top: 0;
    	left: 0;
    	opacity: 0;
    	display: none;
        transition: 0.5s opacity, 0.5s transform;
        transform: translateY(10px);
        box-shadow: 0 0 1px rgba(0,0,0,0.3);
    }
    #dropdown-menu-phones:hover #dmp-block{
    	
    	display: block;
    	
    }
    #dropdown-menu-phones #dmp-block:hover{
    	transform: translateY(0px);
    	opacity: 1;

    }
    #dmp-block .dmp-item{
    	padding: 8px 5px;
    	transition: 0.3s;
    }
    #dmp-block .dmp-item:hover{
    	background-color: #42a01f34;
    }


	
</style>
<div id="dropdown-menu-phones" >
	{{ $site_option['phones'][0]['phone'] ?? null }}
	<div id="dmp-block">
	@foreach($site_option['phones'] as $phone)
	    <div class="dmp-item">
	    	{{ $phone['phone'] }}
		
	    </div>
	@endforeach
	</div>
</div>