{{ Form::hidden('user_id', Auth::user()->id) }}

  @if ($layout == "admin_layout")
    <div class="form-group">
      <div class="col-lg-12">
        <div class="row">
          <div class="col-lg-2">
            <label class="control-label">Employee Name *</label>
          </div>
          <div class="col-lg-6">
            {{ Form::select("employee_id", $users, Input::get("employee_id") ,array("class" => "multiselect form-control", "placeholder" => "Search Employee")) }}
          </div>
        </div>
        @if ($errors->first('employee_id'))
          <div class="row">
            <div class="col-sm-6 col-sm-offset-2">
              <div class="alert alert-danger">
                {{{ $errors->first('employee_id') }}}
              </div>
            </div>
          </div>
        @endif
      </div>
    </div>
  @endif

  
  <div class="form-group">
    <div class="col-sm-12">
      <div class="row">
        <div class="col-sm-2">
          {{ Form::label('leave_option', 'Leave Option', array('class' => 'control-label')) }}
        </div>
        <div class="col-sm-6">
          @if(isset($leave) && isset($leave->id))
            {{ Form::text('leave_option', (($leave->leave_type == "CSR") ? 'CSR' : 'Leave'),array("class" => "form-control", "readonly" => true)) }}
          @else
            {{ Form::select('leave_option', array('' => 'Select Leave Option', 'LEAVE' => 'Leave', 'CSR' => 'CSR'), ($leave->leave_type == "CSR" ? "CSR" : ($leave->leave_type == "" ? "" : "LEAVE"))  ,array('id'=> 'leave_option', 'class' => 'form-control')) }}
          @endif
        </div>
      </div>
      @if ($errors->first('leave_option'))
        <div class="row">
          <div class="col-sm-6 col-sm-offset-2">
            <div class="alert alert-danger">
              {{{ $errors->first('leave_option') }}}
            </div>
          </div>
        </div>
      @endif
    </div>
  </div>





<div class="form-group {{ (Input::old('leave_option') == 'LEAVE') || ($leave->leave_type != 'CSR' && $leave->leave_type != '') ? '' : 'hide' }}" id="leave-type-form-group">
  <div class="col-sm-12">
    <div class="row">
      <div class="col-sm-2">
        {{ Form::label('leave_type', 'Leave Type *', array('class' => 'control-label')) }}
      </div>
      <div class="col-sm-6">
        @if(isset($leave) && isset($leave->id))
          {{ Form::text('ltype', TemplateFunction::getFullLeaveTypeName($leave->leave_type), array("class" => "form-control", "readonly" => true)) }}
          {{ Form::hidden('leave[leave_type]', $leave->leave_type, array("class" => "form-control")) }}
        @else
          {{ Form::select('leave[leave_type]', array('' => 'Select Leave Type', 'LEAVE' => 'Full Day Leave', 'FH' => 'First Half', 'SH' => 'Second Half', 'LONG' => 'Long Leave', 'MULTI' => 'Multiple Leaves'), $leave->leave_type, array('class' => 'form-control required', 'id' => 'leave_type')) }}
        @endif
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
        {{ Form::label('leave_date', 'Leave Date *', array('class' => 'control-label')) }}
      </div>
      <div class="col-sm-6" id="leaveDateFrom">
        {{ Form::text('leave[leave_date]',$leave->leave_date, array('class' => 'form-control date_control ' . TemplateFunction::getUIDateClass(Input::old('leave_option'), Input::old('leave.leave_type')), 'id' => 'date-control')) }}
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
@if ((Input::old('leave.leave_option') && Input::old('leave.leave_option') == "CSR") || ($leave->leave_type === "CSR"))
<div id="csr-container">
@else
<div id="csr-container" class="hide">
@endif
  <div class="form-group">
    <div class="col-sm-12">
      <div class="row" id="timeContainer">
        <div class="col-sm-2">
          {{ Form::label('from_time', 'Timings *', array('class' => 'control-label')) }}
        </div>
        <div id="timeSlot" class="col-sm-6">

          @if(count(Input::old('csr')) != 0)
            @foreach (Input::old('csr') as $old_csr_key => $old_csr)
              @include("leaves.csrTimeInputs",array("csr_key" => $old_csr_key, "csr_inputs" => $old_csr))
            @endforeach
          @else
            @if (isset($inputCSRs))
              @foreach ($inputCSRs as $old_csr_key => $old_csr)
                @include("leaves.csrTimeInputs",array("csr_key" => $old_csr_key, "csr_inputs" => $old_csr))
              @endforeach
            @else
              @include("leaves.csrTimeInputs",array("csr_key" => 0, "csr_inputs" => array("from_time" => "", "to_time" => "")))
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
        {{ Form::label('reason', 'Reason *', array('class' => 'control-label')) }}
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
@if ($layout != "admin_layout")
  <div class="form-group">
    <div class="col-sm-12">
      <div class="row">
        <div class="col-sm-2">
          {{ Form::label('approver_id', 'Approval *', array('class' => 'control-label')) }}
        </div>
        <div class="col-sm-6">
          {{ Form::select('approval[][approver_id]', $users, array_map(function($approver){return $approver['approver_id']; },(is_array(Input::old('approval')) ? Input::old('approval') : $leave->approvals->toArray())), array('class' => 'form-control multiselect', 'multiple')) }}

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
@else
  {{ Form::hidden('approval[][approver_id]',Auth::user()->id)}}
@endif