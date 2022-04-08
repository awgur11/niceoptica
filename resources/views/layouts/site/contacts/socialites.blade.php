<style type="text/css">
    a:hover{
        text-decoration: none;
    }
   	.socialite-item{
   		margin: 0 0 0 31px;
   		color: #0a0a0a;
   		display: inline-block;

        font-size: 24px;
   		transition: 0.3s;
        text-align: center;
        box-sizing: border-box;
        position: relative;
        z-index: 3;
   	}
    .socialite-item i{
        position: relative;
        z-index: 5;
        left: 0;
        transition: 0.3s;
        font-size: 24px;

    }
    .socialite-item:hover:after{
        left: 0px;
        opacity: 0;
    }
    .socialite-item:hover{
      //  border:2px solid #fff;
    }
  	.socialite-item:hover i{
        color: #2C50F2!important;
   	}
    #footer .socialite-item{
        color: #2C50F2;
        font-size: 20px;
        color: #333;
    }
    #footer .socialite-item:hover{
        color: #2C50F2!important;
    }
</style>

@foreach(['facebook','twitter','instagram','linkedin','youtube','google-plus', 'pinterest', 'telegram', 'viber', 'whatsapp', 'vimeo'] as $soc)
    @if(isset($site_option['socialites'][$soc]) && $site_option['socialites'][$soc] != null)
        @if($soc == 'telegram') 
<a  rel="nofollow" href="tg://resolve?domain={{ $site_option['socialites'][$soc] ?? null }}" target="_blank" class="hidden-md hidden-lg">
        @elseif($soc == 'viber')
        <a href="viber://contact?number={{ $site_option['socialites'][$soc] ?? null }}">
        @elseif($soc == 'whatsapp')
        <a tar href="https://api.whatsapp.com/send?phone={{ $site_option['socialites'][$soc] ?? null }}">
        @else
<a  rel="nofollow"  href="https://{{ $soc }}.com/{{ $site_option['socialites'][$soc] ?? null }}" target="_blank">
        @endif
    <div class="socialite-item" data-toggle="tooltip" title="{{ $soc }}">
        <i class="fab fa-{{ $soc }}"></i>
    </div>
</a>
    @endif
@endforeach
  