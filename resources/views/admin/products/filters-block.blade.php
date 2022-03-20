<style type="text/css">
  .filter-block{
    margin-bottom: 10px;
  }
  .filter-block:not(:last-child){
    padding-bottom: 10px;
    border-bottom: 1px solid #ddd;
  }
  #price-list-table th{
    vertical-align: middle;
    text-align: center;
  }
  #price-list-table input{
    min-width: 100px;
  }
</style>
<script type="text/javascript">
  $(document).on('click', '.input-checkbox', function(){
    var id = $(this).data('id');
    if($(this).prop('checked') == true)
    {
      price = $('.input-price-' + id).attr('placeholder');
      $('.input-price-' + id).val(price);

    }
    else
    {
      price = $('.input-price-' + id).val();
      $('.input-price-' + id).val('').attr('placeholder', price);
    }

  });
  $(document).on('click', '.select-all-values', function(){
    var filter_id = $(this).data('filter_id');
    $('.fvalues-block-' + filter_id).find('.value-item').prop('checked', true);

    $(this).removeClass('btn-success select-all-values').addClass('btn-outline-danger cancel-all-values').text("@lang('Cancel all')");
    prepare_data_for_pricelist_table();
  });
  $(document).on('click', '.cancel-all-values', function(){
    var filter_id = $(this).data('filter_id');
    $('.fvalues-block-' + filter_id).find('.value-item').prop('checked', false);

    $(this).addClass('btn-outline-success select-all-values').removeClass('btn-outline-danger cancel-all-values').text("@lang('Select all')");
      prepare_data_for_pricelist_table();
  });
  $(document).on('click', '.pr-checkbox, .value-item', function(){
    prepare_data_for_pricelist_table();
  });
  function prepare_data_for_pricelist_table()
  {
        if($('.pr-checkbox:checked').length == 2)
    {
      $('.pr-checkbox:not(:checked)').prop('disabled', true);
    }
    else
    {
      $('.pr-checkbox:not(:checked)').prop('disabled', false);
    }

    if($('.pr-checkbox:checked').length >= 1)
      $('#pricelist-block').removeClass('d-none');
    else
      $('#pricelist-block').addClass('d-none');

    var params_obj_1 = [],
        params_obj_2 = [];

    if($('.pr-checkbox:checked').length > 0)
    {
      var filter_id = $('.pr-checkbox:checked').first().data('filter_id');

          $('.fvalues' + filter_id + ':checked').each(function(index){
            fvalue_id = $(this).data('fvalue_id');
            title = $(this).data('fvalue_title');
            params_obj_1[index] = {
              'fvalue_id' : fvalue_id,
              'title': title
            };
            
          });
       //   console.log(params_obj_1);

    }

    if($('.pr-checkbox:checked').length == 2)
    {
      var filter_id = $('.pr-checkbox:checked').eq(1).data('filter_id');

          $('.fvalues' + filter_id + ':checked').each(function(index){
            fvalue_id = $(this).data('fvalue_id');
            title = $(this).data('fvalue_title');
            params_obj_2[index] = {
              'fvalue_id' : fvalue_id,
              'title': title
            };

            
          });
          
    }

    if(params_obj_1.length == 0)
    {
      params_obj_1 = null;
    }

    if(params_obj_2.length == 0)
    {
      params_obj_2 = new Array({'fvalue_id': 0, 'title': ''});
    }
    create_price_list_table(params_obj_1, params_obj_2);
  }

  $(function(){
  //  create_price_list_table({2: 1.5, 3: 2.0, 4: 3.5}, {5: 'красный',8: 'синий'});
  });

@isset($product)
  $(function(){
    prepare_data_for_pricelist_table();
  });
@endisset
  function create_price_list_table(
    params_obj_1 = null, 
    params_obj_2 = new Array({'fvalue_id': 0, 'title': ''}), 
    values = {!! $product->pricelist_obj ?? '{}' !!})
  {
    var content = '';

    if(params_obj_1 != null)
    {
      content += '<tr><th></th>';
      console.log(params_obj_1);
      
      params_obj_1.forEach(function(el, index)
      {
        content += '<th>' + el.title + '</th>';
      });

      content += '</tr>';  

      console.log(params_obj_2);

      params_obj_2.forEach(function(el2, index)
      {

        content += "<tr>";
       
        var first_iteration = true;
        params_obj_1.forEach(function(el, index)
        {
          if(values[el.fvalue_id] != undefined && values[el.fvalue_id][el2.fvalue_id] != undefined)
          {
            value = values[el.fvalue_id][el2.fvalue_id];
          }
          else
            value = '';

          if(first_iteration)
            content += '<th>' + el2.title + '</th>';

          content += '<th><input type="number" step="0.01" min="0" class="form-control" name="pricelist[' + el.fvalue_id + '][' + el2.fvalue_id + ']" value="' + value + '"></th>';

          first_iteration = false;
        });
        content += "</tr>";
      });
      content += '</tr>';

      $('#price-list-table').html(content);

      add_titles_for_table();
    }
  }
  function add_titles_for_table()
  {
    table_width = $('#price-list-table tr th').length;

    top_title = $('.pr-checkbox:checked').first().data('filter_title');
    top_title_html = '<tr><th class="text-center" id="top_table_title" colspan="' + table_width + '">' + top_title + '</th></tr>';
    $('#price-list-table').prepend(top_title_html);

    if($('.pr-checkbox:checked').length == 2)
    {
      table_height = $('#price-list-table tr').length;
      side_title = $('.pr-checkbox:checked').eq(1).data('filter_title');
      side_title_html = '<th rowspan="' + table_height + '" style=""><p style="writing-mode: vertical-rl;text-orientation: mixed;transform: rotate(180deg); margin:0;">' + side_title + '</p></th>';

      $('#price-list-table').children('tr').first().prepend(side_title_html);
     
  //    $('#top_table_title').text(side_title + '/' + top_title);

    }

  }
