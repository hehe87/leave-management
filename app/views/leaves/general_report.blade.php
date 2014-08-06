@extends('layouts.admin_layout')
@section("page_script")
	<script type="text/javascript">
		var general_report = true;
		var general_report_url = "{{ URL::route('leaves.post_general_report') }}";
	</script>
@stop
@section('content')
	<div class="row">
    <div class="col-lg-12 general-report-container">
    	<div class="general-report-container-inner" style="width: {{ (30 * (count($all_users) + 1)) . 'px;' }}">
	    	<table class="table table-bordered" data-month={{date("m")}} data-year={{date("Y") }}>
	    		<thead>
	    			<tr>
	    				<th width="100px">&nbsp;</th>
							@foreach($all_users as $user)
								<th width="100px">
									{{ $user->name; }}
								</th>
							@endforeach
	    			</tr>
	    		</thead>
	    		<tbody>
	    			<tr>
	    				<th>
	    					Date Employed
	    				</th>
	    				@foreach($all_users as $user)
								<td>
									{{ date("d-m-Y",strtotime($user->doj)) }}
								</td>
							@endforeach
	    			</tr>

	    			<tr>
	    				<th>
	    					Normal Leaves
	    				</th>
	    				@foreach($all_users as $user)
								<td>
									{{ $user->getNormalLeavesForYear(date("Y")); }}
								</td>
							@endforeach
	    			</tr>

						@foreach($extra_leave_names as $ex_leave_name)
							<tr>
		    				<th>
		    					{{ ucfirst($ex_leave_name) }}
		    				</th>
		    				@foreach($all_users as $user)
									<td>
										{{ $user->getExtraLeave(date("Y"), $ex_leave_name) }}
									</td>
								@endforeach
		    			</tr>
						@endforeach

						<tr>
	    				<th>	
	    					Leaves Allowed
	    				</th>
	    				@foreach($all_users as $user)
								<td>
									{{ $user->getTotalLeaves(); }}
								</td>
							@endforeach
	    			</tr>

	    			<tr>
	    				<th>
	    					Leaves Allready Taken
	    				</th>
	    				@foreach($all_users as $user)
								<td>
									{{ $user->getTotalLeaves() - $user->getRemainingLeaves(date("Y")); }}
								</td>
							@endforeach
	    			</tr>

	    			<tr>
	    				<th>
	    					Remaining Leaves
	    				</th>
	    				@foreach($all_users as $user)
								<td>
									{{ $user->getRemainingLeaves(date("Y")); }}
								</td>
							@endforeach
	    			</tr>
	    			<!-- enter months code here -->
	    		</tbody>
	    	</table>
    	</div>
    </div>
  </div>
@stop