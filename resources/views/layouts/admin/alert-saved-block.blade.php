<style type="text/css">
    #alert-saved-block{
        position: fixed;
        z-index: 9999;
        top: 0;
        right: 0;
        padding: 15px 30px;
        border-radius: 0;
        font-family: fbold;
        font-size: 16px;
        text-transform: uppercase;
        letter-spacing: 2px;
        transform: translateY(-100%);
        transition: 1s;
    }
    #alert-saved-block.show{
        transform: translateY(0);
    }
</style>

<div id="alert-saved-block" class="alert-success alert">
    @lang('Saved')
</div>
<script type="text/javascript">
    function saved_window_show()
    {
        $('#alert-saved-block').addClass('show');
        setTimeout(saved_window_hide, 2000);        
    }
    function saved_window_hide(){
        $('#alert-saved-block').removeClass('show');
    }
</script>