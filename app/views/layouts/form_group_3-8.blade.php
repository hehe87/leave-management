<div class="form-group">
  <div class="col-sm-12">
    <div class="row">
      <div class="col-sm-3">
        {{ Form::label($label["name"], $label["text"], array('class' => 'control-label')) }}
      </div>
      <div class="col-sm-8">
        {{ Form::text($input["name"], $input["value"] , array('class' => 'form-control', 'placeholder' => $input["placeholder"])) }}
      </div>
    </div>
    @if ($errors->first($err["name"]))
      <div class="row">
        <div class="col-sm-8 col-sm-offset-3">
          <div class="alert alert-danger">
            {{{ $errors->first($err["name"]) }}}
          </div>
        </div>
      </div>
    @endif
  </div>
</div>