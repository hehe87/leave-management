@extends('layouts.admin_layout')

@section('content')
		
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
		  From Time
		</th>
		<th>
		  To Time
		</th>
		<th>
		  Reason
		</th>
		<th>
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
		  <td>
			{{$leave->from_time}}
		  </td>
		  <td>
			{{$leave->to_time}}
		  </td>
		  <td>
			{{$leave->reason}}
		  </td>
		  <td>
			-
		  </td>
		</tr>
	  @endforeach
	</tbody>
  </table>
@stop