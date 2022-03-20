<style type="text/css">
  .filter-block{
    padding-bottom: 10px;
    margin-bottom: 10px;
  }
  .filter-block:not(:last-child){
    border-bottom: 1px solid #ddd;
  }
  .filter-block .filter-title{
    padding: 10px 15px;
  }
  .filter-title-block{
    text-transform: lowercase;
    font-weight: bold;
    letter-spacing: 2px;
    font-size: 17px;
  }

  .fvalue-checkbox{
    padding: 5px;
    margin:7px 5px;
    border:1px solid #ddd;
    background-color: #eee;
    cursor: pointer;
  }
  .fvalue-checkbox span{
    position: relative;
 //   top: -3px;
    margin-left: 6px;
    font-size: 9pt;
    color: #339;
  }
  .fvalue-checkbox input{
  	position: relative;
  	top:  2px;
  }
  .filter-fvalues-block{
  	max-height: 250px;
  	overflow: auto;
  }
</style>
<h3 class="text-center">@lang('Select catalog`s filters')</h3>
<div class="form-block my-2 row d-flex align-items-center p-2" id="filters-block">
	<div class="col-sm-12 filter-block" id="filter-block-" v-for="(filter, index) in filters" :key="filter.id">
		<label class="filter-title-block form-check-label"><input  type="checkbox"  class="filter-checkbox" :value="filter.id" v-model="filter.checked"  class="form-check-input"> @{{ filter.language.title }}</label> <span class="badge badge-primary">@{{ filter.fvalues.length }}</span> <input type="text" v-model="filter_field" v-if="filter.fvalues.length > 100" placeholder="@lang('Filter')" @keyup.prevent="filteringFvalues(index)">

		<div :class="'filter-fvalues-block ' + filter.show" v-if="filter.checked">
		    <label class="fvalue-checkbox" v-for="(fvalue, findex) in filter.fvalues" :key="fvalue.id" v-if="fvalue.show != 0"><input type="checkbox"   name="fvalues[]" :value="fvalue.id" v-model="fvalue.checked"> <span>@{{ fvalue.language.title }}</span></label>
	    </div>

	</div>

</div>
<script type="text/javascript">
var fb = new Vue({
	el: "#filters-block",
	data:{
		filters: {!! $filters->slice(1,1)->values()->toJson() !!},
		filter_field: '',
	},
	methods:{
		//filtering filters values
		filteringFvalues: function(filter_index){
			var filter_field = this.filter_field,
			    filter_obj = this.filters[filter_index];

			    

					filter_obj.fvalues.forEach(function(val, findex, fobj){
						console.log(filter_field);
						if(filter_field.trim() == '')
						{
							fobj.fvalues[findex].show = 1;
						}
						else if(val.language.title.indexOf(filter_field) == -1)
						{
							
							fobj.fvalues[findex].show = 0;
						}
						else
						{
						//	console.log(val.language.title);
							fobj.fvalues[findex].show = 1;
						}

					});
				


		}
	}
});
</script>