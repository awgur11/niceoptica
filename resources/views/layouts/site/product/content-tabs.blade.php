<style type="text/css">
  .nav.nav-tabs{
    border-bottom: 1px solid #DCDCDC;
  }
  .nav.nav-tabs .nav-item{
    font-family: Nunito Sans;
    font-size: 18px;
    font-style: normal;
    font-weight: 400;
    line-height: 22px;
    margin-right: 56px;
    color: #202020;
    padding-bottom: 0;
    border: none;
  }
  .nav.nav-tabs .nav-link:hover{
    border: none;
  }
  .nav.nav-tabs .nav-link{
    color: #202020;
  }

  .nav.nav-tabs .nav-link.active{
    border: none;
    border-bottom: 2px solid #2C50F2;
  }
  .tab-pane{
  //  padding-top: 10px;
  }
  .tab-pane .table td{
    font-family: Nunito Sans;
    font-size: 14px;
    font-style: normal;
    line-height: 16px;
    color: #202020;
  }
  .tab-pane .table tr:first-child td{
    border-top: none;
  }
  .tab-pane .table tr td:first-child{
    font-weight: 600;
  }
  .tab-pane .table tr td:nth-child(2){
    font-weight: 300;
  }
@media screen and (max-width: 580px) {
  .nav.nav-tabs{
    border-bottom: none;
  }
  .nav.nav-tabs .nav-item{
    width: 100%;
    margin: 1px;
  }
  .nav.nav-tabs .nav-item{
    margin: 0;
    width: 100%;
    border-bottom: 1px solid #DCDCDC;
  }
  .nav.nav-tabs .nav-link{
    padding: 15px 0;
  }
  .nav.nav-tabs .nav-link.active{
    border: none;
  }
  .nav.nav-tabs .nav-link.active + .dd{
    transform: rotate(180deg);
  }
}

</style>
<!-- Nav tabs -->
<ul class="nav nav-tabs">
  <li class="nav-item d-flex justify-content-between align-items-center">
    <a class="nav-link" data-toggle="tab" href="#menu1">@lang('Description')</a>
    <div class="d-md-none dd">
      <span class="icon-Chevron---Down"></span>
    </div>
  </li>
  <li class="nav-item d-flex justify-content-between align-items-center"> 
    <a class="nav-link active" data-toggle="tab" href="#home">@lang('Specification')</a>
    <div class="d-md-none dd">
      <span class="icon-Chevron---Down"></span>
    </div>
  </li>
  <li class="nav-item d-flex justify-content-between align-items-center">
    <a class="nav-link" data-toggle="tab" href="#menu2">@lang('Customs reviews')</a>
    <div class="d-md-none dd">
      <span class="icon-Chevron---Down"></span>
    </div>
  </li>
</ul>

<!-- Tab panes -->
<div class="tab-content">
  
  <div class="tab-pane container-fluid fade page-content px-0 pt-3" id="menu1">
    {!! $product->language->content !!}
  </div>

  <div class="tab-pane container-fluid active px-0 pt-3" id="home">
    <table class="table shot-fvalues table-striped" style="max-width: 500px;">
@foreach($product->catalog->filters->where('active', 0) as $filter)
  @if($product->fvalues->where('filter_id', $filter->id)->count() >0)
      <tr>
        <td>{{ $filter->language->title }}:</td>
        <td>
    @foreach($product->fvalues->where('filter_id', $filter->id)->unique() as $fvalue)
      {{ $fvalue->language->title }}
    @endforeach
        </td>
      </tr>
  @endif
 @endforeach
    </table>
  </div>
<style type="text/css">
@media screen and (max-width: 580px){
  #comments-block{
    overflow-x: auto;
    display: block;
    white-space: nowrap;
  }
  #comments-block .comments-block:not(.d-none){
    display: inline-block!important;
    white-space: normal;

    float: none;
  }
}
</style>

  <div class="tab-pane container-fluid fade px-0 pt-3 row m-0" id="menu2">

      <div id="comments-block" class="row">
        <div class="col-lg-3 col-md-6 d-none d-md-block comments-block" >
          <div class="leave-comment-button"  data-toggle="modal" data-target="#commentsFormModal">
            @lang('Leave review')
          </div>
        </div>
      
      @include('layouts.site.comments', ['items' => $product->comments])
      </div>
      <div class="d-md-none mt-3 col-12">
        <div class="leave-comment-button col d-block d-md-none"  data-toggle="modal" data-target="#commentsFormModal">
         @lang('Leave review')
        </div>
        
      </div>

  </div>

</div>
<style type="text/css">
  .leave-comment-button{
    border: 1px solid #2C50F2;
    background: #fff;
    padding: 154px 0;
    text-align: center;
    font-family: Nunito Sans;
    font-size: 16px;
    font-style: normal;
    height: 328px;
    font-weight: 400;
    line-height: 19px;
    cursor: pointer;
    color: #2C50F2;
    transition: 0.3s;
    margin-bottom: 16px;
  }
  .leave-comment-button:hover{
    background: #F1F4FF;
  }
@media screen and (max-width: 580px) {
  .leave-comment-button{
    height: 56px;
    padding: 20px 0;
  }
}

</style>
@include('layouts.site.comments-form-modal')