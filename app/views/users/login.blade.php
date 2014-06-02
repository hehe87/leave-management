@extends('layouts.login_layout')

@section('content')
  <div class="row">
    <br/>
    <br/>
    <div class="col-sm-4 col-sm-offset-4 well">
      <div class="row">
        <div class="col-sm-12">
          @if (Session::has("success"))
            <div class="alert alert-success">
              {{ Session::get('success') }}
            </div>
          @else
            @if (Session::has("error"))
              <div class="alert alert-danger">
                {{ Session::get('error') }}
              </div>
            @endif
          @endif
        </div>
      </div>
      
      <form class="form-signin" role="form" method="post">
        <h2 class="form-signin-heading">Please sign in</h2>
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
        <input class="btn btn-sm btn-primary pull-right" type="submit" value="Sign in">
      </form>
    </div>
  </div>
@stop