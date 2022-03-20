
@if(count($items) > 0)
<style type="text/css">
.comments-block{
    padding: 16px;
}
.comments-card{
    padding: 24px;
    height: 328px;
    background: #FFFFFF;
    border: 1px solid #DCDCDC;
    overflow: hidden;
    position: relative;

}
.comm-title{
    font-family: Nunito Sans;
    font-size: 18px;
    height: 44px;
    font-style: normal;
    font-weight: 700;
    line-height: 22px;
}
.comm-content{
    font-family: Nunito Sans;
    font-size: 18px;
    font-style: normal;
    font-weight: 400;
    line-height: 27px;
}
.comm-stars{
    letter-spacing: 4px;
    color: #FFD02C;
    margin: 12px 0 24px;
}
.blur-block{
    width: 90%;
    height: 90%;
    position: absolute;
    z-index: 9;
    filter: blur(10px);
    background: rgba(255, 255, 255, 0.7);
    display: block;
}
.show-all-reviews-button{
    height: 100%;
    width: 100%;
    position: absolute;
    z-index: 10;
    color: #2C50F2;
    font-family: Nunito Sans;
    font-size: 16px;
    font-style: normal;
    font-weight: 400;
    line-height: 19px;
    transform: translate(-5%, -5%);
    cursor: pointer;
    display: block;
}
@media screen and (max-width: 580px) {
    .comm-content{
        font-size: 13px;
    }
    .comments-card{
        padding: 12px;
    }

}
  
</style>
<script type="text/javascript">
    $(document).on('click', '.show-all-reviews-button', function(){
        $('.comments-block:not(:first-child)').removeClass('d-none');
        $('.comments-card').css('filter', 'blur(0px)');
        $('.blur-block').css('background', 'transparent');
        $(this).addClass('d-none').removeClass('d-flex');
    })
</script>
    @foreach($items as $item)
<div class="comments-block col-xl-3 col-lg-4 col-md-6 @if($loop->index > 6) d-none @endif">
        @if($loop->index == 6)
    <div class="blur-block"></div>
    <div class="show-all-reviews-button d-flex justify-content-center align-items-center">
        @lang('All reviews')
    </div>
        @endif
    <div class="comments-card" @if($loop->index == 6) style="filter: blur(3px);" @endif>
        
        <div class="comm-title">{{ $item->name }}</div>
        <div class="comm-stars">
        @for($i = 0; $i <= $item->stars; $i++)
            <i class="fas fa-star"></i>
        @endfor
        </div>
        <div class="comm-content">{{ $item->comment }}</div>
    </div>
</div>
    @endforeach
@endif