<thead>
  <tr>
   <th>
      User
    </th>
    <th style="vertical-align: middle; text-align: center;">
      Date
    </th>

  	<th style="width: 10.5%;">
    	From Time
  	</th>
  	<th>
    	To Time
	</th>
  	<th>
    	Reason
  	</th>

    <th>
      Approved By
    </th>
  </tr>
</thead>

  @foreach($leaves as $leave)
    <tbody>
      <tr>
       <td>
        {{ $leave->user->name }}
      </td>
  		<td style="border: 1px solid #ddd vertical-align: middle; text-align: center;">{{ date("d-m-Y",strtotime($leave->leave_date)) }}</td>
	    <td colspan="2">
	        <table class="table table-bordered margin-bottom-0">
	          @foreach($leave->csrs as $csr)
	            <tr>
	              <td>
	                {{ date("H:i A", strtotime($csr->from_time)) }}
	              </td>
	              <td>
	                {{ date("H:i A", strtotime($csr->to_time)) }}
	              </td>
	            </tr>
	          @endforeach
	        </table>
	    </td>
	    <td>
	    	{{ $leave->reason }}
	    </td>
	    <td align="center" style="vertical-align: middle;">
	        <a class="btn btn-primary normal-button btn-xs view-approvals" data-url="{{ URL::route('approval.leaveApprovals', array('id' => $leave->id))}}" title="View Approvals"><span class="glyphicon glyphicon-eye-open"></span></a>
          <a class="btn btn-danger normal-button btn-xs delete-myleave" data-url="{{ URL::Route('leaves.destroy', array($leave->id)) }}"><span class="glyphicon glyphicon-remove" title="Delete Leave"></span></a>
	    </td>
      </tr>
    </tbody>
  @endforeach
</table>