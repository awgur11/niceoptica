@extends('admin.base')

@section('content')

<style type="text/css">
    .filter-li{
        padding: 5px;
        margin-bottom: 5px;
        box-shadow: 0 0 2px rgba(0,0,0,.3);
        transition: box-shadow 0.3s;
    }
    .filter-li:hover{
        box-shadow: 2px 2px 15px rgba(0,0,0,.1);
    }
    .filter-li label.checkbox-inline{
        margin-left: 15px;
        margin-bottom: 3px;
    }
    .fvalue-li{
        padding: 5px 5px 5px 25px;
    }
</style>

@include('layouts.admin.header', ['title' => 'Фильтры и значения', 'content' => 'Создание/редактирование фильтров и их значений'])

<div class="container" >
    <div class="row justify-content-end mb-3">
        <div class="col-sm-3">
            <button type="button" class="btn btn-outline-primary add-filter-button" data-toggle="modal" data-target="#addFilter"><i class="far fa-plus-square"></i> @lang('Filter')</button>
        </div>
    <!--    <div class="col-sm-3">
            <button type="button" class="btn btn-outline-success" data-toggle="modal" data-target="#fvalueModal"><i class="far fa-plus-square"></i> @lang('Filter value')</button>
        </div>-->
    </div>

    <div class="admin-content row">
        <div class="sorting-items" data-model="Filter">
@foreach($filters as $filter)
            <div id="item-{{ $filter->id }}" class="filter-li">
                <span class="btn btn-outline-info btn-sm item-position" data-column="position" data-value="{{ $loop->iteration }}" data-table="filters" data-id="{{ $filter->id }}" data-toggle="tooltip" title="@lang('Move')"><i class="fas fa-arrows-alt"></i></span>
                <span class="btn btn-info btn-sm"> {{ $filter->language->title }}</span> 
                <span class="btn btn-outline-primary btn-sm edit-filter" data-toggle="modal" data-target="#addFilter" title="@lang('Edit')" data-modal_title="@lang('Edit filter')" data-action="{{ route('filters.update', ['id' => $filter->id]) }}" data-edit="{{ route('filters.edit', ['id' => $filter->id]) }}"><i class="fas fa-pencil-alt"></i></span>
                <span class="btn btn-outline-danger delete-item btn-sm" data-url="{{ route('filters.delete', ['id' => $filter->id]) }}" data-id="{{ $filter->id }}"><i class="far fa-trash-alt"></i> </span>
                <button data-toggle="collapse" data-target="#fvalues-{{ $filter->id }}" class="btn btn-outline-warning btn-sm download-first-fvalues" title="@lang('Filters value')" data-filter_id="{{ $filter->id }}" ><i class="fas fa-chevron-down"></i></button>
                <button class="btn btn-outline-success btn-sm add-fvalue" data-filter_id="{{ $filter->id }}" data-toggle="modal" data-target="#fvalueModal"><span class="glyphicon glyphicon-plus " title="@lang('Add filter value')"><i class="far fa-plus-square"></i></button>
                <label class="checkbox-inline"><input type="checkbox" value="1" name="active" class="change_checkbox_ajax" data-id="{{ $filter->id }}" data-table="filters" data-column="active" @if($filter->active == 1) checked @endif> @lang('Activate')</label>
                <label class="checkbox-inline" title="@lang('This filter value will be selected by the user before adding the product to the cart. Actually when the product has several values of one filter, for example, one product can be of several colors and the user can select the color he needs and add the product to the cart.')"><input type="checkbox" value="1" name="for_cart" class="change_checkbox_ajax" data-id="{{$filter->id}}" data-table="filters" data-column="for_cart" @if($filter->for_cart == 1) checked @endif> @lang('For cart')</label>
                <label class="checkbox-inline" title="@lang('This filter value will be used for google merchant')"><input type="checkbox" value="1" name="merchant" class="change_checkbox_ajax" data-id="{{ $filter->id }}" data-table="filters" data-column="merchant" @if($filter->merchant == 1) checked @endif> Google merchant</label>
               
                <div id="fvalues-{{ $filter->id }}" class="collapse">
                    <div class="fvalues-list  sorting-items" data-model="Fvalue">

                    </div>
                    <div class="p-2 my-4 fvalues-panel bg-light d-flex">
        @if($filter->fvalues->count() > 20)
                        <button class="btn btn-sm btn-info show-all-fvalues-button" data-filter_id="{{ $filter->id }}" data-offset="20" id="show-all-fvalues-button-{{ $filter->id}}">
                            @lang('Show all values') <span class="badge badge-info">{{ $filter->fvalues->count() }}</span>
                        </button>
        @endif


                        <select class="form-control form-control-sm col-4 ml-1 arrange-fvalues-auto" data-filter_id="{{ $filter->id }}">
                            <option>@lang('Arrange automatically')</option>
                            <option value="">@lang('Ascending')</option>
                            <option value="DESC">@lang('Descending')</option>
                        </select>

                     
                    </div>
                  
                </div>
            </div>
