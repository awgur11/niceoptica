@extends('admin.base')

@section('content')

@include('layouts.admin.header', ['title' => 'Товары', 'content' => 'Каталог "'.$catalog->language->title.'"'])

<div class="container-fluid" >
    <div class="row justify-content-end mb-3">
        <div class="col-md-4 ">
            <a href="{{ route('catalogs.index') }}" class="btn btn-outline-primary">
                <i class="fas fa-arrow-left"></i> @lang('Back')
            </a>
        </div>
        <div class="col-md-4">
            @include('admin.products.filter-select-block')
        </div>
    @if(auth()->user()->role == 'developer')
        <div class="col-md-2 text-right">
            <a href="{{ route('products.delete.all', ['catalog_id' => $catalog->id]) }}" class="btn btn-outline-danger">
                <i class="far fa-trash-alt"></i> @lang('Delete all')
            </a>
        </div>
    @endif
<!-- some changes -->
        <div class="col-md-2 text-right">
            <a href="{{ route('products.create', ['catalog_id' => $catalog->id]) }}" class="btn btn-outline-success">
                <i class="far fa-plus-square"></i> @lang('Create')
            </a>
        </div>
    </div>
    <div class="admin-content">
        <table class="table text-center" id="sortable-table">
            <thead>
                <tr>
                    <th></th>
                    <th>@lang('Picture')</th>
                    <th>@lang('Title')</th>
            <!--        <th>@lang('Price')<br><small class="text-info">@lang('Press Enter for saving')</small></th>
                    <th>@lang('Available')</th>-->
                    
                    <th>@lang('Public')</th>
                    <th>Новинки</th>
                    <th>Топ продаж</th>
                    <th>Разные глаза</th>
                    <th colspan="3"></th>
                </tr>
            </thead>
            <tbody>
            @forelse($products as $product)
                <tr id="item-{{$product->id}}">
                    <td class="item-position @if($loop->index == 0) item-position-first @endif" data-position="{{ $product->position == 0 ? $product->id : $product->position }}" data-table="products" data-id="{{ $product->id }}">
                         <span class="btn btn-outline-primary" data-toggle="tooltip" title="@lang('You can this move row')"><i class="fas fa-arrows-alt"></i></span>
                    </td>
                    <td>
                        <img src="{{ asset($product->picture->five_preview) }}" style="width:100px; max-height:100px; border-radius: 5px;" />
                    </td>
                    <td>{{ $product->language->title }}</td>
         <!--           <td>
                        @if($product->price != $product->final_price)
                        <small class="text-muted">{{ $product->final_price }}</small> грн
                        @endif
                        <input type="number" data-id="{{ $product->id }}" data-column="price" data-table="products" class="form-control form-control-sm change-input-ajax" value="{{ $product->price }}"></input>

                    </td>
                    <td> 
                        <select name="available" id="available" class="change-select-ajax form-control" data-id="{{ $product->id }}" data-table="products" data-column="available">
                            <option value="1" @if($product->available == 1) selected @endif>@lang('available')</option>
                            <option value="2" @if($product->available == 2) selected @endif>@lang('under the order')</option>
                            <option value="3" @if($product->available == 3) selected @endif>@lang('not available')</option>
                            <option value="4" @if($product->available == 4) selected @endif>@lang('expected')</option>
                            <option value="5" @if($product->available == 5) selected @endif>@lang('on request')</option>
                        </select>
                    </td>-->
 
                    <td class="text-center">
                        <label class="checkbox-inline"><input type="checkbox" value="1" name="public" class="change_checkbox_ajax" data-id="{{$product->id}}" data-table="products" data-column="public" @if($product->public == 1) checked @endif></label>
                    </td>  
                    <td class="text-center">
                        <label class="checkbox-inline"><input type="checkbox" value="1" name="hidden" class="change_checkbox_ajax" data-id="{{$product->id}}" data-table="products" data-column="novelty" @if($product->novelty == 1) checked @endif></label>
                    </td>
                    <td class="text-center">
                        <label class="checkbox-inline"><input type="checkbox" value="1" name="hidden" class="change_checkbox_ajax" data-id="{{$product->id}}" data-table="products" data-column="promo" @if($product->promo == 1) checked @endif></label>
                    </td> 
                    <td class="text-center">
                        <label class="checkbox-inline"><input type="checkbox" value="1"  class="change_checkbox_ajax" data-id="{{$product->id}}" data-table="products" data-column="different_eyes" @if($product->different_eyes == 1) checked @endif></label>
                    </td>
                    <td>
                        <a class="btn btn-outline-primary " href="{{ route('products.edit', ['id' => $product->id]) }}" >  <i class="fas fa-pencil-alt"></i></a>
                    </td>
                    <td> 
                        <span class="btn btn-outline-danger delete-item" data-url="{{ route('products.delete', ['id' => $product->id]) }}" data-id="{{ $product->id }}"> <i class="far fa-trash-alt"></i></span>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">
                        <h3 class="text-warning text-center">@lang('Empty')</h3>
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div> 
    <div class="row align-items-center justify-content-center">
            {{ $products->appends(app('request')->input())->onEachSide(0)->links('vendor.pagination.bootstrap-4') }}
    </div>
</div>
 

@endsection