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
          {{ $leave->leave_date }}
        @else
          @if($leave->leave_type == "LONG")
            {{ $leave->leave_date }} - {{ $leave->leave_to }}
          @else
            @if($leave->leave_type == "CSR")
              {{ $leave->leave_date }}
              <table class="table table-bordered">
                @foreach($leave->csrs as $csr)
                  <tr>
                    <td>
                      {{ $csr->from_time }}
                    </td>
                    <td>
                      {{ $csr->to_time }}
                    </td>
                  </tr>
                @endforeach
              </table>
            @else
              {{ $leave->leave_date }}
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