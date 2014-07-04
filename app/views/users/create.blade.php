@extends('layouts.admin_layout')
<!--
  Page Name:                       create.blade.php
  author :		            Nicolas Naresh
  Date:			            June, 03 2014
  Purpose:		            This page displays add user form by including users/form.blade.php
  Table referred:		    -
  Table updated:	            -
  Most Important Related Files:      views/users/form.blade.php, views/layouts/admin_layout.blade.php
-->


@section('content')
  <div class="row">
    <div class="col-sm-12">
      {{ Form::open(array('url' => URL::route("userStore"), 'method' => 'post', 'role' => 'form', 'class' => 'form-horizontal')) }}
        <legend class="form-signin-heading">Add New User</legend>
        @include("users.form", array('user'=>$user))

        <div class="form-group">
          <div class="col-sm-6 col-sm-offset-2">
            <a class="btn btn-danger pull-left" href="{{ URL::route('usersListing') }}">Cancel</a>
            <input class="btn btn-primary pull-right" type="submit" value="Save User">
          </div>
        </div>
      {{ Form::close() }}
    </div>
  </div>
@stop