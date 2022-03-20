<style type="text/css">
  #cb-form-block-answer h4{
    font-size: 30px;
    font-family: fbold;
  }
  #cb-form-block-answer p{
    font-family: fnormal;
    font-size: 18px;
  }
  .star-item{
    color: #ff8300;
    cursor: pointer;
  }
  #commentsFormModal .modal-content{
    border-radius: 0;
    box-shadow: 0 0 25px rgba(0,0,0,.4);
  }
</style>
<!-- The Modal -->
<div class="modal fade" id="commentsFormModal">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">@lang('Leave review')</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        @include('layouts.site.comments-form', ['product_id' => $product->id])
      </div>

      <!-- Modal footer 
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>-->

    </div>
  </div>
</div>


