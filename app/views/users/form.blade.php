<!--
  Page Name:                        form.blade.php
  author :		            Nicolas Naresh
  Date:			            June, 03 2014
  Purpose:		            This page contains the form structure for user add/edit pages
  Table referred:		    -
  Table updated:	            -
  Most Important Related Files:     -
-->
<div class="form-group">
  <div class="col-sm-12">
    <div class="row">
      <div class="col-sm-2">
        {{ Form::label('name', 'Name *', array('class' => 'control-label')) }}
      </div>
      <div class="col-sm-6">
        {{ Form::text('name', $user->name, array('class' => 'form-control', 'placeholder' => 'Full Name')) }}
      </div>
    </div>
    @if ($errors->first('name'))
      <div class="row">
        <div class="col-sm-6 col-sm-offset-2">
          <div class="alert alert-danger">
            {{{ $errors->first('name') }}}
          </div>
        </div>
      </div>
    @endif
  </div>
</div>

<div class="form-group">
  <div class="col-sm-12">
    <div class="row">
      <div class="col-sm-2">
        {{ Form::label('email', 'Email *', array('class' => 'control-label')) }}
      </div>
      <div class="col-sm-6">
        {{ Form::email('email', $user->email, array('class' => 'form-control', 'placeholder' => 'Email')) }}
      </div>
    </div>
    @if ($errors->first('email'))
      <div class="row">
        <div class="col-sm-6 col-sm-offset-2">
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
      <div class="col-sm-2">
        {{ Form::label('employeeType', 'User Type *', array('class' => 'control-label')) }}
      </div>
      <div class="col-sm-6">
        {{ Form::select('employeeType', array('ADMIN' => 'ADMIN','EMPLOYEE' => 'EMPLOYEE'),(null !== Input::old('employeeType')) ? Input::old('employeeType') : $user->employeeType,array('class' => 'form-control')) }}
      </div>
    </div>
    @if ($errors->first('employeeType'))
      <div class="row">
        <div class="col-sm-6 col-sm-offset-3">
          <div class="alert alert-danger">
            {{{ $errors->first('employeeType') }}}
          </div>
        </div>
      </div>
    @endif
  </div>
</div>


<div class="form-group has-feedback">
  <div class="col-sm-12">
    <div class="row">
      <div class="col-sm-2">
        {{ Form::label('doj', 'Date of Joining *', array('class' => 'control-label')) }}
      </div>
      <div class="col-sm-6">
        {{ Form::text('doj', $user->doj, array('class' => 'form-control date_control', 'placeholder' => 'Date of Joining')) }}
        <span class="glyphicon glyphicon-calendar form-control-feedback"></span>
      </div>
    </div>
    @if ($errors->first('doj'))
      <div class="row">
        <div class="col-sm-6 col-sm-offset-2">
          <div class="alert alert-danger">
            {{{ $errors->first('doj') }}}
          </div>
        </div>
      </div>
    @endif
  </div>
</div>

<div class="form-group has-feedback">
  <div class="col-sm-12">
    <div class="row">
      <div class="col-sm-2">
        {{ Form::label('dob', 'Date of Birth *', array('class' => 'control-label')) }}
      </div>
      <div class="col-sm-6">
        {{ Form::text('dob', $user->dob, array('class' => 'form-control date_control', 'placeholder' => 'Date of Birth')) }}
        <span class="glyphicon glyphicon-calendar form-control-feedback"></span>
      </div>
    </div>
    @if ($errors->first('dob'))
      <div class="row">
        <div class="col-sm-6 col-sm-offset-2">
          <div class="alert alert-danger">
            {{{ $errors->first('dob') }}}
          </div>
        </div>
      </div>
    @endif
  </div>
</div>

<div class="form-group has-feedback">
  <div class="col-sm-12">
    <div class="row">
      <div class="col-sm-2">
        {{ Form::label('inTime', 'In/Out Time', array('class' => 'control-label')) }}
      </div>
      <div class="col-sm-3">
        {{ Form::text('inTime', date('h:i A', strtotime($user->inTime)), array('class' => 'form-control timepicker', 'placeholder' => 'In Time (hh:mm)')) }}
        <span class="glyphicon glyphicon-time form-control-feedback"></span>
      </div>
      <div class="col-sm-3">
        {{ Form::text('outTime', date('h:i A', strtotime($user->outTime)), array('class' => 'form-control timepicker', 'placeholder' => 'Out Time (hh:mm)')) }}
        <span class="glyphicon glyphicon-time form-control-feedback"></span>
      </div>
    </div>
    @if ($errors->first('inTime'))
      <div class="row">
        <div class="col-sm-6 col-sm-offset-2">
          <div class="alert alert-danger">
            {{{ $errors->first('inTime') }}}
          </div>
        </div>
      </div>
    @endif
  </div>
</div>
<div class="form-group has-feedback">
  <div class="col-sm-12">
    <div class="row">
      <div class="col-sm-2">&nbsp;</div>
      <div class="col-sm-3">
        <p class="help-text text-right">Remark for In/out time</p>
      </div>
      <div class="col-sm-3">
        {{ Form::textarea('remark', $user->remark, array('rows' => '3', 'class' => 'form-control', 'placeholder' => 'Remark for In/out time')) }}
      </div>
    </div>
    @if ($errors->first('remark'))
      <div class="row">
        <div class="col-sm-6 col-sm-offset-2">
          <div class="alert alert-danger">
            {{{ $errors->first('remark') }}}
          </div>
        </div>
      </div>
    @endif
  </div>
</div>


<div class="form-group">
  <div class="col-sm-12">
    <div class="row">
      <div class="col-sm-2">
        {{ Form::label('phone', 'Phone *', array('class' => 'control-label')) }}
      </div>
      <div class="col-sm-6">
        {{ Form::text('phone', $user->phone, array('class' => 'form-control', 'placeholder' => 'Phone/Mobile Number')) }}
      </div>
    </div>
    @if ($errors->first('phone'))
      <div class="row">
        <div class="col-sm-6 col-sm-offset-2">
          <div class="alert alert-danger">
            {{{ $errors->first('phone') }}}
          </div>
        </div>
      </div>
    @endif
  </div>
</div>

<div class="form-group">
  <div class="col-sm-12">
    <div class="row">
      <div class="col-sm-2">
        {{ Form::label('altPhone', 'Alternate Phone', array('class' => 'control-label')) }}
      </div>
      <div class="col-sm-6">
        {{ Form::text('altPhone', $user->altPhone, array('class' => 'form-control', 'placeholder' => 'Alternate Phone/Mobile Number')) }}
      </div>
    </div>
    @if ($errors->first('altPhone'))
      <div class="row">
        <div class="col-sm-6 col-sm-offset-2">
          <div class="alert alert-danger">
            {{{ $errors->first('altPhone') }}}
          </div>
        </div>
      </div>
    @endif
  </div>
</div>