@extends('admin.base')

@section('content')
<script type="text/javascript">
  $(function(){
    $('.order-button').click(function(){
      var id = $(this).data('id');

      $('.order-block').addClass('d-none');
      $('#order-block-' + id).removeClass('d-none');

      $('.order-button.btn-primary').removeClass('btn-primary').addClass('btn-outline-primary');
      $(this).addClass('btn-primary').removeClass('btn-outline-primary');
    })
  });
  $(document).on('change', '.change-select-ajax', function(){
    if($(this).val() == 0)
      $(this).parent().parent().css('background-color', '#fbe9e9');
    else if($(this).val() == 1)
      $(this).parent().parent().css('background-color', '#e5f7e5');
    else
      $(this).parent().parent().css('background-color', '#ddd');

  });
</script>

@include('layouts.admin.header', ['title' => 'Заказы'])

<div class="container" >
  <div class="row justify-content-start mb-3">
    <div class="col-2">
      <a  class="btn btn-outline-success create-category-button" href="{{ route('admin.index') }}"><i class="fas fa-arrow-left"></i> @lang('Back')</a>
    </div>
<!--<div class="col-sm-6">
      include('layouts.admin.orders.google-sheets-upload-block')
    </div>-->
  </div>
</div>
<div class="container-fluid">
  <div class="admin-content">
    <div class="row">
      <div class="col-sm-8" style="height: 120vh;">
        <table class="table">
          <thead>
            <tr class="table-primary">
              <th>№</th>
              <th>@lang('User')</th>
              <th>@lang('Date')</th>
              <th>@lang('Status')</th>
              <th>@lang('Paid')</th>
              <th></th>
              <th></th>
          </thead>
          <tbody>

@forelse($orders as $order)
            <tr id="item-{{ $order->id }}" style="background-color: @if($order->status== 0) #fbe9e9 @elseif($order->status == 1) #e5f7e5 @else #ddd @endif; transition: 0.3s;">
              <td><b>{{ $order->id }}<b></td>
              <td>
                {{ $order->user->name ?? null }} {{ $order->user->lastname ?? null }}<br/>
                {{ $order->user->email ?? null }}<br/>
                {{ $order->user->phone ?? null }}
              </td>
              <td>{{ date('H:i d.m.Y', strtotime($order->created_at)) }}</td>
              <td class="status-td" >
                <select class="form-control input-sm change-select-ajax" data-id="{{ $order->id }}"  data-table="orders" data-column="status">
                  <option value="0" @if($order->status == 0) selected @endif>@lang('awaiting')</option>
                  <option value="1" @if($order->status == 1) selected @endif>@lang('in processing')</option>
                  <option value="2" @if($order->status == 2) selected @endif style="color:#900;">@lang('completed')</option>
                </select>
              </td>
              <td>
  @if($order->paid == 1)
                <span class="badge badge-pill badge-success">Yes</span>
  @else
                <span class="badge badge-pill badge-danger">No</span>
  @endif
              </td>
              <td>
                <button class="btn @if($loop->first) btn-primary @else btn-outline-primary @endif order-button" data-id="{{ $order->id }}">@lang('Order')</button>
              </td>
              <td>
                <span class="btn btn-outline-danger delete-item" data-url="{{ route('orders.delete', ['id' => $order->id]) }}" data-id="{{ $order->id }}"><i class="far fa-trash-alt"></i></span></span>
              </td>
            </tr>
@empty
            <tr>
              <th colspan="7" class="text-center">
                <h4>@lang("You don't have orders yet")</h4>
              </th>
            </tr>
@endforelse              
          </tbody>
          <tfoot>
            <tr>
              <td colspan="7" class="text-center">
                {{ $orders->links() }}
              </td>
            </tr>
          </tfoot>
        </table>
      </div>
<script type="text/javascript">
  $(function(){

    var width = $('#order-content-block').width(),
        pos = $('#order-content-block').offset().top;

    $('#order-content-block.fixed').css({'width': width});

    $(window).scroll(function() {
        var winTop = $(window).scrollTop();
            console.log(width);
        if(pos < winTop) {
          $('#order-content-block').addClass('fixed');
        }
        else if(pos >= winTop){
          $('#order-content-block').removeClass('fixed');
        }
    });
  });
</script>
<style type="text/css">
  #order-content-block{
    background-color: #fff;
        height: 100vh;
    overflow-y: auto;
  }
  #order-content-block.fixed{
    position: fixed;
    top: 0;
    right: 15px;


  }
</style>
      <div class="col-sm-4" id="order-content-block">
@foreach($orders as $order)
        <div class="col-12 @if(!$loop->first) d-none @endif order-block" id="order-block-{{ $order->id }}">
          <h4><small>@lang('Delivery'):</small></h4>
          <ul>
@if($order->delivery != null)
  @if($order->delivery->option != null)
            <li>{{ $order->delivery->option }}</li>
  @endif
  @if($order->delivery->city != null)
            <li>{{ $order->delivery->city }}</li>
  @endif
  @if($order->delivery->warehouse != null)
            <li>{{ $order->delivery->warehouse }}</li>
  @endif
  @if($order->delivery->street != null)
            <li>{{ $order->delivery->street }}</li>
  @endif
  @if($order->delivery->house != null)
            <li>{{ $order->delivery->house }}</li>
  @endif
  @if($order->delivery->flat != null)
            <li>{{ $order->delivery->flat }}</li>
  @endif
@endif
         </ul>



  @if($order->comment != null)
          <h4><small>@lang('Comment'):</small></h4>
          <p>{{ $order->comment }}</p>
  @endif
          <div id="order-content-{{ $order->id }}">
          @php $total = 0; @endphp
    @foreach($order->order as $o)
      @php
        $o['count'] = $o['count'] ?? 1;
        $size = $o['size']['language']['title'] ?? null;
        $colour = $o['colour']['language']['title'] ?? null;
        $total += $o['count']*$o['price'];
      @endphp
            <div class="row mb-3" style="border-bottom: 1px solid #ddd; padding-bottom: 5px;">

              <div class="col-sm-4 text-center">
            @isset($o['product']['picture']['mini_preview'])
                <div class="o-preview" style="background-image: url({{ asset($o['product']['picture']['five_preview']) }});"></div>
            @endisset
              </div>
              <div class="col-sm-8">
                <h5>{{ $o['product']['language']['title'] ?? null }}</h5>
                <p class="text-right"><b>{{ $size.' '.$colour }}</b></p>
                <p>{{ $o['count'].'x'.$o['price'] }} = <b>{{ $o['count']*$o['price'] }}</b> грн</p>
              </div>
            </div>
    @endforeach
            <div class="row">
              <div class="col-12 text-right">
                <h4 class="text-danger">{{ $total }} грн</h4>
              </div>
            </div>
          </div>
        </div>
@endforeach      
      </div>
    </div>
  </div>
</div>
<style type="text/css">
.o-preview{
  background-size: contain;
  background-position: center;
  background-repeat: no-repeat;
  height: 150px;
  width: 150px;
  max-width: 100%;
  border-radius: 5px;
  margin:auto;
}
.status-td{
  transition: 0.6s;
}
  
</style>

@endsection