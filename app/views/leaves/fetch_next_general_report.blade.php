<?php $i = 1;?>
@while($i<=$lastDay)
	@if($i == 1)
		<tr>
			<td colspan="{{ (1 + count($allUsers)) }}" style="text-align: left;" class="g-report-month-header">
				<?php $dt = new DateTime(date("Y") . "-" . sprintf("%02s", $month) . "-1" ); ?>
				{{ $dt->format("M") }}
			</td>
		</tr>
	@endif
	<tr>
		<th>
			<?php $dt = new DateTime(date("Y") . "-" . sprintf("%02s", $month) . "-" . $i); ?>
			{{ $dt->format("d") }}
		</th>
		@foreach($allUsers as $user)
			<td>
				{{ $user->dayLeave($dt->format("Y-m-d")) }}
			</td>
		@endforeach
	</tr>
	<?php $i+=1; ?>
@endwhile