
<div class="form-group has-feedback">
  <div class="col-sm-12">
    <div class="row">
      <div class="col-sm-2">
        {{ Form::label('holidayDate', 'Date', array('class' => 'control-label')) }}
      </div>
      <div class="col-sm-6">
        {{ Form::text('holidayDate', $holiday->holidayDate, array('class' => 'form-control date_control', 'placeholder' => 'Holiday Date')) }}
        <span class="glyphicon glyphicon-calendar form-control-feedback"></span>
      </div>
    </div>
    @if ($errors->first('holidayDate'))
      <div class="row">
        <div class="col-sm-6 col-sm-offset-2">
          <div class="alert alert-danger">
            {{{ $errors->first('holidayDate') }}}
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
        {{ Form::label('holidayDescription', 'Description', array('class' => 'control-label')) }}
      </div>
      <div class="col-sm-6">
        {{ Form::textarea('holidayDescription', $holiday->holidayDescription, array('class' => 'form-control', 'placeholder' => 'Holiday Description')) }}
        <!--<input type="" name="name" placeholder="Full Name" class="form-control" id=""/>-->
      </div>
    </div>
    @if ($errors->first('holidayDescription'))
      <div class="row">
        <div class="col-sm-6 col-sm-offset-2">
          <div class="alert alert-danger">
            {{{ $errors->first('holidayDescription') }}}
          </div>
        </div>
      </div>
    @endif
  </div>  
</div>
  