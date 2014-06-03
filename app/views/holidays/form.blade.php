@extends('layouts.admin_layout')

@section('content')
  <div class="row">
    <div class="col-sm-12">
      {{ Form::open(array('url' => '/holidays/store', 'method' => 'post', 'role' => 'form', 'class' => 'form-horizontal')) }}
        <legend class="form-signin-heading">Add new holiday</legend>
        <div class="form-group">
          <div class="col-sm-12">
            <div class="row">
              <div class="col-sm-2">
                {{ Form::label('holidayDate', 'Date', array('class' => 'control-label')) }}
              </div>
              <div class="col-sm-6">
                {{ Form::text('holidayDate', $holiday->holidayDate, array('class' => 'form-control date', 'placeholder' => 'Holiday Date')) }}
                <!--<input type="" name="name" placeholder="Full Name" class="form-control" id=""/>-->
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
                {{ Form::textarea('holidayDescription', $holiday->holidayDescription, array('class' => 'form-control', 'placeholder' => 'Holiday Date')) }}
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
        <div class="form-group">
          <div class="col-sm-3 col-sm-offset-5">
            <input class="btn btn-danger pull-left" type="reset" value="Cancel">
            <input class="btn btn-primary pull-right" type="submit" value="Add Holiday">
          </div>
        </div>
      {{ Form::close() }}
    </div>
@stop