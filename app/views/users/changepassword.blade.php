@extends('layouts.login_layout')
<!--
  Page Name:                        changepassword.blade.php
  author :		            Nicolas Naresh
  Date:			            June, 04 2014
  Purpose:		            This page provides change password form to user
  Table referred:		    -
  Table updated:	            -
  Most Important Related Files:     views/layouts/login_layout.blade.php
-->


@section('content')
  <form class="form-horizontal" action="{{ URL::route('postUserChangePassword', array('token' => $token)) }}" role="form" method="post">
    <legend class="form-signin-heading">Change Your Password below</legend>
    <div class="form-group">
      <div class="col-sm-12">
        <div class="row">
          <div class="col-sm-12">
            <input class="form-control" placeholder="Password" required="1" name="password" type="password">
          </div>
        </div>
        @if ($errors->first('password'))
          <div class="row">
            <div class="col-sm-12">
              <div class="alert alert-danger">
                {{{ $errors->first('password') }}}
              </div>
            </div>
          </div>
        @endif
      </div>
    </div>
    <div class="form-group">
      <div class="col-sm-12">
        <div class="row">
          <div class="col-sm-12">
            <input class="form-control" placeholder="Confirm Password" required="1" name="password_confirmation" type="password">
          </div>
        </div>
        @if ($errors->first('password_confirmation'))
          <div class="row">
            <div class="col-sm-12">
              <div class="alert alert-danger">
                {{{ $errors->first('password_confirmation') }}}
              </div>
            </div>
          </div>
        @endif
      </div>
    </div>
    <input class="btn btn-sm btn-primary pull-right button-normal" type="submit" value="Change Password">
  </form>
@stop