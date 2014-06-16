<!--
  Page Name:                        google_api_settings.blade.php
  author :		            Nicolas Naresh
  Date:			            June, 10 2014
  Purpose:		            This page contains the form for updating the google api settings
  Table referred:		    -
  Table updated:	            -
  Most Important Related Files:     -
-->
{{ Form::open(array('url' => URL::route('users.postSettings'), 'method' => 'post', 'role' => 'form', 'class' => 'form-horizontal')) }}
  <legend class="form-signin-heading">Google API Settings</legend>
  <div class="form-group">
    <div class="col-sm-12">
      <div class="row">
        <div class="col-sm-3">
          {{ Form::label('gapi[client_id]', 'Client ID *', array('class' => 'control-label')) }}
        </div>
        <div class="col-sm-8">
          {{ Form::text('gapi[client_id]', Config::get('google.client_id'), array('class' => 'form-control', 'placeholder' => 'Client ID')) }}
        </div>
      </div>
      @if ($errors->first('client_id'))
        <div class="row">
          <div class="col-sm-8 col-sm-offset-3">
            <div class="alert alert-danger">
              {{{ $errors->first('client_id') }}}
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
          {{ Form::label('gapi[service_account_name]', 'Service Account Name *', array('class' => 'control-label')) }}
        </div>
        <div class="col-sm-8">
          {{ Form::text('gapi[service_account_name]', Config::get('google.service_account_name'), array('class' => 'form-control', 'placeholder' => 'Service Account Name')) }}
        </div>
      </div>
      @if ($errors->first('service_account_name'))
        <div class="row">
          <div class="col-sm-8 col-sm-offset-3">
            <div class="alert alert-danger">
              {{{ $errors->first('service_account_name') }}}
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
          {{ Form::label('gapi[key_file_location]', 'Key File Location *', array('class' => 'control-label')) }}
        </div>
        <div class="col-sm-8">
          {{ Form::text('gapi[key_file_location]', str_replace(base_path(),"",Config::get('google.key_file_location')), array('class' => 'form-control', 'placeholder' => 'Key File Location')) }}
        </div>
      </div>
      @if ($errors->first('key_file_location'))
        <div class="row">
          <div class="col-sm-8 col-sm-offset-3">
            <div class="alert alert-danger">
              {{{ $errors->first('key_file_location') }}}
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
          {{ Form::label('gapi[timezone]', 'Time Zone *', array('class' => 'control-label')) }}
        </div>
        <div class="col-sm-8">
          {{ Form::text('gapi[timezone]', Config::get('google.timezone'), array('class' => 'form-control', 'placeholder' => 'Time Zone')) }}
        </div>
      </div>
      @if ($errors->first('timezone'))
        <div class="row">
          <div class="col-sm-8 col-sm-offset-3">
            <div class="alert alert-danger">
              {{{ $errors->first('timezone') }}}
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
          {{ Form::label('gapi[calendar_id]', 'Calendar ID *', array('class' => 'control-label')) }}
        </div>
        <div class="col-sm-8">
          {{ Form::text('gapi[calendar_id]', Config::get('google.calendar_id'), array('class' => 'form-control', 'placeholder' => 'Calendar ID')) }}
        </div>
      </div>
      @if ($errors->first('calendar_id'))
        <div class="row">
          <div class="col-sm-8 col-sm-offset-3">
            <div class="alert alert-danger">
              {{{ $errors->first('calendar_id') }}}
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