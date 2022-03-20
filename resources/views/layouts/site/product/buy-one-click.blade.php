<style type="text/css">
  .boc-preview{
    max-width: 350px;
    max-height: 400px;
    margin-bottom: 15px;
  }
  .boc-title{
    font-family: fbold;
    font-size: 16px;
    color: #333;
  }
  #buyOneClickModal h4{
    font-family: Nunito Sans;
    font-size: 32px;
    font-style: normal;
    font-weight: 400;
    line-height: 38px;
    letter-spacing: 0px;
    text-align: center;
    color: #202020;


  }
  #buyOneClickModal .modal-body{
    padding: 15px 45px;
  }

</style>
<script type="text/javascript">
  $(document).on('click', '.buy-one-click-button', function(){
    var data = $(this).data();

    $('.boc-preview').attr('src', data.preview);
    $('.boc-title').text(data.title);
    $('.boc-id').val(data.id);
    $('.boc-price').val(data.price);
    $('#order-product-title').val(data.title);
  })
</script>
<!-- Button to Open the Modal -->
<div class="btn btn-outline-primary buy-one-click-button" data-toggle="modal" data-target="#buyOneClickModal" data-preview="{{ $product->picture->four_preview }}" data-title="{{ $product->language->title }}" data-price="{{ $product->final_price }}" data-id="{{ $product->id }}">@lang('Buy one click')</div>

<!-- The Modal -->
<div class="modal" id="buyOneClickModal" style="z-index: 99999999;">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header pb-0" style="border-bottom: none;">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <div id="order-form-block">

          <h4 class="modal-title">@lang('Buy one click')</h4>
          <div class="text-center">
            <img src="" class="boc-preview">
            <p class="boc-title"></p>
          </div>
          <form action="javascript:void(null);" id="order-form" onsubmit="storeOrder();">
            @csrf
            <input type="hidden" name="buy_one_click" value="1">
            <input type="hidden" name="product_id" class="boc-id" id="product-id-to-cart">
            <input type="hidden" name="price" class="boc-price" id="product-price-to-cart">
            <input type="hidden" name="subject" value="Заказ с Вашего сайта {{ $_SERVER['SERVER_NAME'] }}">

            <div class="form-group">
              <label for="usr">@lang('Your name'):</label>
              <input type="text" class="form-control" id="user-name-boc" name="name" required="" value="{{ auth()->user()->name ?? null }}">
            </div>

            <div class="form-group">
              <label for="usr">@lang('Your phone number'):</label>
              <input type="text" class="form-control send-phone" id="user-phone-boc" name="phone" required="" value="{{ auth()->user()->phone ?? null }}" placeholder="+38 (___) ___ ____">
            </div>

            <div class="form-group text-right mt-4">
              <button type="submit" class="btn btn-primary btn-block"> @lang('Make order')</button>
            </div>
          </form>
        </div>
  
        <div id="order-form-block-answer" class="d-none" style="padding: 15px 40px">
          <h4>@lang('Thank You')!!</h4>
          <p>{{ $site_option['cbb_modal_answer'] ?? null }}</p>
        </div>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
  function storeOrder()
  {
    var first_name = $('#user-name-boc').val(),
        phone = $('#user-phone-boc').val(),
        product_id = $('#product-id-to-cart').val(),
        product_price = $('#product-price-to-cart').val();

    $.ajax({
      url: "{{ route('order.store') }}",
      method: 'POST',
      headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
      data: {
        name: first_name,
        phone: phone, 
        product_id: product_id,
        product_price: product_price,
        buy_one_click: true,
      },
      error: function(error){
        console.log(error.responseJSON.message);
      },
      success: function(){
        $('#order-form-block-answer').removeClass('d-none');
        $('#order-form-block').addClass('d-none');
       
      } 
    });


  }
</script>