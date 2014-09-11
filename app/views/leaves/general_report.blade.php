@extends('layouts.admin_layout')
@section("page_script")
	<script type="text/javascript">
		var general_report = true;
		var general_report_url = "{{ URL::route('leaves.post_general_report') }}";
	</script>
@stop
@section('content')
	<div class="row">
    <div class="col-lg-12 pull-left" style="color: #000;">
      <div class="form-group">
        <h3>Leave Report {{ date("Y") }}</h3>
      </div>
    </div>
  </div>
	<div class="row">
    <div class="col-lg-12 general-report-container">
    	<div class="general-report-container-inner" style="width: {{ (30 * (count($all_users) + 1)) . 'px;' }}">
	    	<table style="width:100%;" class="table table-bordered" data-month={{date("m")}} data-year={{date("Y") }}>
	    		<thead>
	    			<tr>
	    				<th width="100px">&nbsp;</th>
							@foreach($all_users as $user)
								<th style="width : 150px">
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
									{{ date("M d",strtotime($user->doj)) }}
									{{ date("Y",strtotime($user->doj)) }}
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

						@foreach($extra_leave_names as $key => $ex_leave_name)
							@if($key == (count($extra_leave_names) - 1))
								<tr style="border-bottom: 3px solid #aeaeae;">
							@else
								<tr>
							@endif
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
	    				<th style="background-color: #FF9900">
	    					Leaves Allready Taken
	    				</th>
	    				@foreach($all_users as $user)
								<td style="background-color: #FF9900">
									{{ $user->getTotalLeaves() - $user->getRemainingLeaves(date("Y")); }}
								</td>
							@endforeach
	    			</tr>

	    			<tr>
	    				<th>
	    					Leaves Left
	    				</th>
	    				@foreach($all_users as $user)
	    					<?php $rm_leave_count = $user->getRemainingLeaves(date("Y")); ?>
								<td class="{{ $rm_leave_count < 0 ? 'red' : '' }}">
									{{ $rm_leave_count }}
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