<div class="row form-group">
  <div class="slot_from">
    {{ Form::label('from_hour', 'From', array('class' => 'control-label pull-left padding-right-5')) }}
    <div class="input-group">
      {{ Form::select("csr[$csr_key][from][hour]", range(0,23) ,$csr_inputs["from"]["hour"], array('class' => 'form-control input-xs pull-left')) }}
      <span class="input-group-addon-new pull-left">H</span>
      {{ Form::select("csr[$csr_key][from][min]", array(0=>0,15=>15,30=>30,45=>45), $csr_inputs["from"]["min"], array('class' => 'form-control input-xs')) }}
      <span class="input-group-addon-new pull-left rounded-right">M</span>
    </div>
  </div>
  <div class="slot_to">
    {{ Form::label('to_hour', 'To', array('class' => 'control-label pull-left padding-right-5')) }}
    <div class="input-group">
      {{ Form::select("csr[$csr_key][to][hour]", range(0,23) , $csr_inputs["to"]["hour"], array('class' => 'form-control input-xs pull-left'))}}
      <span class="input-group-addon-new pull-left">H</span>
      {{ Form::select("csr[$csr_key][to][min]", array(0=>0,15=>15,30=>30,45=>45) , $csr_inputs["to"]["min"], array('class' => 'form-control input-xs pull-left'))}}
      <span class="input-group-addon-new pull-left rounded-right">M</span>
    </div>
  </div>
</div>
      