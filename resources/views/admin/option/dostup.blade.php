@extends('admin.base')

@section('content')


@include('layouts.admin.header', ['title' => __('Access'), 'description' => __('Editing name email and password')])

<div class="container" >   
  <div class="row justify-content-start mb-3">
    <div class="col-2">
      <a  class="btn btn-outline-success create-category-button" href="{{ route('admin.index') }}"><i class="fas fa-arrow-left"></i> @lang('Back')</a>
    </div>
    <div class="col-sm-6">
    </div>
  </div>
</div>
<div class="container" id="dostup">
  <div class="admin-content">
    <div class="row">
      <div class="col-sm-2  text-right" style="padding-top: 5px;">
        <b>@lang('Name'):</b>
      </div>
      <div class="col-sm-4">
        <input type="text" maxlength="150" v-model="name" class="form-control">
      </div>
      <div class="col-sm-3">
        <button class="btn btn-outline-primary" @click="update_field('name')">@lang('Изменить')</button>
      </div>
    </div>
    <div class="row mt-3">
      <div class="col-sm-2  text-right" style="padding-top: 5px;">
        <b>@lang('Email'):</b>
      </div>
      <div class="col-sm-4">
        <input type="email" maxlength="150" v-model="email" class="form-control">
      </div>
      <div class="col-sm-3">
        <button class="btn btn-outline-primary" @click="update_field('email')">@lang('Изменить')</button>
      </div>
    </div>
    <div class="row mt-3">
      <div class="col-5">
        <h5 class="text-right">Изменение пароля:</h5>
      </div>
    </div>
    <div class="row mt-3">
      <div class="col-sm-3  text-right" style="padding-top: 5px;">
        <b>Старый пароль:</b>
      </div>
      <div class="col-sm-3">
        <input type="password" maxlength="150" v-model="old_password" class="form-control"> 
      </div>
    </div>
    <div class="row mt-3">
      <div class="col-sm-3  text-right" style="padding-top: 5px;">
        <b>Новый пароль:</b>
      </div>
      <div class="col-sm-3">
        <input type="password" maxlength="150" v-model="new_password" class="form-control"> 
      </div>
    </div>
    <div class="row mt-3">
      <div class="col-sm-3  text-right" style="padding-top: 5px;">
        <b>Повторите пароль:</b>
      </div>
      <div class="col-sm-3">
        <input type="password" maxlength="150" v-model="repeat_password" class="form-control">
      </div>
    </div>
    <div class="row mt-3">
      <div class="col-6 text-right">
        <button type="button" class="btn btn-outline-primary" @click.prevent="update_password">@lang('Изменить')</button>
      </div>
    </div>
  </div>
  <div id="alert-block" :class="{close: close_alert_status, 'alert-success' : alert_success, 'alert-danger' : !alert_success}" class="alert">

      <button class="btn btn-lg alert-close-button" @click="close_alert"><i class="fas fa-times"></i></button>

    <div class="alert-body">
      @{{ alert_text}}
    </div>
  </div>
</div>

<script type="text/javascript">
  const dostup = new Vue({
    el: "#dostup",
    data: {
      name: "{{ Auth::user()->name ?? null }}",
      email: "{{ Auth::user()->email ?? null }}",
      auth_id: "{{ Auth::id() ?? null }}",
      old_password: '',
      new_password: '',
      repeat_password: '',
      alert_text: "Поле успешно изменено",
      alert_success: true,
      close_alert_status: true
    },
    methods:{
      update_field: function(field){
        var params = {
          table: 'users',
          column: field,
          value: this[field],
          id: this.auth_id,
          _token: "{{ csrf_token() }}"
        };

        axios.get("{{ route('change.cell') }}", { params:params
              })
              .then((response) => {
                this.alert_text = "Поле успешно изменено";
                dostup.close_alert_status = false;        
              })
              .catch(function (error) {
              }); 
      },
      update_password: function(){
        var params = {
          old_password: this.old_password,
          new_password: this.new_password,
          repeat_password: this.repeat_password,
          user_id: this.auth_id,
          _token: "{{ csrf_token() }}"
        };


        axios.get("{{ route('admin.password.update') }}", {
                params:params
              })
              .then((response) => {
                this.alert_success = response.data.success;        
                this.alert_text = response.data.data.text;
                this.close_alert_status = false;

                console.log(this.alert_success);
              })
              .catch(function (error) {
                console.log(error);
              }); 
      },
      close_alert: function(){
        this.close_alert_status = true;
      }
    }
  })
</script>
<style type="text/css">
  #alert-block{
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translateY(-50%) translateX(-50%) scale(1);
    transition: 0.3s;
    width: 350px;
    max-width: 100%;
    background-color: #def0dc;
    box-shadow: 0 10px 35px -20px rgba(0,0,0,0.2);
    display: block;
  }
  .alert-body{
    text-align: center;
    font-size: 20px;
    padding: 30px 0;
  }
  .alert-close-button{
    position: absolute;
    right: 0;
    top: 0;
    font-size: 20px;
    color: #d33;
  }
  #alert-block.close{
    opacity: 0;
    display: none;
     transform: translateY(-50%) translateX(-50%) scale(0.95);
  }
</style>
@endsection