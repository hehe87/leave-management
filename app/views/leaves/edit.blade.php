@extends('layouts.user_layout')

@section('content')

<div class="row">
  <div class="col-sm-12">
    {{ Form::open(array('url' => URL::route('leaves.update', $leave->id), 'method' => 'post', 'class' => 'form-horizontal', 'id' => 'leaves_edit_form')) }}
      <legend class="form-signin-heading">Edit Leave</legend>
      @include("leaves.form", array("leave" => $leave, "formFor" => "edit"))
      <div class="form-group">
        <div class="col-sm-12">
          <div class="row">
            <div class="col-sm-6 col-sm-offset-2">
              {{ Form::submit("Apply", array("class" => "btn btn-primary normal-button pull-right")) }}
            </div>
          </div>
        </div>
      </div>
    {{ Form::close() }}
  </div>
</div>
@stop