@endforeach
        </div>
    </div>
    <div class="row align-items-center justify-content-center py-5">
            {{ $filters->onEachSide(0)->links('vendor.pagination.bootstrap-4') }}
    </div>
</div>

<script type="text/javascript">
    $(document).on('click', '.download-first-fvalues', function(){


        var filter_id = $(this).data('filter_id');

        if($('#fvalues-' + filter_id + ' .fvalues-list').html().trim() != '')
            return false;

        $.ajax({
            url: "{{ route('fvalues.get.by.ajax')}}",
            method: 'GET',
            dataType: 'json',
            data: {
                filter_id: filter_id,
                limit: 20,
            },
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            success: function(fvalues){

                fvalues.forEach(function(el){
                    $('#fvalues-' + filter_id + ' .fvalues-list').append(createFvalueRow(el));
                });
            },
            error: function(error){
                console.log(error);
            },
        });
    })
    $(document).on('change', '.arrange-fvalues-auto', function(){
        var filter_id = $(this).data('filter_id'),
            direction = $(this).val();

        $.ajax({
            url: "{{ route('fvalues.arrange.auto') }}",
            method: 'GET',
            dataType: 'json',
            data: {
                filter_id: filter_id,
                direction: direction,
            },
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            success: function(fvalues){
                $('#show-all-fvalues-button-' + filter_id).remove();
                $('#fvalues-' + filter_id + ' .fvalues-list').html('');
                fvalues.forEach(function(el){
                    $('#fvalues-' + filter_id + ' .fvalues-list').append(createFvalueRow(el));
                });
                
            },
            error: function(error){
                console.log(error);
            },
        });
    });
    function createFvalueRow(el)
    {
        return '\
            <div class="fvalue-li" id="item-' + el.filter_id + 'X' + el.id + '">\
                <span class="btn btn-outline-info btn-sm item-position" data-table="fvalues" data-column="position" data-id="' + el.id + '" data-toggle="tooltip" title="@lang('Move')"><i class="fas fa-arrows-alt"></i></span>\
                <span class="btn btn-info btn-sm">' + el.language.title + '</span>\
                <span class="btn btn-outline-primary btn-sm edit-fvalue" data-toggle="modal" data-target="#fvalueModal" data-modal_title="@lang('Edit filter value')" data-action="' + el.update + '" data-edit="' + el.edit + '" data-filter_id="' + el.filter_id + '"><i class="fas fa-pencil-alt"></i> </span>\
                <span class="btn btn-outline-danger delete-item btn-sm" data-url="' + el.delete + '" data-id="' + el.filter_id + 'X' + el.id + '"><i class="far fa-trash-alt"></i> </span>\
            </div>\ ';
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
                $('#show-all-fvalues-button-' + data.filter_id).remove();
                fvalues.forEach(function(el){
                    $('#fvalues-' + el.filter_id + ' .fvalues-list').append(createFvalueRow(el));
                });
            },
            error: function(error){
                console.log(error);
            },
        });
    });


    $(document).on('click', '.add-fvalue, .edit-fvalue', function(){

        $('#fvalueModal .img-thumbnail').attr('src', '/storage/images/no-photo.jpg');

                $('#fvalueModal #old_path').val('');
                $('#fvalueModal #old_name').val('');

        filter_id = $(this).data('filter_id');

        $('#fvalueModal select').val(filter_id);

        $('.languages-title').val('');

        $('#fvalue-create-form').attr('action', "{{ route('fvalues.store') }}")
    });
    $(document).on('click', '.edit-fvalue', function(){
        var data = $(this).data();

        $('#fvalueModal h5').text(data.modal_title);
        $('#fvalueModal form').attr('action', data.action);

        console.log(data.edit);

        $.ajax({
            url: data.edit,
            method: 'GET',
        //  dataType: 'json',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            error: function(error){
                console.log(error);
                //$('.alert.alert-danger').alert().html('<p>' + error.responseJSON.message + '</p>');
            },
            success: function(data){

                $('#fvalueModal #titlefvalue').val(data.title);
                $('#fvalueModal .img-thumbnail').attr('src', '/storage/images/' + data.preview_path + data.preview_name);

                $('#fvalueModal #old_path').val(data.preview_path);
                $('#fvalueModal #old_name').val(data.preview_name);
 
                data.languages.forEach(function(el){
                    $('#fvalueModal #languages-title-' + el.language).val(el.title);
                });
            }
        });
    });
    
    $(document).on('click', '.add-filter-button', function(){
        $('#addFilter h5').text('Создать фильтр');
        
        $('#addFilter form').attr('action', "{{ route('filters.store') }}");

        $('#addFilter .form-control, #addFilter .form-control').val('');

    });
    
    $(document).on('click', '.edit-filter', function(){
        var data = $(this).data();

        $('#addFilter h5').text(data.modal_title);

        $('#addFilter form').attr('action', data.action);
    
        $.ajax({
            url: data.edit,
            method: 'GET',
        //  dataType: 'json',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            error: function(error){
                console.log(error);
                //$('.alert.alert-danger').alert().html('<p>' + error.responseJSON.message + '</p>');
            },
            success: function(data){
                console.log(data);

                $('#addFilter #titlefilter').val(data.title);


 
                data.languages.forEach(function(el){
                    $('#addFilter #languages-title-' + el.language).val(el.title);
                });
            }
        });
    });
