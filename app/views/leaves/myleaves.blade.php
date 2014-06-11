@extends('layouts.user_layout')

@section('content')
  <div class="row">
    <div class="col-lg-12">
      <table class="table table-striped table-hover table-condensed" id="leavesTable">
	<thead>
	  <tr>
	    <th>
	      Leave Date
	    </th>
	    <th>
	      Leave Type
	    </th>
	    <th width="50%">
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
		{{$leave->leave_date}}
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