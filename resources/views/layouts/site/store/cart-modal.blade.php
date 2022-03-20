<style type="text/css">
@media screen and (max-width580px) {
    #cartModal .table#cart-page-content-table td{
        max-width: 100px!important;
        padding: 3px;
    }
    
}
</style>
<script type="text/javascript">
    $(function(){
        cart_content();
    })
</script>
<!-- The Modal -->
<div class="modal fade" id="cartModal" style="max-width: 100%; ">
    <div class="modal-dialog modal-lg modal-cart">
        <div class="modal-content" style="max-width: 100%; ">
      <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title" style="font-family: fnormal; font-size: 25px; text-transform: uppercase; letter-spacing: 3px;"><i class="ri-shopping-cart-2-line" style="font-size: 20px;"></i>  @lang('Cart')</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

      <!-- Modal body -->
            <div class="modal-body">
      	        <table class="table" id="cart-page-content-table" style="max-width:100%;">
	                <tbody>

	                </tbody>
	                <tfoot>
		
	                </tfoot>
                </table>
            </div>

      <!-- Modal footer -->
            <div class="modal-footer" style="flex-wrap: nowrap;">
                <div class="col-6 p-0 text-center">
                    <a href="{{ route('cart') }}" class="btn btn-danger" id="checkout-button"><i class="fas fa-cash-register"></i> @lang('checkout')</a>
                </div>
                <div class="col-6 p-0 text-center">
                    <button type="button" class="btn btn-outline-dark"  data-dismiss="modal"><i class="fas fa-undo"></i> @lang('Continue shopping')</button>
                </div>
            </div>
        </div>
    </div>
</div>