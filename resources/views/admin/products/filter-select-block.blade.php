@isset($filter)
<div class="form-group">
  <select class="form-control" id="filter-by-brand">
  	<option value="">Фильтровать по производителю</option>
  	@foreach($filter as $f)
    <option value="{{ $f->id }}" @if(app('request')->input('brand_id') == $f->id) selected @endif>{{ $f->language->title }}</option>
    @endforeach

  </select>
</div>
<script type="text/javascript">
	$(document).on('change', '#filter-by-brand', function(){
		var brand_id = $(this).val(),
		    url = window.location.pathname;

		    window.location.href = url + '?brand_id=' + brand_id;
	})
</script>

@endisset