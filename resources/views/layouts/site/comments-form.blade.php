<style type="text/css">
  .star-item{
    color: #FFD02C;
    cursor: pointer;
  }
</style>
<div id="comments-form-modal-block">
          <form action="javascript:void(null);" onsubmit="sendCommentsForm('comments-form-modal')" id="comments-form-modal">
            <input type="hidden" name="page_id" value="{{ $page_id ?? 0 }}">
            <input type="hidden" name="product_id" value="{{ $product_id ?? 0 }}">
            <input type="hidden" name="advert_id" value="{{ $advert_id ?? 0 }}">
            <div class="form-group">
              <label for='name'>@lang('Your name'):</label>
              <input type="text" class="form-control" name="name"  maxlength="50" placeholder="" required="true">
            </div>
            <div class="form-group">
              <label for='name'>@lang('Your comment'):</label>
              <textarea name="comment"  class="form-control" rows="5" maxlength="500" required="true"></textarea> 
            </div>
            <div class="form-group">
              <p class="stars-line">
              @for($i=0; $i<5; $i++)
                <i class="far fa-star star-item" data-id='{{ $i }}'></i>
              @endfor
                <input type="hidden" name="stars" id="stars" value="0">
              </p>
            </div>
            <div class="form-group text-center">
              <button type="submit"  class="btn btn-primary"><i class="far fa-paper-plane"></i> @lang('Send')</button>
            </div>
          </form>
        </div>
        <div id="comments-form-modal-answer" class="d-none">
          <h4>@lang('Thank You')!</h4>
          <p>@lang('Your comment will be published after verification by the site administrator')</p>
        </div>

<script type="text/javascript">
  
  $(document).ready(function(){
    $('#comments-form-answer').slideUp();
    $('.form-group .star-item').mouseover(function(){

      var id = $(this).data('id');

      $('.form-group  .star-item').each(function(){
        if($(this).data('id') <= id)
        {
          $(this).addClass('fas').removeClass('far');
        }
      }); 
    });
    $('.form-group .star-item').mouseout(function()
    {
      if($('.form-group  .stars-set').length == 0)
      {
         $('.form-group  .star-item').addClass('far').removeClass('fas');
      }
      else
      {
        var id = $('.stars-set').data('id');

        $('.form-group .star-item').each(function()
        {
          if($(this).data('id') > id)
          {
            $(this).addClass('far').removeClass('fas');
          }
        }); 
      }
    });
   $('.form-group .star-item').click(function()
    {
     $('.star-item').removeClass("stars-set");

     $(this).addClass('stars-set');

      var id = $('.stars-set').data('id');

      $('#stars').val(id);

      $('.form-group .star-item').each(function()
       {
        if($(this).data('id') > id)
        {
          $(this).addClass('far').removeClass('fas');
        }
      }); 
    }); 
  });
</script>