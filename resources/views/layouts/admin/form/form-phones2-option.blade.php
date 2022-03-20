<?php
  $site_option['phones'] = isset($site_option['phones']) ? json_encode($site_option['phones']) : "[0]";
?>
<style type="text/css">
  .table-phones td, .table-phones th{
    width: 200px;
  }
</style>

<div class="row form-block">
  <div class="col-12">
    <h3 class="text-center">Телефонные номера</h3>
  </div>

<form action="javascript:void(null);" onsubmit="option_update('option_update_phones')"  id="option_update_phones" class="form-horizontal">
  <input type="hidden" name="type" value="array">
  <input type="hidden" name="key" value="phones">
  <input type="hidden" name="place" value="1">
  <table class="table table-phones table-hover text-center">
    <thead>
      <tr class="info">
        <th>

        </th>
        <th>Телефон</th>
        <th>@lang('Viber')</th>
        <th>@lang('WhatsApp')</th>
        <th>@lang('Telegram')</th>
        <th>
          <button type="button" class="btn btn-outline-success btn-sm" id="add-phone-button"><i class="far fa-plus-square"></i> Добавить</button>          
        </th>
      </tr>
    </thead>
    <tbody>

    </tbody>
  </table>
  <div class="form-group text-right">
    <div class="col-sm-12">
      <button class="btn btn-primary">Сохранить</button>
     </div>
  </div>
</form>
</div>
<script type="text/javascript">
  $(function(){
    var phones_obj = {!! $site_option['phones'] !!},
        phones = [];

        for(p in phones_obj)
        {
          phones.push(phones_obj[p]);
        }

    fill_phones_table(phones);

    $('#add-phone-button').click(function(){
      console.log(phones);
      phones.push({});
      fill_phones_table(phones); 
    });

    $(document).on('click', '.delete-phone-tr', function(){
      var index = $(this).data('index');
      phones.splice(index, 1);;
      fill_phones_table(phones); 
    });
    
    function fill_phones_table(phones)
    {
      $('.table-phones tbody').html('');

      console.log(phones);

    for(index in phones)
    {
      if(!phones[index].hasOwnProperty('phone'))
        phones[index].phone = '';

      ['viber', 'whatsapp', 'telegram'].forEach(function(value){
        if(phones[index].hasOwnProperty(value))
          phones[index][value] = 'checked';
      });

      $('.table-phones tbody').append('\
        <tr class="phone-tr">\
        <td>\
          <button type="button" class="btn btn-outline-danger btn-sm delete-phone-tr" data-index="' + index + '">\
            <i class="far fa-trash-alt"></i>            \
          </button>\
        </td>\
        <td class="text-center">\
          <input type="text" name="value[' + index + '][phone]" class="form-control phone-input" maxlength="30" required="required" value="' + phones[index].phone + '">\
        </td>\
       <td>\
          <input type="checkbox" name="value[' + index + '][viber]" class="viber-input"  ' + phones[index].viber + '>\
        </td>\
        <td>\
          <input type="checkbox" name="value[' + index + '][whatsapp]" class="whatsapp-input" ' + phones[index].whatsapp + '>\
        </td>\
        <td>\
          <input type="checkbox" name="value[' + index + '][telegram]" class="whatsapp-input" ' + phones[index].telegram + '>\
        </td>\
      </tr>\
        ');

    }
  

    }


 
  })
</script>
