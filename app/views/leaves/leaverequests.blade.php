@extends('layouts.user_layout')

@section('content')
  <div class="row">
    <div class="col-lg-12">
      <table class="table table-striped table-hover table-condensed" id="leavesTable">
	<thead>
	  <tr>
	    <th>
	      Name
	    </th>
	    <th>
	      Leave Date
	    </th>
	    <th>
	      Leave Type
	    </th>
	    <th class="text-center">
	      From Time
	    </th>
	    <th class="text-center">
	      To Time
	    </th>
	    <th>
	      Reason
	    </th>
	    <th class="text-center">
	      Approve
	    </th>
	  </tr>
	</thead>
	<tbody>
	  @foreach ($leaveRequests as $leaveReq)
	    <tr>
	      <td>
		{{$leaveReq->leave->user->name}}
	      </td>
	      <td>
		{{$leaveReq->leave->leave_date}}
	      </td>
	      <td>
		{{$leaveReq->leave->leave_type}}
	      </td>
	      <td align="center">
		@if ($leaveReq->leave->leave_type === "LEAVE")
		  --
		@else
		  {{$leaveReq->leave->from_time}}
		@endif
		
	      </td>
	      <td align="center">
		@if ($leaveReq->leave->leave_type === "LEAVE")
		  --
		@else
		  {{$leaveReq->leave->to_time}}
		@endif
	      </td>
	      <td>
		{{$leaveReq->leave->reason}}
	      </td>
	      <td align="center">
                @if ($leaveReq->approved == 0)
                  <a class="btn btn-xs btn-primary"><span class="glyphicon glyphicon-ok"></span></a>&nbsp;&nbsp;<a class="btn btn-xs btn-primary"><span class="glyphicon glyphicon-remove"></span></a>
                @else
                  @if ($leaveReq->approved == 1)
                    <span class="glyphicon glyphicon-remove btn-success">
                  @else
                    <span class="glyphicon glyphicon-remove btn-danger">
                  @endif
                @endif
	      </td>
	    </tr>
	  @endforeach
	</tbody>
      </table>
    </div>
  </div>
@stop