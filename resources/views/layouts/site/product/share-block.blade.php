<style type="text/css">
    #shareBlock{
    	padding: 15px 0;

    }
    #shareBlock i{
    	color: #000;
    	font-size: 40px;
    	transition: 0.5s;
        display: inline-block;
        padding: 0 25px;
        border-radius: 10px;
    }
    #shareBlock i:hover{
    	color: #f609c8;
    }
</style>


<div id="shareBlock" class=" justify-content-center d-flex align-items-center">
<!--	<h5 class="p-2" style="color: #333;">@lang('Share'):</h5>-->
	<div class="">

        <a href="https://www.facebook.com/sharer.php?u={{ url()->current() }}&t={{ $product->language->title }}" target="_blank" class="share-link">
            <i class="ri-facebook-box-line"></i>
        </a>

        <a href="mailto:{{ $site_option['admin_email'][$csl] }}" class="share-link">
            <i class="ri-mail-send-fill"></i>
        </a>

        <a href="https://twitter.com/intent/tweet?url={{ url()->current() }}" class="share-link">
            <i class="ri-twitter-line"></i>
        </a>
    </div>

</div>


