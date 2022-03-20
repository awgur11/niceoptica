@extends('admin.base')
@section('content')
<style type="text/css">
  .page-item{
    padding: 5px;
    margin-top: 20px;
    text-transform: uppercase;
    background-color: #fff;
    box-shadow: 2px 2px 2px rgba(0,0,0,.2);
  }
  .product-card{
    width: 20px;
    height: 20px;
    margin:5px;
    background-color: #ccc;
    display: inline-block;
  }
  .product-card.downloaded{
    background-color: #0bd43c;
  }
</style>
<div class="container  " style="margin-top: 30px; ">
    <div class="row" >
        <div class="col-sm-12">
            <div class="form-group">
              <label>Catalog id</label>
              <input type="number" name="catalog_id" id="catalog_id" value="9">
            </div>
            <div class="input-group mb-3">
              <input type="text" class="form-control" placeholder="url" id="url-input" value="https://www.bezpeka-plus.com.ua/news/index.php">
              <div class="input-group-append">
                <button class="btn btn-success" type="submit" id="start-button">
                  start
                </button>
              </div>
            </div>

        </div>
        <div class="col-sm-12" style="margin-top: 50px;">
            <h3>Pages</h3>
            <div id="pages-list">
 
            </div>
        </div>
        <div class="col-sm-12 text-center">
          <button class="btn btn-danger" id="save-cards">Save</button>
        </div>
    </div>
</div>
<script type="text/javascript">
/*
  $(document).on('click', '#start-button', function(){

    console.log('lr');
      
      setInterval(some_f, 1000);
});

  function some_f(){
    var pr = $('.product-card:not(.downloaded)').first();

    console.log(pr);

    if(pr == undefined)
      return false;

    var id = pr.attr('id'),
        href = pr.data('href'),
        catalog_id = $('#catalog_id').val();

        storing_card(id, href, catalog_id);
  }

*/


      function storing_card(id, href, catalog_id)
      {
        $.ajax({
            method: 'GET',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url: "/adminzone/pages/parser/store_article",
            data: {
                   href: href,
                   catalog_id: catalog_id
                 },
            success: function()
            {
              $('#' + id).addClass('downloaded')
            },
            error:  function(xhr, str)
            {
                alert('Error: ' + xhr.responseCode);
            }
        }); 
     }

    function store_card(page_id){
      $('#' + page_id + ' .product-card').each(function(){

  

        var id = $(this).attr('id'),
            href = $(this).data('href'),
            catalog_id = $('#catalog_id').val();


           setTimeout(storing_card, 1000, id, href, catalog_id);



      });
    }

    function scan_cards(){
      $('.page-item').each(function(){

        var id = $(this).attr('id'),
            href = $(this).data('href');
            console.log(id);

        $.ajax({
            method: 'GET',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url: "/adminzone/products/parser/cards",
            data: {href: href},
            success: function(cards)
            {
              cards.forEach(function(el, index){
                  $('#' + id + ' .products-list').append('<div data-href="' + el + '" class="product-card" id="' + id + '-product-item-' + index + '"></div>');
                 
              });

            //  setTimeout(store_card, 1000, id);
                store_card(id);
            },
            error:  function(xhr, str)
            {
                alert('Error: ' + xhr.responseCode);
            }
        }); 
      });
    }

    $(document).on('click', '#start-button', function(){
        var url = $('#url-input').val();

        $.ajax({
            method: 'GET',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url: "/adminzone/products/parser/pages",
            data: {url: url},
            success: function(pages)
            {
              pages.forEach(function(el, index){
                  $('#pages-list').append('<div data-href="' + el + '" class="page-item" id="page-item-' + index + '"><h5>' + el + '</h5><div class="products-list"></div></div>');
              });
              scan_cards();
              
              
                 
            },
            error:  function(xhr, str)
            {
                alert('Error: ' + xhr.responseCode);
            }
        });
    })
</script>


@endsection
