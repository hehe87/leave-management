<div class="row form-group has-feedback">
  <div class="slot_from col-sm-6">
    {{ Form::text("csr[$csr_key][from_time]", $csr_inputs["from_time"], array('class' => 'form-control timepicker time start')) }}
    <span class="glyphicon glyphicon-time form-control-feedback"></span>
  </div>
  <div class="slot_to col-sm-6">
    {{ Form::text("csr[$csr_key][to_time]", $csr_inputs["to_time"], array('class' => 'form-control timepicker time end')) }}
    <span class="glyphicon glyphicon-time form-control-feedback"></span>
  </div>
</div>
      