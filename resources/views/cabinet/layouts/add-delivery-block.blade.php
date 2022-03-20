<style type="text/css">
	#add-delivery-block{
		background: #fff;
		border: 1px solid #d8d8d8;
		padding: 40px 30px;
	}
</style>
<div class="col-12" id="add-delivery-block">
	<div class="row">
		<div class="col-12">
			<h3 class="block-title mb-4">@lang('Add delivery address')</h3>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-4 col-md-6">
			<div class="select-block mr-1 mt-2 mt-md-0 col p-0" id="select-block-delivery-option">
		        <div class="select-block-title">@lang('Delivery option')</div>
		        <div class="select-current-value-block d-flex justify-content-between">
			        <div class="select-current-value">@lang('Not chosen')</div>
			        <div class="dd"><i class="icon-Chevron---Down"></i></div>
		        </div>
	 	        <div class="select-range-block">
	 	        	<input type="radio" class="srb-input" name="option" required  value="@lang('Pickup')"  id="wahehouse-p">
	                <label data-block_id="delivery-option" data-value="@lang('Pickup')" data-row="np-p" class="srb-item d-flex justify-content-between m-0" for="wahehouse-p">
	                   <div>@lang('Pickup')</div>
	                   <div><i class="icon-Tick"></i></div>
	                </label>
	                <input type="radio" class="srb-input" name="option" required  value="Justin"  id="wahehouse-ju">
	                <label data-block_id="delivery-option" data-value="Justin" data-row="ju-w" class="srb-item d-flex justify-content-between m-0" for="wahehouse-ju">
	                   <div>@lang('Justin')</div>
	                   <div><i class="icon-Tick"></i></div>
	                </label>
			        <input type="radio" class="srb-input" name="option" required  value="@lang('Wahehouse Nova Pochta')"  id="wahehouse-np">
	                <label data-block_id="delivery-option" data-value="@lang('Wahehouse Nova Pochta')" data-row="np-w" class="srb-item d-flex justify-content-between m-0" for="wahehouse-np">
	                   <div>@lang('Wahehouse Nova Pochta')</div>
	                   <div><i class="icon-Tick"></i></div>
	                </label>
			        <input type="radio" class="srb-input" name="option" required  value="@lang('Сourier Nova Pochta')" id="courier-np">
	                <label data-block_id="delivery-option" data-row="np-a" data-value="@lang('Сourier Nova Pochta')" class="srb-item d-flex justify-content-between m-0" for="courier-np">
	                   <div>@lang('Сourier Nova Pochta')</div>
	                   <div><i class="icon-Tick"></i></div>
	                </label>
		        </div>
	        </div>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-4 col-md-6  mt-4 d-none np-p option-delivery-item ">
			<div class="select-block mr-1 mt-2 mt-md-0 col p-0" id="select-block-delivery-city">
		        {{ $site_option['address'] ?? null }}
	        </div>
		</div>

		<div class="col-lg-4 col-md-6  mt-4 d-none np-w np-a option-delivery-item ">
			<div class="select-block mr-1 mt-2 mt-md-0 col p-0" id="select-block-delivery-city">
		        <div class="select-block-title">@lang('City')</div>
		        <input type="hidden" id="np-city-ref" name="city_ref" value="">
		        <div class="select-current-value-block d-flex justify-content-between">
			        <input class="select-current-value-input required" id="nova-pochta-city" autocomplete="new-password">
			        <div class="dd"><i class="icon-Chevron---Down"></i></div>
		        </div>
	 	        <div class="select-range-block" id="nova-pochta-city-np-city">

		        </div>
	        </div>
		</div>
		<div class="col-lg-4 col-md-6  mt-4 d-none np-w option-delivery-item">
			<div class="select-block mr-1 mt-2 mt-md-0 col p-0" id="select-block-delivery-warehouse">
		        <div class="select-block-title">@lang('Warehouse')</div>
		        <input type="hidden" id="np-warehouse-ref" name="warehouse_ref" value="">
		        <div class="select-current-value-block d-flex justify-content-between">
			        <input class="select-current-value-input required" id="nova-pochta-warehouse" autocomplete="new-password" name="some_field">
			        <div class="dd"><i class="icon-Chevron---Down"></i></div>
		        </div>
	 	        <div class="select-range-block" id="nova-pochta-city-np-warehouse">

		        </div>
	        </div>
		</div>

		<div class="col-lg-4 col-md-6  mt-4 d-none ju-w option-delivery-item">
			<div class="select-block mr-1 mt-2 mt-md-0 col p-0" id="select-block-delivery-city">
		        <div class="select-block-title">@lang('City')</div>
		        <input type="hidden" id="ju-city-uuid" name="city_uuid" value="">
		        <div class="select-current-value-block d-flex justify-content-between">
			        <input class="select-current-value-input required" id="justin-city" autocomplete="new-password">
			        <div class="dd"><i class="icon-Chevron---Down"></i></div>
		        </div>
	 	        <div class="select-range-block" id="justin-city-ju-city">

		        </div>
	        </div>
		</div>
		<div class="col-lg-4 col-md-6  mt-4 d-none ju-w option-delivery-item">
			<div class="select-block mr-1 mt-2 mt-md-0 col p-0" id="select-block-delivery-warehouse-ju">
		        <div class="select-block-title">@lang('Warehouse')</div>
		        <input type="hidden" id="ju-warehouse-ref" name="warehouse_uuid" value="">
		        <div class="select-current-value-block d-flex justify-content-between">
			        <input class="select-current-value-input required" id="justin-warehouse" autocomplete="new-password" name="some_field2">
			        <div class="dd"><i class="icon-Chevron---Down"></i></div>
		        </div>
	 	        <div class="select-range-block" id="justin-city-ju-warehouse">

		        </div>
	        </div>
		</div>

		<div class="col-lg-4 col-md-6 mt-4 d-none np-a option-delivery-item">
			<div class="select-block mr-1 mt-2 mt-md-0 col p-0" id="select-block-delivery-street">
		        <div class="select-block-title">@lang('Street')</div>
		        <input type="hidden" id="np-street-ref" class="required" name="street_ref" value="">
		        <div class="select-current-value-block d-flex justify-content-between">
			        <input class="select-current-value-input" id="nova-pochta-street" autocomplete="new-password">
			        <div class="dd"><i class="icon-Chevron---Down"></i></div>
		        </div>
	 	        <div class="select-range-block" id="nova-pochta-city-np-street">

		        </div>
	        </div>
		</div>
		<div class="col-lg-2 col-md-3 col-6 mt-4 d-none np-a option-delivery-item">
			<div class="form-group">
                <div class="select-block-title">@lang('House'):</div>
                <input type="text" class="form-control required" required name="house"  maxlength="50" placeholder="" >
            </div>
        </div> 
        <div class="col-lg-2 col-md-3 col-6 mt-4 d-none np-a option-delivery-item">
			<div class="form-group">
                <div class="select-block-title">@lang('Flat'):</div>
                <input type="text" class="form-control" name="flat"  maxlength="50" placeholder="" >
            </div>
        </div>
	</div>
