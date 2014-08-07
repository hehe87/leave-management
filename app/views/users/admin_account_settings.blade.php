<!--
  Page Name:                            admin_account_settings.blade.php
  author :		                          Nicolas Naresh
  Date:			                            June, 10 2014
  Purpose:		                          This page contains the form for updating the admin user details
  Table referred:		    -
  Table updated:	            -
  Most Important Related Files:     -
-->
{{ Form::open(array('url' => URL::route('users.postSettings'), 'method' => 'post', 'role' => 'form', 'class' => 'form-horizontal not-rounded')) }}
  <legend class="form-signin-heading">Account Settings</legend>
  <div class="form-group">
    <div class="col-sm-12">
      <div class="row">
        <div class="col-sm-3">
          {{ Form::label('admin_account[email]', 'Email *', array('class' => 'control-label')) }}
        </div>
        <div class="col-sm-8">
          {{ Form::text('admin_account[email]', Auth::user()->email, array('class' => 'form-control', 'placeholder' => 'Email')) }}
        </div>
      </div>
      @if ($errors->first('email'))
        <div class="row">
          <div class="col-sm-8 col-sm-offset-3">
            <div class="alert alert-danger">
              {{{ $errors->first('email') }}}
            </div>
          </div>
        </div>
      @endif
    </div>
  </div>

  <div class="form-group">
    <div class="col-sm-12">
      <div class="row">
        <div class="col-sm-3">
          {{ Form::label('admin_account[password]', 'Password *', array('class' => 'control-label')) }}
        </div>
        <div class="col-sm-8">
          {{ Form::password('admin_account[password]', array('class' => 'form-control', 'placeholder' => 'Password')) }}
        </div>
      </div>
      @if ($errors->first('password'))
        <div class="row">
          <div class="col-sm-8 col-sm-offset-3">
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
        <div class="col-sm-3">
          {{ Form::label('admin_account[password_confirmation]', 'Confirm Password *', array('class' => 'control-label')) }}
        </div>
        <div class="col-sm-8">
          {{ Form::password('admin_account[password_confirmation]', array('class' => 'form-control', 'placeholder' => 'Confirm Password')) }}
        </div>
      </div>
      @if ($errors->first('password_confirmation'))
        <div class="row">
          <div class="col-sm-8 col-sm-offset-3">
            <div class="alert alert-danger">
              {{{ $errors->first('password_confirmation') }}}
            </div>
          </div>
        </div>
      @endif
    </div>
  </div>

  <div class="form-group">
    <div class="col-sm-8 col-sm-offset-3">
      <a class="btn btn-danger pull-left" href="{{ URL::previous() }}">Cancel</a>
      <input class="btn btn-primary pull-right" type="submit" value="Update">
    </div>
  </div>
{{ Form::close() }}