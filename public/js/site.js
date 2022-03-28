// валидация форм ajax перед отправкой
$(document).on('submit', '.validate-form-ajax', function(e){

    e.preventDefault();

    var url = $(this).attr('action'),
        data = $(this).serialize(),
        form = $(this);

    url += '/validate/ajax';

    $.ajax({
        method: 'POST',
        url: url,
        data: data,
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        error: function(response){

            form.find('.input-error').addClass('d-none').text('is-invalid');
            form.find('input').removeClass('is-invalid')

            for(key in response.responseJSON.errors)
            {
                form.find('.input-error-' + key).text(response.responseJSON.errors[key]).removeClass('d-none');
                form.find('input[name="' + key + '"]').addClass('is-invalid')
            }
            return false;
            console.log(response.responseJSON.errors.name);
             //  $('#' + formId + ' .input-error-email').text(response.errors.email).removeClass('d-none');
        },
        success: function(response){
            form.removeClass('validate-form-ajax').submit();                
        }
    });
});
$(document).on('click', '.delete-item', function(){
  var confirmaion_q = 'Вы уверены что хотите удалить данный элемент?';

//confirm_var = confirm(confirmaion_q );
//if (!confirm_var) return false;

  var id = $(this).data('id'),
      url = $(this).data('url'),
      item = $("#item-" + id);
 
  $.ajax({
    method: 'GET',
    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
    url:url, 
    success: function(response){
      item.hide(500,function(){$(this).remove()});
   //   saved_window_show(response, true);
    },
    error: function(response){
     // saved_window_show(response.responseText, false);
    }
  });
});
function callbackForm(id)
{
    var data   = $('#' + id).serialize();

    $.ajax({
        method: 'GET',
        url: "/send-email",
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        data: data,
        success: function(data)
        {
            $('#' + id + '-block').addClass('d-none');
            $('#' + id + '-block-answer').removeClass('d-none');
        },
        error:  function(xhr, str)
        {
            alert('Возникла ошибка: ' + xhr.responseCode);
        }
    });
}
function sendCommentsForm(id)
{
    var data = $('#' + id).serialize();

    $.ajax({
        method: 'POST',
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url: '/comments/store',
        data: data,
        success: function()
        {
            $('#' + id + '-block').addClass('d-none');
            $('#' + id + '-answer').removeClass('d-none');
        },
        error:  function(xhr, str)
        {
           alert('Error: ' + xhr.responseCode);
        }
    });
}

$(document).on('click', '.add-to-favorite-button', function(){
    var data = $(this).data()
        id = data.id,
        button = $(this);

    data = $.param(data);

    $.ajax({
        method: 'GET',
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url: '/favorites/add_remove',
        dataType: 'json',
        data: data,
        success: function(response)
        {
            $('.favorites-link-count').text(response.favorites_count);

            if(response.favorites_count == 0)
                $('.favorites-link-count').addClass('d-none');
            else
                $('.favorites-link-count').removeClass('d-none');


            if(response.already_exists)
               button.removeClass('active').children('i').addClass('ri-heart-line').removeClass('ri-heart-fill');
            else
                button.addClass('active').children('i').removeClass('ri-heart-line').addClass('ri-heart-fill');
        },
        error:  function(xhr, str)
        {
           alert('Error: ' + xhr.responseCode);
        }
    });
});
$(document).on('click', '.add-to-compare-button', function(){
    var data = $(this).data(),
        button = $(this);

    data = $.param(data);

    $.ajax({
        method: 'GET',
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url: '/compare/add_remove',
        dataType: 'json',
        data: data,
        success: function(response)
        {
            $('.compare-link-count').text(response.compare_count);

            if(response.compare_count == 0)
                $('.compare-link-count').addClass('d-none');
            else
                $('.compare-link-count').removeClass('d-none');


            if(response.already_exists)
            {
               button.removeClass('active');
            }
            else
                button.addClass('active');
        },
        error:  function(xhr, str)
        {
           alert('Error: ' + xhr.responseCode);
        }
    });
});
/* CART */
/* ЦЕНОВЫЕ БЛОКИ И КОРЗИНА*/
//изменение ценовых блоков и расчёт суммы при изменении параметров
    $(document).on('change', 'input', function(){
        createAllData();
        calculateSum();
    });
