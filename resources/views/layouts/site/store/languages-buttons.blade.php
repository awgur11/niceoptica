@if(count($languages_buttons) > 1)

<style type="text/css">
  .hover-select-block{
    color: #202020;
    text-transform: uppercase;
    font-size: 16px;
    position: relative;
    padding: 12px 5px;
    cursor: pointer;
    white-space: nowrap;
    font-family: 'Nunito Sans', sans-serif;
   }
   .hover-select-block i:not(.fa-phone-alt){
    font-size: 12px;
   }
   .hover-select-block i{
    padding: 0 7px;
   }
  .hover-select-items{
    min-width: 100%;
    background: #1a1a1a;
   // border: 1px solid #aaa;
    top: 90%;
    left: 1px;
    position: absolute;
    text-align: center;
    transition: top 0.3s, opacity 0.3s;
    opacity: 0;
    display: none;
    box-shadow: 0 0 10px rgba(0,0,0,0.1);
  }

  .hover-select-block:hover{
    z-index: 999;
  }
  .hover-select-block:hover .hover-select-items{
    top: 100%;
    opacity: 1;
    display: block;
  }
  .hover-select-item{
    display: block;
    color: #202020;
    background: #fff;
    transition: 0.3s;
    padding: 10px;
    
    font-family: 'Nunito Sans', sans-serif;
    font-size: 16px;
    text-transform: uppercase;
    text-align: center;
  }
  .hover-select-item:hover,
  .hover-select-item.selected{
    color: #fff;
    background: #2848DA;
  }
  .hover-select-item.selected{
    pointer-events: none;
  }
@media screen and (max-width: 768px) {
  .hover-select-block{
    font-size: 12px;
  }
  
}

</style>
    <div class="hover-select-block">
      {{ $csl }} <i class="fas fa-chevron-down"></i>
      <div class="hover-select-items">
    @foreach($languages_buttons as $sl)
      @if($sl['locale'] == $csl)
         @continue
      @endif
        <a class="hover-select-item" href="{{ url($sl['link']) }}">{{ $sl['locale'] }}</a>
    @endforeach
      </div>
    </div>
  <!-- endif -->

@endif