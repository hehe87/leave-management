@extends('layouts.admin_layout')

@section('content')
	<div class="row">
    <div class="col-lg-12 general-report-container">
    	<div class="general-report-container-inner" style="width: {{ (30 * (count($all_users) + 1)) . 'px;' }}">
	    	<table class="table table-bordered">
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
	    			<?php 
	    				$months = array(); 
	    				$curr_month = (int)date("m");
	    				for($i=$curr_month;$i>=1;$i--){
	    					$months[] = $i;
	    				}
	    			?>
						@foreach($months as $month)
							<?php $firstDay = 1; ?>
							<?php $firstDate = new DateTime( date("Y") . '-01-01' ); ?>
							<?php $lastDay = (int)$firstDate->format("t"); ?>
							<?php $i = 1;?>
							@while($i<=$lastDay)
								<tr>
									<th>
										<?php $dt = new DateTime(date("Y") . "-" . sprintf("%02s", $month) . "-" . $i); ?>
										{{ $dt->format("d-M") }}
									</th>
									@foreach($all_users as $user)
										<td>
											{{ $user->dayLeave($dt->format("Y-m-d")) }}
										</td>
									@endforeach
								</tr>
								<?php $i+=1; ?>
							@endwhile
						@endforeach
	    		</tbody>
	    	</table>
    	</div>
    </div>
  </div>
@stop