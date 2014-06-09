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
	    <th width="30%">
	      Reason
	    </th>
	    <th class="text-center">
	      Status
	    </th>
	  </tr>
	</thead>
	<tbody>
	  @foreach ($leaves as $leave)
	    <tr>
	      <td>
		{{$leave->user->name}}
	      </td>
	      <td>
		{{$leave->leave_date}}
	      </td>
	      <td>
		{{$leave->leave_type}}
	      </td>
	      <td align="center">
		@if ($leave->leave_type === "LEAVE")
		  --
		@else
		  {{$leave->from_time}}
		@endif
		
	      </td>
	      <td align="center">
		@if ($leave->leave_type === "LEAVE")
		  --
		@else
		  {{$leave->to_time}}
		@endif
	      </td>
	      <td>
		{{$leave->reason}}
	      </td>
	      <td align="center">
		<a class="btn btn-primary normal-button btn-xs view-approvals" data-url="{{ URL::route('approval.leaveApprovals', array('id' => $leave->id))}}" title="View Approvals"><span class="glyphicon glyphicon-eye-open"></span></a>
		<a class="btn btn-primary normal-button btn-xs" href="{{ URL::Route('leaves.edit', array($leave->id)) }}"><span class="glyphicon glyphicon-edit" title="Edit Leave"></span></a>
		<a class="btn btn-danger normal-button btn-xs delete-myleave" data-url="{{ URL::Route('leaves.destroy', array($leave->id)) }}"><span class="glyphicon glyphicon-remove" title="Delete Leave"></span></a>
	      </td>
	    </tr>
	  @endforeach
	</tbody>
      </table>
    </div>
  </div>
@stop