</script>

<!-- MODAL -->
<div id="addFilter" class="modal fade" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
        <div class="modal-content col-sm-12" style="padding:0;">
            <div class="modal-header">
                <h5 class="modal-title">@lang('Add Filter')</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body block-body ">
                @include('layouts.admin.form.form-start', ['action' => route('filters.store'), 'id' => 'filter-create-form'])

                @include('layouts.admin.form.form-input', ['title' => 'Title', 'name' => 'title', 'required' => 'required' , 'prefix_id' => 'filter'])
          
                @include('layouts.admin.form.form-end')
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">@lang('Close')</button>
            </div>
        </div>
    </div>
</div>

<!-- MODAL -->
<div id="fvalueModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
        <div class="modal-content col-sm-12" style="padding:0;">
            <div class="modal-header">
                <h5 class="modal-title">@lang('Add Filter value')</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body block-body ">
                @include('layouts.admin.form.form-start', ['action' => route('fvalues.store'), 'id' => 'fvalue-create-form'])

                @include('layouts.admin.form.form-preview-block', ['name' => 'preview', 'file_type' => 'image'])

                @include('layouts.admin.form.form-input', ['title' => 'Filter value', 'name' => 'title', 'required' => 'required', 'prefix_id' => 'fvalue'])

                @include('layouts.admin.form.form-select', ['title' => 'Фильтр', 'name' => 'filter_id', 'option' => $filters, 'required' => 'required'])
          
                @include('layouts.admin.form.form-end')
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">@lang('Close')</button>
           </div>
        </div>
    </div>
</div>


@endsection