<!--
<select class="form-control" id="orderBy-input" name="orderBy" form="order-filters-form">
  <option value="">@lang('favourites')</option>
  <option value="ascending">@lang('price low to high')</option>
  <option value="descending">@lang('price high to low')</option>
  <option value="updated_at">@lang("what's new")</option>
</select>


<script type="text/javascript">
  $(document).on('change', '#orderBy-input', function(){
    $('#order-filters-form').submit();
  });
@if(app('request')->has('orderBy'))
  $(function(){
    $('#orderBy-input').val("{{ app('request')->input('orderBy') }}");
  })
@endif
</script>-->
<style type="text/css">
    .order-select-block{
        font-family: Nunito Sans;
font-size: 16px;
font-style: normal;
font-weight: 300;
transform: translateY(1px);
cursor: pointer;
position: relative;
z-index: 9999;
    }
    .order-select-block .dd{
        transform: translateY(2px);
    }
    .order-select-block.active .dd{
        transform: rotate(180deg);
    }

    .osb-title{
        width: 120px;

    }
    .order-select-block .order-select-range-block{
        border: 1px solid #DCDCDC;
        padding: 0;
        position: absolute;
        top: 105%;
        left: -50px;
        background-color: #fff;
        width: calc(100% + 50px);
        background-color: #fff;
        z-index: 999;
        display: none;
    }
    .order-select-block.active .order-select-range-block{
        display: block;
    }
    .osf-item{
        color: #202020;
        padding: 14px;
        font-family: Nunito Sans;
font-size: 16px;
font-style: normal;
font-weight: 300;
line-height: 19px;
letter-spacing: 0px;
text-align: left;
cursor: pointer;
    }
    .filter-select-fvalues-block .osf-item:not(:last-child){
        border-bottom: 1px solid #DCDCDC;
    }
    [type="radio"]:checked + label.osf-item {
        color: #2C50F2;
        background: #F6F6F6;
    }
    [type="radio"]:not(:checked).order-radio,
    [type="radio"]:checked.order-radio {
        position: absolute;
        left: -9999px;
    }
</style>
<div class="col-md-6 d-none d-md-block">
    <span class="path-link"> @lang('Productss'):</span> <span id="catalog-products-count">{{ $products_count }}</span>
</div>
<div class="col-md-6 d-none d-md-flex justify-content-end align-items-center">
    <div class="pr-2 mr-2"><span class="path-link">@lang('Sort')</span></div> 
    <div class="order-select-block">
        <div class="osb-title d-flex justify-content-between">
        @if(app('request')->input('orderBy', 'popular') == 'popular')
            <div>@lang('Popular')</div>
        @elseif(app('request')->input('orderBy', 'popular') == 'novelty')
            <div>@lang('Novelties')</div>
        @elseif(app('request')->input('orderBy', 'popular') == 'ascending')
            <div>@lang('To high price')</div>
        @elseif(app('request')->input('orderBy', 'popular') == 'descending')
            <div>@lang('To low price')</div>
        @endif
            <div class="dd"><i class="icon-Chevron---Down"></i></div>
        </div>

        <div class="order-select-range-block">
            <input type="radio" name="orderBy" @if(app('request')->input('orderBy') == 'popular') checked @endif value="popular" class="order-radio" id="orderBy-popular" class="osf-input" form="fsb-form">
            <label class="osf-item d-flex justify-content-between m-0" for="orderBy-popular">
                <div>@lang('Popular')</div>
                <div><i class="icon-Tick"></i></div>
            </label>  
            <input type="radio" name="orderBy"  class="order-radio" @if(app('request')->input('orderBy') == 'novelty') checked @endif value="novelty" id="orderBy-novelty" class="osf-input" form="fsb-form">
            <label class="osf-item d-flex justify-content-between m-0" for="orderBy-novelty">
                <div>@lang('Novelties')</div>
                <div><i class="icon-Tick"></i></div>
            </label> 
            <input type="radio" name="orderBy"  class="order-radio" @if(app('request')->input('orderBy') == 'ascending') checked @endif value="ascending" id="orderBy-ascending" class="osf-input" form="fsb-form">
            <label class="osf-item d-flex justify-content-between m-0" for="orderBy-ascending">
                <div>@lang('To high price')</div>
                <div><i class="icon-Tick"></i></div>
            </label> 
            <input type="radio" name="orderBy"  class="order-radio" @if(app('request')->input('orderBy') == 'descending') checked @endif value="descending" id="orderBy-descending" class="osf-input" form="fsb-form">
            <label class="osf-item d-flex justify-content-between m-0 " for="orderBy-descending">
                <div>@lang('To low price')</div>
                <div><i class="icon-Tick"></i></div>
            </label>
        </div> 
    </div>
</div>
<script type="text/javascript">
    $(document).on('click', '.order-select-block', function(){
        $(this).toggleClass('active');
    });
    $(document).on('mouseleave', '.order-select-range-block', function(){
        $(this).parent().removeClass('active');
    });
    $(document).on('change', '.order-radio', function(){
        $('#fsb-form').submit();
    })
</script>
