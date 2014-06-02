@extends('layouts.login_layout')

@section('content')
<div class="row">
	<div class="col-sm-8 col-sm-offset-2 well">
		<h2>Leave Application Form</h2>
		@if($errors->has())
			<ul>
		    @foreach ($errors->all() as $error)
			   <li><div class="alert alert-danger">{{ $error }}</div></li>
			@endforeach
			</ul>
		@endif
		
		{{ Form::open(array('action' => 'LeavesController@store', 'method' => 'post')) }}
			{{ Form::hidden('user_id', Auth::user()->id) }}
			<div class="form-group">
				<div class="col-sm-12">
					<div class="row">
						<div class="col-sm-3">
							{{ Form::label('leave_type', 'Leave Type', array('class' => 'control-label')) }}
						</div>
						<div class="col-sm-6">
							{{ Form::select('leave_type', array('LEAVE' => 'Leave', 'CSR' => 'CSR')) }}
						</div>
					</div>
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-12">
					<div class="row">
						<div class="col-sm-3">
							{{ Form::label('leave_date', 'Leave Date', array('class' => 'control-label')) }}
						</div>
						<div class="col-sm-6">
							{{ Form::text('leave_date') }}
						</div>
					</div>
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-12">
					<div class="row">
						<div class="col-sm-3">
							{{ Form::label('from_time', 'From Time', array('class' => 'control-label')) }}
						</div>
						<div class="col-sm-6">
							{{ Form::text('from_time') }}
						</div>
					</div>
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-12">
					<div class="row">
						<div class="col-sm-3">
							{{ Form::label('to_time', 'To Time', array('class' => 'control-label')) }}
						</div>
						<div class="col-sm-6">
							{{ Form::text('to_time') }}
						</div>
					</div>
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-12">
					<div class="row">
						<div class="col-sm-3">
							{{ Form::label('reason', 'Reason', array('class' => 'control-label')) }}
						</div>
						<div class="col-sm-6">
							{{ Form::text('reason') }}
						</div>
					</div>
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-12">
					<div class="row">
						<div class="col-sm-3">
							{{ Form::label('approver_id', 'Approval', array('class' => 'control-label')) }}
						</div>
						<div class="col-sm-6">
							{{ Form::select('approver_id', $users) }}
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