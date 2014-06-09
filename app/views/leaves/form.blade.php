{{ Form::hidden('user_id', Auth::user()->id) }}
{{ Input::old('leave.leave_type') }}
<div class="form-group">
  <div class="col-sm-12">
    <div class="row">
      <div class="col-sm-2">
        {{ Form::label('leave_type', 'Leave Type', array('class' => 'control-label')) }}
      </div>
      <div class="col-sm-6">
        {{ Form::select('leave[leave_type]', array('' => 'Select Leave Type', 'LEAVE' => 'Leave', 'CSR' => 'CSR'), $leave->leave_type, array('class' => 'form-control required', 'id'=> 'leave_type')) }}
      </div>
    </div>
    @if ($errors->first('leave_type'))
      <div class="row">
        <div class="col-sm-6 col-sm-offset-2">
          <div class="alert alert-danger">
            {{{ $errors->first('leave_type') }}}
          </div>
        </div>
      </div>
    @endif
  </div>
</div>
<div class="form-group has-feedback">
  <div class="col-sm-12">
    <div class="row">
      <div class="col-sm-2">
        {{ Form::label('leave_date', 'Leave Date', array('class' => 'control-label')) }}							
      </div>
      <div class="col-sm-6">
        {{ Form::text('leave[leave_date]', $leave->leave_date, array('class' => 'form-control date_control')) }}
        <span class="glyphicon glyphicon-calendar form-control-feedback"></span>
      </div>
    </div>
    @if ($errors->first('leave_date'))
      <div class="row">
        <div class="col-sm-6 col-sm-offset-2">
          <div class="alert alert-danger">
            {{{ $errors->first('leave_date') }}}
          </div>
        </div>
      </div>
    @endif
  </div>
</div>
@if ((Input::old('leave.leave_type') && Input::old('leave.leave_type') == "CSR") || ($leave->leave_type === "CSR"))
<div id="csr-container">
@else
<div id="csr-container" class="hide">
@endif
  <div class="form-group">
    <div class="col-sm-12">
      <div class="row" id="timeContainer">
        <div class="col-sm-2">
          {{ Form::label('from_time', 'Timings', array('class' => 'control-label')) }}
        </div>
        <div id="timeSlot" class="col-sm-6">
          @if(count(Input::old('csr')) != 0)
            @foreach (Input::old('csr') as $old_csr_key => $old_csr)
              @include("leaves.csrTimeInputs",array("csr_key" => $old_csr_key, "csr_inputs" => $old_csr))
            @endforeach
          @else
            @if (count($leave->csrs->toArray()) != 0)
              @foreach ($inputCSRs as $old_csr_key => $old_csr)
                @include("leaves.csrTimeInputs",array("csr_key" => $old_csr_key, "csr_inputs" => $old_csr))
              @endforeach
            @else
              @include("leaves.csrTimeInputs",array("csr_key" => 0, "csr_inputs" => array("from" => array("hour" => "0", "min" => "0"), "to" => array("hour" => "0", "min" => "0"))))
            @endif
          @endif
        </div>
        <div class="col-sm-1">
          {{ Form::button('Add Slot', array('class' => 'btn btn-success pull-left', 'id' => 'addSlot')) }}
        </div>
      </div>
    </div>
  </div>
</div>
<div class="form-group">
  <div class="col-sm-12">
    <div class="row">
      <div class="col-sm-2">
        {{ Form::label('reason', 'Reason', array('class' => 'control-label')) }}
      </div>
      <div class="col-sm-6">
        {{ Form::textarea('leave[reason]', $leave->reason, array('class' => 'form-control', 'rows' => '4')) }}
      </div>
    </div>
    @if ($errors->first('reason'))
      <div class="row">
        <div class="col-sm-6 col-sm-offset-2">
          <div class="alert alert-danger">
            {{{ $errors->first('reason') }}}
          </div>
        </div>
      </div>
    @endif
  </div>
</div>
<div class="form-group">
  <div class="col-sm-12">
    <div class="row">
      <div class="col-sm-2">
        {{ Form::label('approver_id', 'Approval', array('class' => 'control-label')) }}
      </div>
      <div class="col-sm-6">
        {{ Form::select('approval[][approver_id]', $users, array_values(array_map(function($approver){return $approver['approver_id']; },$leave->approvals->toArray())), array('class' => 'form-control multiple-select-with-checkbox', 'multiple')) }}
      </div>
    </div>
    @if ($errors->first('approval'))
      <div class="row">
        <div class="col-sm-6 col-sm-offset-2">
          <div class="alert alert-danger">
            {{{ $errors->first('approval') }}}
          </div>
        </div>
      </div>
    @endif
  </div>
</div>