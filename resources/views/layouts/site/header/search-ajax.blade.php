<style type="text/css">
    #search-form{
        position: relative;
        width: 100%;
        border-radius: 0;
        height: 40px;
    }
    #search-input{
        border-radius: 0;
        height: 40px;
        padding: 12px;
        position: relative;
    }
    #search-form .search-ajax-icon{
        position: absolute;
        top: 6px;
        right: 15px;
        width: 20px;
        height: 20px;
        font-size: 20px;
        z-index: 10px;
        color: #333;
        cursor: pointer;
  //  background: #333;
    }
    #search-input::placeholder{
        font-family: Nunito Sans;
        font-size: 16px;
        font-style: normal;
        font-weight: 400;
        line-height: 19px;
        letter-spacing: 0px;
        text-align: left;
    }

    #search-block-ajax{
        position: absolute;
        left: 0;
        top: 120%;
        width: 100%;
        z-index: 99;
        background: #fff;
        border: 1px solid #ddd;
        padding: 5px;
        display: none;
    }
    #search-block-ajax.active{
        display: block;
    }
    .search-item.row{
        padding: 5px 0;
        margin: 0;
        border-bottom: 1px dashed #ddd;
    }
    .search-item.row:not(:last-child){
        border-bottom: 1px dashed #ddd;

    }
    .search-item a{
        color: #666;
        font-family: fnormal;
        font-size: 15px;
        max-height: 4.2em;
        overflow: hidden;
        display: block;
    }
    .search-item .img-block{

        text-align: center;
    }
    .search-item img{
        height: auto;
        width: 80px;
       // max-width: 100%;
    }
    .search-item::first-letter{
        text-transform: uppercase;
    }
    .search-item:hover a{
        color: #000;
    }
    .search-item:hover{
       // background-color: #f9f9f9;

    }
    .search-item b{
        color: #2848da;
    }
    .search-item:hover a b{
        color: #2848da;
    }
    .search-title{
        font-size: 16px;
        font-family: Nunito Sans;
        letter-spacing: 2px;
        color: #000;
        font-style: normal;
    font-weight: 700;
        border-bottom: 1px solid #ddd;
        padding-bottom: 8px;
        padding-top: 5px;
        background-color: #F1F4FF;;
        text-align: center;
        
        
    }
@media screen and (max-width: 767px) {
    #search-block-ajax{
        width: 100%;
    }

    
}
</style>

<div id="search-form">
    <form method="GET" action="{{ route('search.ajax') }}" >
        <input type="text" style="border:1px solid #ddd;" name="string" id="search-input" class="form-control" placeholder="@lang('Search')..." id="search-input" required="" autocomplete="off" value="" >
        
    </form>
    <div class="search-ajax-icon">
            <i class="icon-Loupe"></i>
        </div>
    <div id="search-block-ajax">
    </div>
</div>

<script type="text/javascript">
$(function(){
    if($(window).width() < 740)
       $('#search-ajax-desc-block #search-form').appendTo('#serch-ajax-mobile-place'); 

    $('#search-form .search-ajax-icon').click(function(){
        {
            if($('#search-input').val().trim() != '')
                $('#search-form form').submit();
        }

    });
})
$(document).on('mouseleave', '#search-block-ajax', function(){
    $(this).removeClass('active');
}); 
$(document).on('focus, click', '#search-input', function(){
    if($('#search-block-ajax').html().trim() != '')
    {
        $('#search-block-ajax').addClass('active');
    }
});
$(document).on('focusout', '#search-input', function(){
    setTimeout(hide_search_block, 500);
    
});
function hide_search_block()
{
  //  $('#search-block-ajax').removeClass('active');

}
$(function(){
    $('#search-input').keypress(function (e) {
        var key = e.which;
        if(key == 13)  // the enter key code
        {
            $('#search-form').submit();
        }        
    });
});  
$(document).on('keyup', '#search-input', function(){
    
    var string = $(this).val();

    if(string.trim() == '' || string.trim().length == 1)
    {
        $('#search-block-ajax').html('').removeClass('active');
        return false;
    }
    
    $.ajax({
        method: 'GET',
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url: "{{ route('search.ajax') }}",
        data: { 
            string: string,
            ajax: 'ajax',
        },
        dataType: 'json',
        success: function(result)
        {
            var catalogs = '',
                products = '';

            $('#search-block-ajax').html('');

            result.catalogs.forEach(function(el, index){
                catalogs += '<div class="search-item p-2"><a href="' + el.link + '">' + el.language.title + '</div>';
            });

            if(catalogs != '')
            {
                catalogs = '<div class="search-title">@lang('Catalogs')</div>' + catalogs;
                $('#search-block-ajax').append(catalogs);
            }

            result.products.forEach(function(el, index){
                products += '<div class="search-item row align-items-center"><div class="img-block col-5 p-0 d-flex align-items-center justify-content-center"><img src="' + el.picture.five_preview + '" ></div><div class="col-7"><a href="' + el.link + '">' + el.language.title + '</a></div></div>';
            });

            if(products != '')
            {
                products = '<div class="search-title">@lang('Products')</div>' + products;
                $('#search-block-ajax').append(products);
            }

            if(products != '' || catalogs != '')
                $('#search-block-ajax').addClass('active');
            else
                $('#search-block-ajax').removeClass('active');

        },
        error: function(msg)
        {
            console.log(msg); 
        }
    });
});
</script>
