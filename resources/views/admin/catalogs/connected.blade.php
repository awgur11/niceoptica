@if($categories->count() > 0 || $catalogs_nocategory->count() > 0)

<style type="text/css">
  .connected-catalogs-block .checkbox>label{
    text-transform: lowercase;
    margin-left: 35px;
  }  
</style>

<div class="form-block col-sm-12 connected-catalogs-block">
  <h3>Укажите каталоги с сопутствующими товарами </h3>
    @foreach($categories as $ccategory)
      @if($ccategory->catalogs->count() > 0)
  <h4>{{ $ccategory->title }}:</h4>
        @foreach($ccategory->catalogs as $ccatalog)
  <div class="checkbox">
     <label><input type="checkbox" name="connected[]" value="{{ $ccatalog->id }}" @isset($catalog) @if(in_array($ccatalog->id, explode(',', $catalog->connected))) checked @endif @endisset>{{ $ccatalog->title }}</label>
  </div>
        @endforeach
      @endif
    @endforeach

  @if($catalogs_nocategory->count() > 0)  
  <h4>@lang('Uncategorized catalogs'):</h4>
        @foreach($catalogs_nocategory as $ccatalog)
  <div class="checkbox">
     <label><input type="checkbox" name="connected[]" value="{{ $ccatalog->id }}" @isset($catalog) @if(in_array($ccatalog->id, explode(',', $catalog->connected))) checked @endif @endisset>{{ $ccatalog->title }}</label>
  </div>
        @endforeach
  @endif
</div>

@endif