@if(url()->current() != route('cart.checkout'))
	<div class="row mt-4">
		<div class="col-lg-4 col-md-6  mt-2 d-none np-w np-a ju-w np-p option-delivery-item">
			<button class="btn btn-primary btn-block">
				@lang('Save')
			</button>
		</div>
	</div>
@endif
</div>
<script type="text/javascript">
	$(document).on('keyup', '.select-current-value-input', function(){
		$(this).parent().parent().addClass('active');
	})
	$(document).on('click', '#select-block-delivery-option .srb-item', function(){
		var row = $(this).data('row');

		$('.option-delivery-item').addClass('d-none');
		$('.option-delivery-item').find('input.required').prop('required', false);

		$('.' + row).removeClass('d-none');
		$('.' + row).find('input.required').prop('required', true);

	});
	/*новая почта введение улицы*/
	$(document).on('keyup', '#nova-pochta-street', function(){
        var vall = $(this).val(),
            city_ref = $('#np-city-ref').val();

        vall = vall.replace(/[a-zA-Z0-9]+/, '');

        if(vall.trim() == '')
            return false;
        if(city_ref.trim() == '')
        {
          //  alert('Сначала заполните поле "Город"');
            return false;
        }
        $.ajax({
            method: 'GET',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url:"{{ route('nova.pochta.get.streets') }}", 
            data: {
                string : vall,
                city_ref : city_ref
            },
            
            success: function(data){

                if(data.success !== false)
                {
                    $('#nova-pochta-city-np-street').html('');

                    result = data.data;     
 
                    result.forEach(function(el){
                        $('#nova-pochta-city-np-street').append('<input type="radio" class="srb-input" name="street"  value="' + el.Description + '" id="' + el.Ref + '-np"><label data-block_id="delivery-street" data-value="' + el.Description + '" data-ref="' + el.Ref + '" class="srb-item d-flex justify-content-between m-0" for="' + el.Ref + '-np"><div>' + el.Description + '</div><div><i class="icon-Tick"></i></div></label>');
                    });

                    if(result.length == 1)
                    {
                        $('#delivery-street-ul .st-var').click();
                    }

                    $('#delivery-street').attr('name', 'delivery[street]');
                }
                else{
                	alert('Some error arised: ' + data.error);
                }
            },
            error: function(msg){
                console.log(msg); 
            }
        });
    });
    /*новая почта выбор улицы*/
    $(document).on('click', '#nova-pochta-city-np-street .srb-item', function(){
		var ref = $(this).data('ref');
		$('#np-street-ref').val(ref);
	});
	/* новая почта города*/
	$(document).on('keyup', '#nova-pochta-city', function(){
        var val = $(this).val();

        val = val.replace(/[a-zA-Z0-9]+/, '');

        if(val.trim() == '')
            return false;
        $.ajax({
            method: 'GET',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url:"{{ route('nova.pochta.get.cities') }}", 
            data: {string:val},
            
            success: function(data){

                if(data.success !== false){

                    result = data.data;   

                    $('#nova-pochta-city-np-city').html('');    
 
                    result.forEach(function(el){
                        $('#nova-pochta-city-np-city').append('<input type="radio" class="srb-input" name="city"  value="' + el.DescriptionRu + ' - ' + el.SettlementTypeDescriptionRu + '" id="' + el.Ref + '-np"><label data-block_id="delivery-city" data-value="' + el.DescriptionRu + ' - ' + el.SettlementTypeDescriptionRu + '" data-ref="' + el.Ref + '" class="srb-item d-flex justify-content-between m-0" for="' + el.Ref + '-np"><div>' + el.DescriptionRu + ' - ' + el.SettlementTypeDescriptionRu + '</div><div><i class="icon-Tick"></i></div>               </label>');
                    }); 
                }
                else{
                	$('#nova-pochta-city-np-city').html('');
                }
            },
            error: function(msg){
                console.log(msg); 
            }
        });
    });
    /* новая почта выбор отделения */
    $(document).on('click', '#nova-pochta-city-np-warehouse .srb-item', function(){
		var ref = $(this).data('ref');
		$('#np-warehouse-ref').val(ref);
	});
	$(document).on('click', '#nova-pochta-city-np-city .srb-item', function(){
		var ref = $(this).data('ref');
		$('#np-city-ref').val(ref);
		$('#nova-pochta-warehouse').val('');
		$('#nova-pochta-street').val('');
		get_wharehouses_list();
	});
    /* JUSTIN */
    $(document).on('keyup', '#justin-city', function(){
        var val = $(this).val();

        val = val.replace(/[a-zA-Z0-9]+/, '');

        if(val.trim() == '')
            return false;
        $.ajax({
            method: 'GET',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url:"{{ route('justin.get.cities') }}", 
            dataType: 'json',
            data: {
            	string:val
            },            
            success: function(data){

            	console.log(data);

                if(data.success !== false){

                	$('#justin-warehouse').val('');

                    result = data.data;   

                    console.log(data.data);

                    $('#justin-city-ju-city').html('');    
 
                    result.forEach(function(el){
                        $('#justin-city-ju-city').append('<input type="radio" class="srb-input" name="city"  value="' + el.title + '" id="' + el.uuid + '-ju"><label data-block_id="delivery-city" data-value="' + el.title  + '" data-uuid="' + el.uuid + '" class="srb-item d-flex justify-content-between m-0" for="' + el.uuid + '-ju"><div>' + el.title + '</div><div><i class="icon-Tick"></i></div>               </label>');
                    }); 
                }
                else{
                	$('#justin-city-ju-city').html('');
                }
            },
            error: function(msg){
                console.log(msg); 
            }
        });
    });
    $(document).on('click', '#justin-city-ju-city .srb-item', function(){
		var uuid = $(this).data('uuid');
		$('#ju-city-uuid').val(uuid);

		get_wharehouses_justin_list();
	}); 
	function get_wharehouses_justin_list(){
        var city_uuid = $('#ju-city-uuid').val();

        if(city_uuid.trim() == '')
        {
            alert('Сначала заполните поле "Город"');
            return false;
        }
        $.ajax({
            method: 'GET',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url:"{{ route('justin.get.warehouses') }}", 
            dataType: 'json',
            data: {
                uuid : city_uuid
            },
            
            success: function(data){

                if(data.success !== false)
                {

                    $('#justin-city-ju-warehouse').html('');   

                    result = data.data;   
 
                    result.forEach(function(el){
                        $('#justin-city-ju-warehouse').append('<input type="radio" class="srb-input" name="warehouse"  value="' + el.title + '" id="' + el.uuid + '-ju"><label data-block_id="delivery-warehouse" data-value="' + el.title + '" data-uuid="' + el.uuid + '" class="srb-item d-flex justify-content-between m-0" for="' + el.uuid + '-ju"><div>' + el.title + '</div><div><i class="icon-Tick"></i></div></label>');
                    }); 
                }
                else{
                	console.log('hi');
                	$('#justin-city-ju-warehouse').html(''); 
                }
            },
            error: function(msg){
                console.log(msg); 
            }
        });
    };
    $(document).on('click', '#select-block-delivery-warehouse-ju .srb-input', function(){
    	var title = $(this).val();
    	$('#justin-warehouse').val(title);

    })

	
	function get_wharehouses_list(){
        var city_ref = $('#np-city-ref').val();

        if(city_ref.trim() == '')
        {
            alert('Сначала заполните поле "Город"');
            return false;
        }
        $.ajax({
            method: 'GET',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url:"{{ route('nova.pochta.get.warehouses') }}", 
            data: {
                city_ref : city_ref
            },
            
            success: function(data){

            	console.log(data.success);

                if(data.success !== false)
                {

                    $('#nova-pochta-city-np-warehouse').html('');   

                    result = data.data;   
 
                    result.forEach(function(el){
                        $('#nova-pochta-city-np-warehouse').append('<input type="radio" class="srb-input" name="warehouse"  value="' + el.DescriptionRu + '" id="' + el.Ref + '-np"><label data-block_id="delivery-warehouse" data-value="' + el.DescriptionRu + '" data-ref="' + el.Ref + '" class="srb-item d-flex justify-content-between m-0" for="' + el.Ref + '-np"><div>' + el.DescriptionRu + '</div><div><i class="icon-Tick"></i></div></label>');
                    }); 
                }
                else{
                	$('#nova-pochta-city-np-warehouse').html(''); 
                }
            },
            error: function(msg){
                console.log(msg); 
            }
        });
    };

</script>