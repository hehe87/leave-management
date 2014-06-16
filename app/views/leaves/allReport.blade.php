<thead>
  <tr>
    <th>
      User
    </th>
    <th width="20%">
      Date
    </th>
    <th width="15%">
      Leave Type
    </th>
  	<th>
    	Reason
  	</th>
    <th>
      Approved By
    </th>
  </tr>
</thead>
<tbody>
  @foreach($leaves as $leave)
    <tr>
      <td>
        {{ $leave->user->name }}
      </td>
      <td>
        @if($leave->leave_type == "LEAVE")
          {{ date('d-m-Y', strtotime($leave->leave_date)) }}
        @else
          @if($leave->leave_type == "LONG")
            {{ date('d-m-Y', strtotime($leave->leave_date)) }} - {{ date('d-m-Y', strtotime($leave->leave_to)) }}
             - {{ (Carbon::createFromFormat('Y-m-d',$leave->leave_date)->diffInDays(Carbon::createFromFormat('Y-m-d',$leave->leave_to))) + 1 }} day(s)
          @else 
            @if($leave->leave_type == "CSR")
              {{ date('d-m-Y', strtotime($leave->leave_date)) }}
              <table class="table table-bordered">
                @foreach($leave->csrs as $csr)
                  <tr>
                    <td>
                      {{ date('h:i A', strtotime($csr->from_time)) }}
                    </td>
                    <td>
                      {{ date('h:i A', strtotime($csr->to_time)) }}
                    </td>
                  </tr>
                @endforeach
              </table>
            @else
              {{ date('d-m-Y', strtotime($leave->leave_date)) }}
            @endif
          @endif
        @endif
      </td> 
      <td>
        {{ TemplateFunction::getFullLeaveTypeName($leave->leave_type) }}
      </td>
      <td>
        {{ $leave->reason }}
      </td>
      <td>
        <a class="btn btn-primary normal-button btn-xs view-approvals" data-url="{{ URL::route('approval.leaveApprovals', array('id' => $leave->id))}}" title="View Approvals"><span class="glyphicon glyphicon-eye-open"></span></a>
      </td>
    </tr>
  @endforeach
</tbody>