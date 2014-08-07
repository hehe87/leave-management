@extends('layouts.login_layout')
<!--
  Page Name:                        forgotpassword.blade.php
  author :		            Nicolas Naresh
  Date:			            May, 30 2014
  Purpose:		            This page contains user login form
  Table referred:		    -
  Table updated:	            -
  Most Important Related Files:     views/layouts/login_layout.blade.php
-->


@section('content')
  <form class="form-signin" role="form" method="post">
    <legend class="form-signin-heading">Forgot Password</legend>
    <div class="form-group">
      <input class="form-control" placeholder="Email Address" required="1" name="email" type="email">
    </div>
    <a href="{{ URL::route('userLogin') }}" class="btn btn-primary btn-sm button-normal">Back to Login</a>
    <input class="btn btn-sm btn-primary pull-right button-normal" type="submit" value="Submit">
  </form>
@stop