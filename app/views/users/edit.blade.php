@extends('layouts.admin_layout')
<!--
  Page Name:                       edit.blade.php
  author :		            Nicolas Naresh
  Date:			            June, 03 2014
  Purpose:		            This page displays edit user form by including users/form.blade.php
  Table referred:		    -
  Table updated:	            -
  Most Important Related Files:      views/users/form.blade.php, views/layouts/admin_layout.blade.php
-->


@section('content')
  <div class="row">
    <div class="col-sm-12">
      {{ Form::open(array('url' => URL::route('userUpdate',array("id" => $user->id)), 'method' => 'post', 'role' => 'form', 'class' => 'form-horizontal')) }}
        <legend class="form-signin-heading">Edit User Details</legend>
        @include("users.form", array('user'=>$user))
        <div class="form-group">
          <div class="col-sm-3 col-sm-offset-5">
            <a class="btn btn-danger pull-left" href="{{ URL::previous() }}">Cancel</a>
            <input class="btn btn-primary pull-right" type="submit" value="Update User">
          </div>
        </div>
      {{ Form::close() }}
    </div>
  </div>
@stop