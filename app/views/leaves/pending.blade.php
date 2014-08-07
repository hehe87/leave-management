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
			{{ $leave->leave->user->name }}
		  </td>
		  <td>
			{{$leave->leave->leave_date}}
		  </td>
		  <td>
			{{$leave->leave->leave_type}}
		  </td>
		  <td>
			{{$leave->leave->from_time}}
		  </td>
		  <td>
			{{$leave->leave->to_time}}
		  </td>
		  <td>
			{{$leave->leave->reason}}
		  </td>
		  <td>
			{{ Form::open(array('method' => 'POST')) }}
				{{ Form::hidden('id', $leave->id) }}
				{{ Form::select('approved', array('YES' => 'Yes', 'NO' => 'No', 'PENDING' => 'Pending'), $leave->approved, array('class' => 'approved')) }}
			{{ Form::close() }}
		  </td>
		</tr>
	  @endforeach
	</tbody>
  </table>
@stop