@extends('layouts.admin_layout')

@section('content')
  <div class="row">
    <div class="col-sm-12">
      {{ Form::open(array('url' => URL::route('holidayUpdate',array("id" => $holiday->id)), 'method' => 'post', 'role' => 'form', 'class' => 'form-horizontal')) }}
        <legend class="form-signin-heading">Edit holiday</legend>
        @include("holidays.form")
        <div class="form-group">
          <div class="col-sm-3 col-sm-offset-5">
            <a class="btn btn-danger pull-left">Cancel</a>
            <input class="btn btn-primary pull-right" type="submit" value="Update Holiday">
          </div>
        </div>
      {{ Form::close() }}
    </div>
  </div>
@stop