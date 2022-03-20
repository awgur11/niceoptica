<style type="text/css">
.table-socialites{
 // margin-top: 45px;
}
  .table-socialites td{
    vertical-align: middle;
    width: 200px;
  }
  .table-socialites tr td:first-child{
  	text-align: right;
  	width: 200px;
  }
  .table-socialites tr td:nth-child(2){
  	text-align: left;
  }
  .table-socialites td>input{
    //width: 300px;
  }
</style>
@php 
    $socialites_arr = ['facebook','twitter','instagram','linkedin','youtube','google-plus',  'vk', 'whatsapp', 'vimeo', 'reddit']; 
    $socialites_links = isset($site_option['socialites']) ? $site_option['socialites'] : null;
@endphp

<div class="row form-block">
    <div class="col-12">
        <h3 class="text-center">Ссылки на социальные сети</h3>

<form action="javascript:void(null);" onsubmit="option_update('option_socialites')"  id="option_socialites" class="form-horizontal">
    <input type="hidden" name="key" value="socialites">
    <input type="hidden" name="type" value="array">
    <input type="hidden" name="place" value="1">
    <table class="table table-socialites table-hover">

        <tbody>
@foreach($socialites_arr as $sr)
            <tr >
            	<td style="width:20%">
            		<label for='{{ $sr }}' class='control-label'>
                        <i class="fab fa-{{ $sr }}" aria-hidden="true"></i> <span class="capitalize">{{ $sr }}</span>:
                    </label>
            	</td>
            	<td>
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text" id="">https://{{ $sr }}/</span>
              </div>
              <input type="text" name="value[{{ $sr }}]" value="{{ $site_option['socialites'][$sr] ?? null }}" class="form-control" >
            </div>            		
            	</td>
            </tr>
@endforeach
        </tbody>
    </table>
   <div class="form-group text-right" style="margin-top: 15px; padding-bottom: 10px; border-bottom: 1px solid #ddd;">
        <div class="col-sm-12">
            <button class="btn btn-primary">@lang('Save')</button>
        </div>
    </div>
</form>

</div>
</div>
