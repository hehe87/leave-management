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
								{{date('d-m-Y', strtotime($leave->leave_date))}}
							    @if("LONG" == $leave->leave_type)
							      to {{ date('d-m-Y', strtotime($leave->leave_to)) }}
							      {{ Carbon::createFromFormat('Y-m-d',$leave->leave_date)->diffInDays(Carbon::createFromFormat('Y-m-d',$leave->leave_to)) + 1 }} day(s)
							    @endif
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
							<td align="left">
								<a data-toggle="tooltip" class="btn btn-primary normal-button btn-xs view-approvals" data-url="{{ URL::route('approval.leaveApprovals', array('id' => $leave->id))}}" title="View Approvals"><span class="glyphicon glyphicon-eye-open"></span></a>
								@if (!$leave->approvalStatus(Leave::APPROVED_BY_SOME) && !$leave->approvalStatus(Leave::REJECTED_BY_SOME))
									<a data-toggle="tooltip" class="btn btn-primary normal-button btn-xs" href="{{ URL::Route('leaves.edit', array($leave->id)) }}"" title="Edit Leave"><span class="glyphicon glyphicon-edit"></span></a>
									<a data-toggle="tooltip" class="btn btn-danger normal-button btn-xs delete-myleave" data-url="{{ URL::Route('leaves.destroy', array($leave->id)) }}"  title="Delete Leave"><span class="glyphicon glyphicon-remove"></span></a>
								@endif
							</td>
				    	</tr>
				  	@endforeach
				</tbody>
	      	</table>
	    </div>
  	</div>
@stop