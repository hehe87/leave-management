@extends('layouts.admin_layout')

@section('content')
  <div class="row">
    <div class="col-sm-12">
      {{ Form::open(array('url' => URL::route("userStore"), 'method' => 'post', 'role' => 'form', 'class' => 'form-horizontal')) }}
        <legend class="form-signin-heading">Add New User</legend>
        @include("users.form", array('user'=>$user))
        
        <div class="form-group">
          <div class="col-sm-3 col-sm-offset-5">
            <a class="btn btn-danger pull-left" href="{{ URL::previous() }}">Cancel</a>
            <input class="btn btn-primary pull-right" type="submit" value="Save User">
          </div>
        </div>
      {{ Form::close() }}
    </div>
  </div>
@stop