</script>

<h3 class="text-center">@lang("Set product's filters")</h3>
<div class="row form-block p-2"> 
@foreach($catalog->filters as $filter)
  <div class="col-sm-12 filter-block"> 
    <div class="row">
      <div class="col-md-6">
        <p style="letter-spacing: 2px;"><b>{{ $filter->language->title }}:</b></p>
      </div>
      <div class="col-md-3">
        <button type="button" class="btn btn-sm btn-outline-success select-all-values" data-filter_id="{{ $filter->id }}" > @lang('Select all')</button>
      </div>
      <div class="col-md-3">
        <label><input type="checkbox" class="pr-checkbox" data-filter_id="{{ $filter->id }}" title="@lang('The value of this filter will affect the price of the product. You can choose two filters for one product')" data-filter_title="{{ $filter->language->title }}" @if(isset($product) && ($product->pricelist_filter_id1 == $filter->id || $product->pricelist_filter_id2 == $filter->id)) checked @endif> Прайс лист</label>
      </div>
    </div>
    <div class="fvalues-block-{{ $filter->id }} col-sm-12">
    @foreach($catalog->fvalues->where('filter_id', $filter->id) as $fvalue)
      <div class="form-check-inline">
        <label class="form-check-label"><input type="checkbox" name="fvalues[]" class="fvalues{{ $filter->id }} value-item" value="{{ $fvalue->id }}" @if(isset($product) && in_array($fvalue->id, $product->fvalues()->pluck('fvalues.id')->toArray())) checked @endif class="form-check-input" data-fvalue_id="{{ $fvalue->id }}" data-fvalue_title="{{ $fvalue->language->title }}"> {{ $fvalue->language->title }}</label>
      </div>
    @endforeach
      <button type="button" class="btn btn-outline-primary btn-sm create-fvalue-button" data-filter_id="{{ $filter->id }}" id="create-fvalue-button-{{ $filter->id }}" data-catalog_id="{{ $catalog->id }}" data-toggle="modal" data-target="#addFilterValue" style="border-radius: 50%;"><span class="glyphicon glyphicon-plus"></span> <i class="fas fa-plus"></i></button>
    </div>

  </div>
@endforeach
</div>
<div class="row  form-block d-none mt-2 p-2" id="pricelist-block">
  <div class="col-12">
    <h3 class="text-center">@lang('Price list')</h3>
    <p class="text-success"><b>@lang('Attention')!!</b> @lang('Before filling in the table, specify all the filter values')</p>
  </div>
  <div id="price-list-content" class="table-responsive">
    <table class="table table-bordered" id="price-list-table" style="margin-bottom: 0;">
      
    </table>
  </div>
</div>

<script type="text/javascript">
  $(document).on('click', '.create-fvalue-button', function(){
    var filter_id = $(this).data('filter_id');

    $('#create-fvalue-button-with-data').data('filter_id', filter_id);
  });

  function create_fvalue_ajax()
  {
    var filter_id = $('#create-fvalue-button-with-data').data('filter_id'),
        catalog_id = $('#create-fvalue-button-with-data').data('catalog_id'),
        languages = [];

        $('.languages-fvalue-input-add').each(function(index){
          locale = $(this).data('locale');
          value = $(this).val();
          languages[index] = [];
          languages[index] = {
            "language": locale,
            "title": value,
          };
          
        });
        console.log(languages);

    $.ajax({
      method: 'POST',
      headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
      url: "{{ route('fvalues.store.ajax') }}",
      dataType: 'json', 
      data: {
        filter_id: filter_id,
        catalog_id: catalog_id,
        languages: languages
      },
      success: function(data)
      {
        $('#addFilterValue .close').click();

        $('#fvalue-input-add').val('');

        $('#create-fvalue-button-' + filter_id).before('<div class="form-check-inline"><label class="form-check-label"><input type="checkbox" name="fvalues[]" class="fvalues' + data.filter_id + ' value-item" value="' + data.id + '" checked  class="form-check-input" data-fvalue_id="'+ data.id + '" data-fvalue_title="' + data.language.title + '"> ' + data.language.title + '</label></div>');

        prepare_data_for_pricelist_table();
      },
      error:  function(xhr, str)
      {
        alert('Error: ' + xhr.responseCode);
      }
    });
      
  }
</script>


<!-- Create filter value modal -->
<div id="addFilterValue" class="modal fade"  role="dialog">
  <div class="modal-dialog">
 
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">@lang('Add Filter value')</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div> 
      <div class="modal-body">
    @foreach($site_languages as $sl)
        <div class="input-group mb-3">
          <input type="text" class="form-control languages-fvalue-input-add" placeholder="{{ $sl->title }}" name="" data-locale="{{ $sl->locale }}" id="fvalue-input-add">
        </div>
    @endforeach

        <div class="input-group mb-2">
          <button class="btn btn-success" id="create-fvalue-button-with-data" data-catalog_id="{{ $catalog->id }}" data-filter_id="" type="button" onclick="create_fvalue_ajax()">@lang('Add')</button>
        </div>
      </div>
    </div>

  </div>
</div>