//заполнение ценовых блоков
    function createAllData()
    {
        createProductData('product-params-block-second');
        createProductData('product-params-block-first');    
    }
//расчёт суммы
    function calculateSum()
    {
        var sum = 0,
            discount = $('.product-params-block').first().data('discount');

        $('.product-params-block:not(.d-none)').each(function(){
            if(!$(this).hasClass('.d-none'))
                sum += $(this).data('sum');
        });


        if(discount == 0)
            $('.atc-price-value').text(sum);
        else
        {
            $('.atc-new-price-value').text(sum*(100 - discount)/100);
            $('.atc-old-price-value').text(sum);
        }
    }
//функция заполнения ценового блока
    function createProductData(id){
        var params = [],
            price = $('#' + id).data('price'),
            count = 1,
            sum = 0,
            pricelist_id = 0;

        if($('#' + id).hasClass('d-none'))
            return false;
        
        $('#' + id + ' input').each(function(){
            if($(this).hasClass('for-cart-input'))
            {
                if($(this).prop('checked'))
                    params.push($(this).data('filter') + '=' + $(this).val());
            }
            else if($(this).hasClass('pricelist-input'))
            {
                if($(this).prop('checked'))
                {
                    params.push($(this).data('filter') + '=' + $(this).val());
                    price = $(this).data('price');
                    pricelist_id = $(this).data('id');
                }
            }
            else if($(this).hasClass('count-input'))
                count = $(this).val();
        });

        sum = price*count;

        $('#' + id).data('price', price);
        $('#' + id).data('params', params);
        $('#' + id).data('count', count);
        $('#' + id).data('sum', sum);
        $('#' + id).data('pricelist_id', pricelist_id);

        console.log($('#' + id).data());
    }
// добавление дополнительного ценового блока (разные глаза)
    $(document).on('click', '.different-eyes-button', function(){

        var eyes = $(this).data('eyes');

        $('.different-eyes-button').removeClass('use');

        $(this).addClass('use');

        if($(this).hasClass('show-second'))
        {
            $('#product-params-block-first .product-params-row-title').text(eyes);
            $('#product-params-block-second').removeClass('d-none').addClass('d-flex');
        }
        else
        {
            $('#product-params-block-first .product-params-row-title').text(eyes);
            $('#product-params-block-second').addClass('d-none').removeClass('d-flex');
        }
        createAllData();
        calculateSum();
    });
    // добавление товара в корзину
    $(document).on('click', '.add-to-cart-button', function(){

        $('.product-params-block:not(.d-none)').each(function(index){
            var data = $.param($(this).data());
            
            setTimeout(sendDataToCart, 1000*index, data);

            $('#add-to-cart-body').addClass('active');

            $('.atc-body').addClass('d-none');
            $('.atc-body-answer').removeClass('d-none').addClass('d-flex');
        });
    });
    // количество товаров
    $(document).on('click', '.count-block-button', function(){
        var inc = Number($(this).data('inc')),
            id = $(this).data('id'),
            val = Number($('#count-block-' + id + ' input').val());

        new_val = val + inc;

        if(new_val > 9 || new_val < 1)
            return false;

        if(new_val == 1)
        {
            $('#count-block-' + id + ' .count-block-button-down').addClass('muted');
            $('#count-block-' + id + ' .count-block-button-up').removeClass('muted');
        }
        else if(new_val == 9)
        {
            $('#count-block-' + id + ' .count-block-button-down').removeClass('muted');
            $('#count-block-' + id + ' .count-block-button-up').addClass('muted');
        }
        else
            $('#count-block-' + id + ' .count-block-button').removeClass('muted');

        $('#count-block-' + id + ' input').val(new_val);
        $('#count-block-' + id + ' .count-block-value').text(new_val);

        createAllData();
        calculateSum();
    });
    //функция отправки данных на сервер для добавления в корзину
    function sendDataToCart(data)
    {
        $.ajax({
            method: 'GET',
            url: "/cart/add",
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data: data,
            success: function(response)
            {
                $('.cart-link-count.head-icon-count').text(response.cart_count);

            },
            error:  function(xhr, str)
            {
                alert('Возникла ошибка: ' + xhr.responseCode);
            }
        });
    }
