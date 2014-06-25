@extends('layouts.user_layout')

@section('content')
	<div class="row margin-top-10">
		<div class="col-sm-12">
			<div class="row form-group">
				<div class="col-sm-3 col-sm-offset-3">
					<div class="box rounded headed">
						<label class="control-label">Total Leaves</label>
						<div>{{ $total_leaves }}</div>
					</div>
					
				</div>
				<div class="col-sm-3">
					<div class="box rounded headed">
						<label class="control-label">Approved Leaves</label>
						<div>{{ $approved_leaves }}</div>
					</div>
				</div>
			</div>
			<div class="row form-group">
				<div class="col-sm-3 col-sm-offset-1">
					<div class="box rounded headed">
						<label class="control-label">Pending Leaves</label>
						<div>{{ $pending_leaves }}</div>
					</div>
				</div>
				<div class="col-sm-3 col-sm-offset-4">
					<div class="box rounded headed">
						<label class="control-label">Extra Leaves</label>
						<div>{{ $extra_leaves }}</div>
					</div>
				</div>
			</div>
			<div class="row form-group">
				<div class="col-sm-3 col-sm-offset-3">
					<div class="box rounded headed">
						<label class="control-label">Applied Leaves</label>
						<div>{{ $applied_leaves }}</div>
					</div>
				</div>
				<div class="col-sm-3">
					<div class="box rounded headed">
						<label class="control-label">Available Leaves</label>
						<div>{{ $total_leaves - $approved_leaves }}</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@stop