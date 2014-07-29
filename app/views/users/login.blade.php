@extends('layouts.login_layout')
<!--
  Page Name:                        login.blade.php
  author :		            Nicolas Naresh
  Date:			            May, 30 2014
  Purpose:		            This page contains user login form
  Table referred:		    -
  Table updated:	            -
  Most Important Related Files:     views/layouts/login_layout.blade.php
-->


@section('content')
  <form class="form-signin" role="form" method="post">
    <legend class="form-signin-heading">Please sign in</legend>
    <div class="row">
      <div class="col-sm-12">
        <a href="logingoogle">{{ HTML::image('/assets/images/sigin-in-with-google.png', $alt='Google Sign In') }}</a>
      </div>
    </div>
    <div class="row">&nbsp;</div>
    <div class="form-group">
      <input class="form-control" placeholder="Email Address" required="1" name="email" type="email">
    </div>
    <div class="form-group">
      <input class="form-control" placeholder="Password" required="1" name="password" type="password" value="">
    </div>
    <div class="checkbox">
      <label for="rememberMe">Remember me</label>
      <input name="rememberMe" type="checkbox" value="1" id="rememberMe">
    </div>
    <a href="{{ URL::route('userForgotPassword') }}" class="btn btn-primary btn-sm button-normal">Forgot Password?</a>
    <input class="btn btn-sm btn-primary pull-right button-normal" type="submit" value="Sign in">
  </form>
@stop