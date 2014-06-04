@extends('layouts.admin_layout')
<!--
  Page Name:                        edit.blade.php
  author :		            Nicolas Naresh
  Date:			            June, 03 2014
  Purpose:		            This page displays edit holiday form by including holidays/form.blade.php
  Table referred:		    -
  Table updated:	            -
  Most Important Related Files:     views/holidays/form.blade.php, views/layouts/admin_layout.blade.php
-->


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