/*
$(document).on('click', '.add-to-cart-button', function(){
    var data = $(this).data();

    data = $.param(data);

    $.ajax({
        method: 'GET',
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url: '/cart/add',
        dataType: 'json',
        data: data,
        success: function(response)
        {
            cart_content();
        },
        error:  function(xhr, str)
        {
           alert('Error: ' + xhr.responseCode);
        }
    });
});
*/
   

    $(document).on('click', '.delete-from-cart', function(){
        var index = $(this).data('index');

        $.ajax({
            method: 'GET',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url: '/cart/delete',
            dataType: 'json',
            data:{
                index: index
            },
            success: function(response)
            {
                console.log(response);
                cart_content(response);
            },
            error:  function(xhr, str)
            {
                alert('Error: ' + xhr.responseCode);
            }
        });
    }); 
   
    $(document).on('click', '.change-count-in-cart', function(){
        var data = $(this).data();
        data = $.param(data);

        $.ajax({ 
            method: 'GET',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url: '/cart/change-count',
            dataType: 'json',
            data:data,
            success: function(response)
            { 
                cart_content(response);
            },
            error:  function(xhr, str)
            {
                alert('Error: ' + xhr.responseCode);
            }
        });

    });

/*SELECT BLOCK CUSTOM*/
    $(document).on('click', '.select-block', function(){

        $(this).toggleClass('active');
        
    });

    $(document).on('mouseleave', '.select-range-block', function(){
        $(this).parent().removeClass('active');
    });

    $(document).on('click', '.srb-item', function(){
        var val = $(this).data('value'),
            block_id = $(this).data('block_id');

        $('.select-block').removeClass('active');

        console.log(val + ' ' + block_id);

        $('#select-block-' + block_id + ' .select-current-value').text(val);
        $('#select-block-' + block_id + ' .select-current-value-input').val(val);
    });

/*  $(function(){
        $('.show-cart-modal-button').eq(3).click();
    }); */
    $(document).on('click', '.show-cart-modal-button', function(){
        $('#add-to-cart-body').addClass('active');

        $('.atc-body').removeClass('d-none');
        $('.atc-body-answer').removeClass('d-flex').addClass('d-none');

        var product_id = $(this).data('id');

        $.ajax({
            method: 'GET',
            url: "/cart/get-price-params-block/" + product_id,
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            success: function(response)
            {
                

                $('.atc-price-params-block').html(response.price_params_block);
                $('.atc-preview img').attr('src', response.preview);
                $('.atc-title').text(response.title);

                if(response.discount)
                {
                    $('#atc-price-block-with-discount').removeClass('d-none');
                    $('#atc-price-block-no-discount').addClass('d-none');
                }
                else
                {
                    $('#atc-price-block-with-discount').addClass('d-none');
                    $('#atc-price-block-no-discount').removeClass('d-none');
                }
                createAllData();
                calculateSum();
            },
            error:  function(xhr, str)
            {
                alert('Возникла ошибка: ' + xhr.responseCode);
            }
        });
    });
    /* AJAX PAGINATION*/
        function progressBar(u, t)
    {
        
        $('#progress-bar-items').css('background', 'linear-gradient(to right, #2C50F2 ' + u/t*100 +'%, #F6F6F6 ' + u/t*100 +'%)');
    }
    $(function(){
        var u = $('.download-items-ajax-button').data('step'),
            t = $('.download-items-ajax-button').data('total');

        progressBar(u, t);
    });
    $(function(){
        var step = $(this).data('step'),
            total = $(this).data('total'),
            offset = $(this).data('offset');

        if(offset + step == total)
            $('.download-items-ajax-button').addClass('d-none');

    });
    $(document).on('click', '.download-items-ajax-button', function(){
        var offset = $(this).data('offset'),
            url = $(this).data('url'),
            step = $(this).data('step'),
            total = $(this).data('total'),
            button = $(this);

            offset += step;

            url += 'offset=' + offset;

        $.ajax({
            url: url,
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            success: function(products){
                $('#items-uploaded-list').append(products);
                button.data('offset', offset);
                console.log(offset);
                if(offset + step >= total)
                {
                    button.addClass('d-none');
                    $('#uploaded-items-numbers').text(total);
                }
                else
                    $('#uploaded-items-numbers').text(offset + step);

                progressBar(offset + step, total);
            },
            error: function(error){
                console.log(error);
            },
        });
    });
