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
				    <th>
				      Reason
				    </th>
				    <th>
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
								{{date('d-m-Y', strtotime($leaveReq->leave->leave_date))}}
				      </td>
				      <td>
								@if( "LEAVE" == $leaveReq->leave->leave_type )
						      Leave
						    @elseif( "CSR" == $leaveReq->leave->leave_type )
						      CSR -
						      <table class="table table-bordered">
						        @foreach($leaveReq->leave->csrs as $csr)
					            <tr>
					            	<td>
					            		{{ date('H:i A',strtotime($csr['from_time'])) }} to {{ date('H:i A', strtotime($csr['to_time'])) }}
				            		</td>
			            		</tr>
						        @endforeach
						      </table>
								    @elseif( "FH" == $leaveReq->leave->leave_type )
								      First Half
								    @elseif( "SH" == $leaveReq->leave->leave_type )
								      Second Half
								    @elseif( "LONG" == $leaveReq->leave->leave_type )
								      Long Leaves - {{ (Carbon::createFromFormat('Y-m-d',$leaveReq->leave->leave_date)->diffInDays(Carbon::createFromFormat('Y-m-d',$leaveReq->leave->leave_to))) + 1 }} day(s) 
								    @endif
							</td>
				      <td>
								{{$leaveReq->leave->reason}}
				      </td>
				      <td align="">
			          @if ($leaveReq->approved == "PENDING")
			            <a title="Approve Leave" class="btn btn-xs btn-primary approve-status-change" data-approve_status="YES" data-approval_id = "{{ $leaveReq->id }}" data-approval_url="{{ URL::route('approval.updateStatus') }}">
					    			<span class="glyphicon glyphicon-ok"></span>
					  			</a>
					  			&nbsp;&nbsp;
								  <a title="Reject Leave" class="btn btn-xs btn-primary approve-status-change" data-approve_status="NO" data-approval_id = "{{ $leaveReq->id }}" data-approval_url="{{ URL::route('approval.updateStatus') }}">
								    <span class="glyphicon glyphicon-remove"></span>
								  </a>
			          @else
			            @if ($leaveReq->approved == "YES")
			              <a href="javascript: void(0);" class="btn btn-xs btn-primary btn-success">
								      <span class="glyphicon glyphicon-ok" title="Leave Approved"></span>
								    </a>
			            @else
			              <a href="javascript: void(0);" class="btn btn-xs btn-primary btn-danger">
									    <span class="glyphicon glyphicon-remove btn-danger" title="Leave Rejected"></span>
									  </a>
			            @endif
			          @endif
			          &nbsp;&nbsp;
			          <a class="btn btn-primary normal-button btn-xs view-approvals" data-url="{{ URL::route('approval.leaveApprovals', array('id' => $leaveReq->leave->id))}}" title="View Approvals"><span class="glyphicon glyphicon-eye-open"></span></a>
				      </td>
				    </tr>
				  @endforeach
				</tbody>
			</table>
    </div>
  </div>
@stop