@extends('layouts.user_layout')

@section('content')

<div class="row">
  <div class="col-sm-12">
    {{ Form::open(array('action' => 'LeavesController@store', 'method' => 'post', 'class' => 'form-horizontal')) }}
      <legend class="form-signin-heading">Apply for Leave</legend>
      @include("leaves.form", array("leave" => $leave))
      <div class="form-group">
        <div class="col-sm-12">
          <div class="row">
            <div class="col-sm-6 col-sm-offset-3">
              {{ Form::submit("Apply", array("class" => "btn btn-primary normal-button")) }}
            </div>
          </div>
        </div>
      </div>
    {{ Form::close() }}
  </div>
</div>
@stop