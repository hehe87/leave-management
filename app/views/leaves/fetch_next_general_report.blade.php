<?php $i = 1;?>
@while($i<=$lastDay)
	<tr>
		<th>
			<?php $dt = new DateTime(date("Y") . "-" . sprintf("%02s", $month) . "-" . $i); ?>
			{{ $dt->format("d-M") }}
		</th>
		@foreach($allUsers as $user)
			<td>
				{{ $user->dayLeave($dt->format("Y-m-d")) }}
			</td>
		@endforeach
	</tr>
	<?php $i+=1; ?>
@endwhile