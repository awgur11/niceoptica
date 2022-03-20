<?php

$catalog_id = isset($catalog) ? $catalog->id : 0;

?>
@if($filters->count() > 0)

<style type="text/css">
  .filter-block{
    padding-bottom: 10px;
    margin-bottom: 10px;
  }
  .filter-block:not(:last-child){
    border-bottom: 1px solid #ddd;
  }
  .filter-block .filter-title{
    padding: 10px 15px;
  }
  .filter-title-block{
    text-transform: lowercase;
    font-weight: bold;
    letter-spacing: 2px;
  }

  .fvalue-checkbox{
    padding: 5px;
    margin:5px;
    border:1px solid #ddd;
    background-color: #eee;
    cursor: pointer;
  }
  .fvalue-checkbox span{
    position: relative;
    top: -3px;
    margin-left: 6px;
    font-size: 9pt;
    color: #339;
  }
</style>
 
<h3 class="text-center">@lang('Select catalog`s filters')</h3>
<div class="form-block my-2 row d-flex align-items-center p-2">
@foreach($filters as $filter)
  <div class="col-sm-12 filter-block" id="filter-block-{{ $filter->id }}">
    <div class="filter-title d-flex justify-content-between">
      <label class="filter-title-block form-check-label"><input id="filter-checkbox-{{ $filter->id }}" type="checkbox" name="filters[]" value="{{ $filter->id }}" class="filter-checkbox" data-filter_id="{{ $filter->id }}"  @if(isset($catalog) && in_array($filter->id, $catalog->filters()->pluck('filters.id')->toArray())) checked @endif class="form-check-input"> {{ $filter->language->title }}</label>
      <button type="button" class="btn btn-outline-primary select-all-fvalues-button btn-sm @if(isset($catalog) && in_array($filter->id, $catalog->filters()->pluck('filters.id')->toArray())) @else d-none @endif" data-filter_id="{{ $filter->id }}" id="select-all-fvalues-button-{{ $filter->id }}">Выбрать всё</button>
    </div>
    <div class="fvalues-block @if(isset($catalog) && in_array($filter->id, $catalog->filters()->pluck('filters.id')->toArray())) @else d-none @endif" id="filter-block-fvalues-{{ $filter->id }}">
    @foreach($filter->fvalues as $fvalue)
      <label class="fvalue-checkbox"><input type="checkbox" id="fvalue-{{ $fvalue->id }}" value="{{ $fvalue->id }}"  name="fvalues[]" @if(isset($catalog) && in_array($fvalue->id, $catalog->fvalues()->pluck('fvalues.id')->toArray())) checked @endif name="filters[]" data-table="catalog_fvalue" data-col1="catalog_id" data-col2="fvalue_id" data-val1="{{ $catalog_id }}" data-val2="{{ $fvalue->id }}" onchange="change_pivot('fvalue-{{ $fvalue->id }}');"><span>{{ $fvalue->language->title }}</span></label>
             
    @endforeach
  @if($filter->fvalues->count() > 10000)
  <!--    <div id="show-all-fvalues-block-{{ $filter->id}}" class="py-5">
        <button type="button" class="btn btn-sm btn-outline-info show-all-fvalues-button" data-filter_id="{{ $filter->id }}" data-offset="10" data-catalog_id = {{ $catalog_id }}>
           @lang('Show all values') <span class="badge badge-info">{{ $filter->fvalues->count() }}</span>
        </button>
      </div>-->
  @endif 

    </div>


  </div>
@endforeach

</div>
<script type="text/javascript">
  function change_pivot(id)
  {
    var data = $('#' + id).data();
    console.log($('#' + id).prop('checked'));
    data.checked = $('#' + id).prop('checked');


    $.ajax({
      url: "{{ route('change.pivot')}}",
      method: 'GET',
      data: data,
      headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
      success: function(fvalues){

      },
      error: function(error){
        console.log(error);
      },
    });
  }
  function insert_fvalues(filter_id, fvalues)
  {
    fvalues.forEach(function(el){
      $('#filter-block-fvalues-' + filter_id).append('\
          <label class="fvalue-checkbox">\
            <input type="checkbox" value="' + el.id + '" id="fvalue-' + el.id +'"  name="fvalues[]" ' + el.checked +' data-table="catalog_fvalue" data-col1="catalog_id" data-col2="fvalue_id" data-val1="{{ $catalog_id }}" data-val2="'+ el.id + '" onchange="change_pivot(\'fvalue-' + el.id + '\');"><span>' + el.language.title + '</span>\
          </label>\
      ');
    });
  }
      $(document).on('click', '.show-all-fvalues-button', function(){
        var data =  $(this).data();

        $.ajax({
            url: "{{ route('fvalues.get.by.ajax')}}",
            method: 'GET',
            dataType: 'json',
            data: data,
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            success: function(fvalues){
                $('#show-all-fvalues-block-' + data.filter_id).remove();

                insert_fvalues(data.filter_id, fvalues);
            },
            error: function(error){
                console.log(error);
            },
        });
    });
  $(document).on('click', '.select-all-fvalues-button', function(){
    var filter_id = $(this).data('filter_id');

    if($(this).hasClass('cancel-all-fvalues-button'))
    {
      $('#filter-block-' + filter_id + ' .fvalue-checkbox>input').prop('checked', false);
      $(this).removeClass('cancel-all-fvalues-button').removeClass('btn-outline-danger').text('Выбрать всё').addClass('btn-outline-primary');
    }
    else
    {
      $('#filter-block-' + filter_id + ' .fvalue-checkbox>input').prop('checked', true);
      $(this).addClass('cancel-all-fvalues-button btn-outline-danger').text('Отменить всё').removeClass('btn-outline-primary');
    }

  });

  $(document).on('change', '.filter-checkbox', function(){
    var filter_id = $(this).data('filter_id');

    if($(this).prop('checked'))
    {
      $('#filter-block-fvalues-' + filter_id).removeClass('d-none');
      $('#select-all-fvalues-button-' + filter_id).removeClass('d-none');
    }
    else
    {
      $('#filter-block-fvalues-' + filter_id).addClass('d-none');
      $('#select-all-fvalues-button-' + filter_id).addClass('d-none');
      $('#filter-block-' + filter_id + ' .fvalue-checkbox>input').prop('checked', false);
    }
  }); 
</script>

@endif