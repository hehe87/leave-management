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
							{{ Form::select('leave_type', array('LEAVE' => 'Leave', 'CSR' => 'CSR'), '', array('class' => 'form-control')) }}
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
							{{ Form::text('leave_date', '', array('class' => 'form-control date_control')) }}
						</div>
					</div>
				</div>
			</div>
			<div id="csr-container">
				<div class="form-group">
					<div class="col-sm-12">
						<div class="row" id="timeContainer">
							<div class="col-sm-3">
								{{ Form::label('from_time', 'Timings', array('class' => 'control-label')) }}
							</div>
							<div id="timeSlot">
								<div class="col-sm-3">
									{{ Form::label('from_hour', 'From', array('class' => 'control-label col-sm-1')) }}
									{{ Form::select('from_hour[]', range(0,23) ,'', array('class' => 'form-control input-sm col-xs-2')) }}
									{{ Form::select('from_min[]', range(0,59) , '', array('class' => 'form-control input-sm col-xs-2')) }}
								</div>
								<div class="col-sm-3">
									{{ Form::label('to_hour', 'To', array('class' => 'control-label col-sm-1')) }}
									{{ Form::select('to_hour[]', range(0,23) , '', array('class' => 'form-control input-sm col-xs-2'))}}
									{{ Form::select('to_min[]', range(0,59) , '', array('class' => 'form-control input-sm col-xs-2'))}}
								</div>
							</div>
								{{ Form::button('Add Slot', array('class' => 'btn btn-success', 'id' => 'addSlot')) }}
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
							{{ Form::textarea('reason', '', array('class' => 'form-control', 'rows' => '4')) }}
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