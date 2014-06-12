@extends('layouts.admin_layout')

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
	    <th>
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
		{{ $leave->user->name }}
	      </td>
	      <td>
		{{ date('d-m-Y',strtotime($leave->leave_date)) }}
	      </td>
	      <td>
		@if( "LEAVE" == $leave->leave_type )
		  Leave
		@elseif( "CSR" == $leave->leave_type )
		  CSR
		@elseif( "FH" == $leave->leave_type )
		  First Half
		@elseif( "SH" == $leave->leave_type )
		  Second Half
		@elseif( "LONG" == $leave->leave_type )
		  Long Leaves
		@elseif( "MULTI" == $leave->leave_type )
		  Multi Leaves
		@endif
	      </td>
	      <td>
		{{$leave->reason}}
	      </td>
	      <td align="center">
		<a class="btn btn-primary normal-button btn-xs view-approvals" data-url="{{ URL::route('approval.leaveApprovals', array('id' => $leave->id))}}" title="View Approvals"><span class="glyphicon glyphicon-eye-open"></span></a>
	      </td>
	    </tr>
	  @endforeach
	</tbody>
      </table>
    </div>
  </div>
@stop