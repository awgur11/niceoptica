<style type="text/css">
  #cb-form-block-answer h4{
    font-size: 30px;
    font-family: fbold;
  }
  #cb-form-block-answer p{
    font-family: fnormal;
    font-size: 18px;
  }
  #callbackModal{
    z-index: 10099950;
  }
</style>
<!-- The Modal -->
<div class="modal fade" id="callbackModal">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">{{ $site_option['cbb_modal_title'] ?? null }}</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <div id="cb-form-block">
          <form action="javascript:void(null);" onsubmit="callbackForm('cb-form')" id="cb-form">
            @csrf
            <input type="hidden" name="subject" value="Сообщение с Вашего сайта {{ $_SERVER['SERVER_NAME'] }}">
            <div class="form-group">
              <label for="usr">@lang('Your name'):</label>
              <input type="hidden" name="question[0]" value="@lang('Name')">
              <input type="text" class="form-control" id="usr" name="answer[0]">
            </div>
            <div class="form-group">
              <label for="usr">@lang('Your phone number'):</label>
              <input type="hidden" name="question[1]" value="@lang('Phone number')">
              <input type="text" class="form-control" id="usr" name="answer[1]">
            </div>
            <div class="form-group">
              <label for="usr">@lang('Your comment'):</label>
              <input type="hidden" name="question[2]" value="@lang('Comment')">
              <textarea class="form-control" id="usr" name="answer[2]"></textarea>
            </div>

            <div class="form-group text-center">
              <button class="btn btn-primary"><i class="far fa-paper-plane"></i> @lang('Send')</button>
            </div>
          </form>
        </div>
        <div id="cb-form-block-answer" class="d-none">
          <h4>@lang('Thank You')!!</h4>
          <p>{{ $site_option['cbb_modal_answer'] ?? null }}</p>
        </div>
      </div>

      <!-- Modal footer -->
  <!--    <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>-->

    </div>
  </div>
</div>
