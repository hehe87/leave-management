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

			<a title="Approve Leave" class="btn btn-xs btn-primary approve-status-change" data-approve_status="YES" data-leave_id = "{{ $leave->id }}" data-approval_url="{{ URL::route('approval.updateStatus') }}">
    			<span class="glyphicon glyphicon-ok"></span>
  			</a>
  			&nbsp;&nbsp;
		  	<a title="Reject Leave" class="btn btn-xs btn-primary approve-status-change" data-approve_status="NO" data-leave_id = "{{ $leave->id }}" data-approval_url="{{ URL::route('approval.updateStatus') }}">
			    <span class="glyphicon glyphicon-remove"></span>
		  	</a>
	      </td>
	    </tr>
	  @endforeach
	  
	  @foreach ($extraLeaves as $leave)
	    <tr>
	      <td>
		{{ $leave->user->name }}
	      </td>
	      <td>
		{{ date('d-m-Y',strtotime($leave->from_date)) }} - {{ date('d-m-Y',strtotime($leave->to_date)) }}
	      </td>
	      <td>
		@if (preg_match("/Paternity/", $leave->description))
		  {{ $leave->description }}
		@else
		  Extra Leave
		@endif
	      </td>
	      <td>
		{{$leave->description}}
	      </td>
	      <td align="center">
		--
	      </td>
	    </tr>
	  @endforeach
	</tbody>
      </table>
    </div>
  </div>
@stop