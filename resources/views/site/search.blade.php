@extends('site.base')

@section('content')
<style type="text/css">

</style>



<div class="container mt-5" style="padding-bottom: 25px; min-height: 75vh;">
    <div class="row">
        <div class="col-12 text-center mb-4">
            <h1 style="color: #666;">@lang('Search result')</h1>
        </div>
    </div>
@if($products == null)
    <div class="row mt-5">
        <div class="col-12">
            <h2 class="text-center">
                @lang('No results were found for your search')
            </h2>
        </div>
        @isset($site_option['favorites-empty-bg'][$csl])
        <div class="col-12 text-center">
            <img src="{{ asset('storage/images'.$site_option['favorites-empty-bg'][$csl]) }}" style="width: 400px; max-width: 100%;">  
        </div>
  @endisset
    </div>
@else
    <div class="row"> 
        @include('layouts.site.cards.products', ['items' => $products])
    </div>
@endif
    <div class="row justify-content-end">

    </div>
</div>

@endsection