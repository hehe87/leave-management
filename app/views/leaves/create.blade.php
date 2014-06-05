@extends('layouts.user_layout')

@section('content')

<div class="row">
  <div class="col-sm-12">
    {{ Form::open(array('action' => 'LeavesController@store', 'method' => 'post', 'class' => 'form-horizontal')) }}
      <legend class="form-signin-heading">Add new holiday</legend>
      {{ Form::hidden('user_id', Auth::user()->id) }}
      <div class="form-group">
	<div class="col-sm-12">
	  <div class="row">
	    <div class="col-sm-2">
	      {{ Form::label('leave_type', 'Leave Type', array('class' => 'control-label')) }}
	    </div>
	    <div class="col-sm-6">
	      {{ Form::select('leave_type', array('LEAVE' => 'Leave', 'CSR' => 'CSR'), '', array('class' => 'form-control')) }}
	    </div>
	  </div>
	</div>
      </div>
      <div class="form-group has-feedback">
	<div class="col-sm-12">
	  <div class="row">
	    <div class="col-sm-2">
	      {{ Form::label('leave_date', 'Leave Date', array('class' => 'control-label')) }}							
	    </div>
	    <div class="col-sm-6">
	      {{ Form::text('leave_date', '', array('class' => 'form-control date_control')) }}
	      <span class="glyphicon glyphicon-calendar form-control-feedback"></span>
	    </div>
	  </div>
	</div>
      </div>
      <div id="csr-container">
	<div class="form-group">
	  <div class="col-sm-12">
	    <div class="row" id="timeContainer">
	      <div class="col-sm-2">
		{{ Form::label('from_time', 'Timings', array('class' => 'control-label')) }}
	      </div>
	      <div id="timeSlot" class="col-sm-6">
		<div class="row form-group">
		  <div class="slot_from">
		    {{ Form::label('from_hour', 'From', array('class' => 'control-label pull-left padding-right-5')) }}
		    <div class="input-group">
		      {{ Form::select('from_hour[]', range(0,23) ,'', array('class' => 'form-control input-xs pull-left')) }}
		      <span class="input-group-addon-new pull-left">H</span>
		      {{ Form::select('from_min[]', range(0,59,15) , '', array('class' => 'form-control input-xs')) }}
		      <span class="input-group-addon-new pull-left rounded-right">M</span>
		    </div>
		  </div>
		  <div class="slot_to">
		    {{ Form::label('to_hour', 'To', array('class' => 'control-label pull-left padding-right-5')) }}
		    <div class="input-group">
		      {{ Form::select('to_hour[]', range(0,23) , '', array('class' => 'form-control input-xs pull-left'))}}
		      <span class="input-group-addon-new pull-left">H</span>
		      {{ Form::select('to_min[]', range(0,59,15) , '', array('class' => 'form-control input-xs pull-left'))}}
		      <span class="input-group-addon-new pull-left rounded-right">M</span>
		    </div>
		  </div>
		</div>
	      </div>
	      <div class="col-sm-1">
		{{ Form::button('Add Slot', array('class' => 'btn btn-success pull-left', 'id' => 'addSlot')) }}
	      </div>
	    </div>
	  </div>
	</div>
      </div>
      <div class="form-group">
	<div class="col-sm-12">
	  <div class="row">
	    <div class="col-sm-2">
	      {{ Form::label('reason', 'Reason', array('class' => 'control-label')) }}
	    </div>
	    <div class="col-sm-6">
	      {{ Form::textarea('reason', '', array('class' => 'form-control', 'rows' => '4')) }}
	    </div>
	  </div>
	</div>
      </div>
      <div class="form-group">
	<div class="col-sm-12">
	  <div class="row">
	    <div class="col-sm-2">
	      {{ Form::label('approver_id', 'Approval', array('class' => 'control-label')) }}
	    </div>
	    <div class="col-sm-6">
	      {{ Form::select('approver_id[]', $users, '', array('class' => 'form-control', 'multiple')) }}
	    </div>
	  </div>
	</div>
      </div>
      <div class="form-group">
	<div class="col-sm-12">
	  <div class="row">
	    <div class="col-sm-6 col-sm-offset-3">
	      {{ Form::submit() }}
	    </div>
	  </div>
	</div>
      </div>
    {{ Form::close() }}
  </div>
</div>
@stop