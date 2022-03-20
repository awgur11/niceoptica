@extends('admin.base')

@section('content')

@include('layouts.admin.header', ['title' => 'Parser'])

<div class="container" style="">
  <div class="row  mb-3">
    <div class="col-12 ">
      <a href="{{ route('admin.index') }}" class="btn btn-outline-primary">
        <i class="fas fa-arrow-left"></i> Назад
      </a>
    </div>
  </div>
  <div class="admin-content">
    <div class="row form-block">
      <div class="col-2 pt-3 pb-2 text-right">Link:</div>
      <div class="col-10 py-2">
        <input type="text" class="form-control" id="link" name="link" value="https://dostavkalinz.com.ua/categories/kontaktnye-linzy/">
      </div>
      <div class="col-2 pt-3 pb-2 text-right">
        Catalog's id:
      </div>
      <div class="col-3 py-2">
        <input type="text" class="form-control" id="catalog_id" name="catalog_id">        
      </div>
      <div class="col-3 py-2">
        <button class="btn btn-primary" id="get-products-links-button">
          Get product`s links
        </button>
      </div>
      <div class="col-2 py-2">
        <button class="btn btn-primary" id="start-parsing-button">
          Start parsing
        </button>
      </div>
      <div class="col-2 py-2">
        <button class="btn btn-danger" id="pause-proceed-parsing-button">
          <i class="fas fa-pause"></i> Pause
        </button>
      </div>
    </div>

  </div>
</div>
<style type="text/css">
  .link-item:not(:first-child){
    border-top: 1px solid #ddd;
  }
  .link-item:hover{
    background-color: #f9f9f9;
  }
</style>
<div class="container">
  <div class="row">
    <div class="col-12">
      <h4 class="text-center">Monitor</h4>
    </div>
  </div>
  <div class="row">
    <div class="col-3">
      Rows count: <span id="monitor-rows-total-count">0</span>
    </div>
    <div class="col-3">
      Ready: <b id="monitor-rows-ready-count">-0</b>
    </div>
    <div class="col-3">
      Success: <span id="monitor-rows-success-count">-0</span>
    </div>
    <div class="col-3 ">
      Error: <b id="monitor-rows-errors-count" class="text-danger">-0</b>
    </div>
  </div>
</div>
<div class="container mt-5" id="links-container">
  
           
</div>
<!--  <b class="text-danger">X</b><i class="fas fa-check text-success"></i>-->
<script type="text/javascript">
  $(function(){
    setInterval(monitor, 5000);
   // monitor();
  });

  $(document).on('click', '#pause-proceed-parsing-button', function(){

    $.ajax({
      url: "{{ route('parser.pause.proceed') }}",
      method: 'GET',
      headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},

      success: function(response){
        if(response == 'pause')
        {
          $('#pause-proceed-parsing-button').html('<i class="fas fa-play"></i> Proceed').removeClass('btn-danger').addClass('btn-success');
        }
        else
        {
          $('#pause-proceed-parsing-button').html('<i class="fas fa-pause"></i> Pause').removeClass('btn-success').addClass('btn-danger');
        }
        $('#start-parsing-button').click();

      },
      error: function(error){

      }
    });

  })
  function monitor()
  {
    $.ajax({
      url: "{{ route('parser.monitor') }}",
      method: 'GET',
      headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},

      success: function(response){
        $('#monitor-rows-total-count').text(response.parser_total_rows);
        $('#monitor-rows-ready-count').text(response.parser_ready_rows);
        $('#monitor-rows-success-count').text(response.parser_success_rows);
        $('#monitor-rows-errors-count').text(response.parser_errors_rows);
      },
      error: function(error){

      }
    });

  }
  function save_product(id, catalog_id)
  {
    var link = $('#' + id + ' .link-text').text().trim();
    console.log(link);

    $.ajax({
      url: "{{ route('parser.save.product') }}",
      method: 'GET',
      headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
      dataType: 'json',
      data: {
        link: link,
        catalog_id: catalog_id
      },
      success: function(response){

        if(response.success)
        {
          $('#' + id + ' .link-success').html('<i class="fas fa-check text-success"></i>');
          $('#' + id).addClass('uploaded-successfully');
        }
        else
        {
          $('#' + id + ' .link-success').html('<b class="text-danger">X</b>');
          $('#' + id + ' .link-success b').attr('title', response.errors);
        }
      },
      error: function(error){

      }
    });
  }
  $(document).on('click', '#start-parsing-button', function(){
    $.ajax({
      url: "{{ route('parser.process') }}",
      method: 'GET',
      headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
      success: function(response){

      },
      error: function(error){

      }
    });
    /*$('#links-container .link-item:not(.uploaded-successfully)').each(function(index){
      var id = $(this).attr('id'),
          catalog_id = $('#catalog_id').val();

      setTimeout(save_product, index*10000, id, catalog_id)
    }); */
  });
  $(document).on('click', '#get-products-links-button', function(){

    var link = $('#link').val(),
        catalog_id = $('#catalog_id').val();

    if(catalog_id == '')
    {
      alert('Введите id каталога');
      return false;
    }
 
    $.ajax({
      url: "{{ route('parser.get.links') }}",
      method: 'GET',
      headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
      dataType: 'json',
      data: {
        link: link,
        catalog_id: catalog_id,
      },
      error: function(error){

      },
      success: function(links){

        $('#links-container').html('');

        links.forEach(function(value, index){
          $('#links-container').append('\
            <div class="row link-item py-3" id="link-item-' + index +'" >\
              <div class="col-1 link-number"><button class="btn btn-outline-success parser-this-item" data-id="'+ index +'">' + index +'</button></div>\
              <div class="col-8 link-text">' + value + '</div>\
              <div class="col-3 text-center link-success">\
              </div>\
            </div>');
        });

        $('#start-parsing-button').removeClass('d-none');
      }
    });
   
  });
  $(document).on('click', '.parser-this-item', function(){
    var id = 'link-item-' + $(this).data('id'),
        catalog_id = $('#catalog_id').val();

        save_product(id, catalog_id);
  })

</script>


@endsection