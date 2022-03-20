<div class="form-group">
  <label for="delivery_service">@lang('Delivery service'):</label>
  <input type="hidden" name="delivery[service][key]" value="@lang('Delivery service')" form="order-store-form">
  <select class="form-control required" id="delivery_service" name="delivery[service][value]"  form="order-store-form">
    <option value="">@lang('Not chosen')</option>
    <option value="Новая почта" @if(isset($client['delivery_service']) && $client['delivery_service'] == 'Новая почта') selected @endif>Нова пошта</option>
    <option value="Мист экспресс" @if(isset($client['delivery_service']) && $client['delivery_service'] == 'Мист Экспресс') selected @endif>Мист Экспресс</option>
    <option value="Justin" @if(isset($client['delivery_service']) && $client['delivery_service'] == 'Justin') selected @endif>Justin</option>
  </select>
</div>

<div class="form-group">
  <label for="delivery_type">@lang('Delivery type'):</label>
  <input type="hidden" name="delivery[type][key]" value="@lang('Delivery type')" form="order-store-form">
  <select class="form-control required" id="delivery_type" name="delivery[type][value]"  form="order-store-form">
    <option value="">@lang('Not chosen')</option>
    <option value="На отделение" @if(isset($client['delivery_type']) && $client['delivery_type'] == 'На отделение') selected @endif>@lang('On branch')</option>
    <option value="На адрес" @if(isset($client['delivery_type']) && $client['delivery_type'] == 'На адрес') selected @endif>@lang('On address')</option>
  </select>
</div>

<div class="form-group">
    <label for="city">*@lang('City'):</label>
    <input type="hidden" name="delivery[city][key]" value="@lang('City')" form="order-store-form">
    <input type="text" class="form-control required"  id="city" name="delivery[city][value]" maxlength="50"  form="order-store-form" value="{{ $client['delivery_city'] ?? null }}">
</div>

<div id="to-otdelenie" class="d-none">
  <div class="form-group">
    <label for="branch-number">*@lang('Branch number'):</label>
    <input type="hidden" name="delivery[branch_number][key]" value="@lang('Branch number')" form="order-store-form">
    <input type="text" class="form-control required"  id="branch_number" name="delivery[branch_number][value]" maxlength="50"  form="order-store-form" value="{{ $client['delivery_branch_number'] ?? null }}">
  </div>
</div>
<div id="to-address" class="row d-none">
  <div class="col-12">
    <div class="form-group">
      <label for="street">*@lang('Street'):</label>
      <input type="hidden" name="delivery[street][key]" value="@lang('Street')" form="order-store-form">
      <input type="text" class="form-control required"  id="street" name="delivery[street][value]" maxlength="50"  form="order-store-form" value="{{ $client['delivery_street'] ?? null }}">
    </div>
  </div>
  <div class="col-4">
    <div class="form-group">
      <label for="house-number">*@lang('House number'):</label>
      <input type="hidden" name="delivery[house_number][key]" value="@lang('House number')" form="order-store-form"> 
      <input type="text" class="form-control required"  id="house-number" name="delivery[house_number][value]" maxlength="50"  form="order-store-form" value="{{ $client['delivery_house_number'] ?? null }}">
    </div>
  </div>
  <div class="col-4">
    <div class="form-group">
      <label for="flat-number">@lang('Flat number'):</label>
      <input type="hidden" name="delivery[flat_number][key]" value="@lang('Flat number')" form="order-store-form">
      <input type="number" class="form-control"  id="flat-number" name="delivery[flat_number][value]" maxlength="3" form="order-store-form" value="{{ $client['delivery_flat_number'] ?? null }}">
    </div>
  </div>
  <div class="col-4">
    <div class="form-group">
      <label for="post-code">@lang('Post code'):</label>
      <input type="hidden" name="delivery[post][key]" value="@lang('Post code')" form="order-store-form">
      <input type="number" class="form-control"  id="post-code" name="delivery[post][value]" maxlength="8" form="order-store-form" value="{{ $client['delivery_post'] ?? null }}">
    </div>
  </div>
</div>
<script type="text/javascript">
 

  function delivery_type()
  {
    if($('#delivery_type').val() == 'На отделение')
    {
      $('#to-otdelenie').removeClass('d-none');
      $('#to-otdelenie .required').prop('required', true);

      $('#to-address').addClass('d-none');
      $('#to-address .required').prop('required', false);
    }
    else if($('#delivery_type').val() == 'На адрес')
    {
      $('#to-otdelenie').addClass('d-none');
      $('#to-otdelenie .required').prop('required', false);

      $('#to-address').removeClass('d-none');
      $('#to-address .required').prop('required', true);
    }
    else
    {
      $('#to-otdelenie').addClass('d-none');
      $('#to-otdelenie .required').prop('required', false);

      $('#to-address').addClass('d-none');
      $('#to-address .required').prop('required', false);
    }
  }
   $(function(){
    delivery_type();
  });
  $(document).on('change', '#delivery_type', function(){
    delivery_type();
  });
</script>
