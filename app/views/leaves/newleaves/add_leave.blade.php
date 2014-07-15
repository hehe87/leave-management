@extends("layouts.user_layout")

@section("content")
	<div class="row">
	  <div class="col-sm-12">
	    {{ Form::open(array('url' => URL::route('leaves.postAddLeave'), 'method' => 'post', 'class' => 'form-horizontal', 'id' => 'leaves_create_form')) }}
	      <legend class="form-signin-heading">Apply for Leave(New)</legend>
	      <div class="form-group">
		      <div class="col-sm-12">
			      <div class="row">
			        <div class="col-sm-6">
			        	{{ Form::label('leave[leave_date]', 'From Date', array('class' => 'control-label')) }}
								{{ Form::text('leave[leave_date]',(new DateTime())->format('d-m-Y'), array('class' => 'form-control datepicker from_dt')) }}
			        </div>
			        <div class="col-sm-6">
			        	{{ Form::label('leave[to_date]', 'To Date', array('class' => 'control-label')) }}
								{{ Form::text('leave[to_date]',(new DateTime())->format('d-m-Y'), array('class' => 'form-control datepicker to_dt')) }}
			        </div>
		        </div>
	        </div>
        </div>

        <div class="form-group in-out-time-container">
		      <div class="col-sm-12">
			      <div class="row">
			        <div class="col-sm-6">
			        	{{ Form::label('leave[in_time]', 'In Time', array('class' => 'control-label')) }}
								{{ Form::text('leave[in_time]',(new DateTime(Auth::user()->inTime))->format("g:i A"), array('class' => 'form-control timepicker in_time', 'id' => 'in-time')) }}
			        </div>
			        <div class="col-sm-6">
			        	{{ Form::label('leave[out_time]', 'Out Time', array('class' => 'control-label')) }}
								{{ Form::text('leave[out_time]',(new DateTime(Auth::user()->outTime))->format("g:i A"), array('class' => 'form-control timepicker out_time', 'id' => 'out-time')) }}
			        </div>
		        </div>
	        </div>
        </div>

        <div class="form-group availablity-time-slot-container">
		      <div class="col-sm-12">
		      	{{ Form::label('', 'Select time for which you will be available in office', array('class' => 'control-label')) }}

		      	{{ Form::hidden('leave[lunch_break_start_time]', "1:30 PM", array("id" => "input-lunch-break-start-time", "value" => "")) }}
		      	{{ Form::hidden('leave[lunch_break_end_time]', "2:30 PM", array("id" => "input-lunch-break-end-time", "value" => "")) }}



		      	{{ Form::hidden('leave[break_start_time_1]', "11:30 AM", array("id" => "input-break-start-time-1", "value" => "")) }}
		      	{{ Form::hidden('leave[break_end_time_1]', "11.45 AM", array("id" => "input-break-end-time-1", "value" => "")) }}

		      	{{ Form::hidden('leave[break_start_time_2]', "4:30 PM", array("id" => "input-break-start-time-2", "value" => "")) }}
		      	{{ Form::hidden('leave[break_end_time_2]', "4:45 PM", array("id" => "input-break-end-time-2", "value" => "")) }}
		





		      	{{ Form::hidden('leave[available_in_time]', "09:30 AM", array("id" => "input-from-time")) }}
		      	{{ Form::hidden('leave[available_out_time]', "09:30 AM", array("id" => "input-to-time")) }}
		      	<div class="row">
		      		<div class="col-sm-2 text-right">
		      			<span id="from-time" style="margin-right: 20px;">{{Auth::user()->inTime}}</span>
		      		</div>
		      		<div class="col-sm-8">
		      			<div class="row">
	      				 	<div class="slider col-sm-12">
	      				 	</div>
		      			</div>
		      			<div class="row">
		      				<div class="col-sm-12 in-between-hours slot_95">
		      				</div>
		      			</div>
		      		</div>
		      		<div class="col-sm-2">
		      			<span  id="to-time" style="margin-left: 20px;">{{Auth::user()->outTime}}</span>
		      		</div>
		      	</div>
		      </div>
			  </div>   
			  <div class="form-group">
	        <div class="col-sm-12">
	          <div class="row">
	            <div class="col-sm-10 col-sm-offset-2">
	              {{ Form::button("Apply", array("class" => "btn btn-primary normal-button pull-right", "id" => "leave_apply")) }}
	            </div>
	          </div>
	        </div>
	      </div> 
	    {{ Form::close() }}
	  </div>
  </div>
@stop