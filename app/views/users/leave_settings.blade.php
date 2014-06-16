<!--
  Page Name:                        leave_settings.blade.php
  author :		            Nicolas Naresh
  Date:			            June, 10 2014
  Purpose:		            This page contains the form for updating the leave settings
  Table referred:		    -
  Table updated:	            -
  Most Important Related Files:     -
-->
{{ Form::open(array('url' => URL::route('users.postSettings'), 'method' => 'post', 'role' => 'form', 'class' => 'form-horizontal')) }}
  <legend class="form-signin-heading">Google API Settings</legend>
  @include("layouts.form_group_3-8", array("label" => array("text" => "Carry Forward Leaves", "name" => "leave_setting[carry_forward_leaves]"), "input" => array("type" => "text", "value" => $leaveConfig["carry_forward_leaves"]->leave_days, "name" => "leave_setting[carry_forward_leaves]", "placeholder" => "Carry Forward Leave Count"), "err" => array("name" => "carry_forward_leaves")))
  @include("layouts.form_group_3-8", array("label" => array("text" => "Paternity Leaves", "name" => "leave_setting[paternity_leaves]"), "input" => array("type" => "text", "value" => $leaveConfig["paternity_leaves"]->leave_days, "name" => "leave_setting[paternity_leaves]", "placeholder" => "Paternity Leaves Count"), "err" => array("name" => "paternity_leaves")))
  @include("layouts.form_group_3-8", array("label" => array("text" => "Maternity Leaves", "name" => "leave_setting[maternity_leaves]"), "input" => array("type" => "text", "value" => $leaveConfig["maternity_leaves"]->leave_days, "name" => "leave_setting[maternity_leaves]", "placeholder" => "Maternity Leaves Count"), "err" => array("name" => "maternity_leaves")))
  @include("layouts.form_group_3-8", array("label" => array("text" => "Paid Leaves", "name" => "leave_setting[paid_leaves]"), "input" => array("type" => "text", "value" => $leaveConfig["paid_leaves"]->leave_days, "name" => "leave_setting[paid_leaves]", "placeholder" => "Paid Leaves Count"), "err" => array("name" => "paid_leaves")))
  
  <div class="form-group">
    <div class="col-sm-12">
      <div class="row">
        <div class="col-sm-3">
          {{ Form::label("leave_setting[official_year_date]", "New Official Year Date" , array('class' => 'control-label')) }}
        </div>
        <div class="col-sm-2">
          {{ Form::select("leave_setting[official_year_day]", $dayList, $yearStart->startDay ,array("class" => "form-control")) }}
        </div>
        <div class="col-sm-3">
          {{ Form::select("leave_setting[official_year_month]", $monList, $yearStart->startMonth, array("class" => "form-control")) }}
        </div>
        <div class="col-sm-3">
          {{ Form::text("leave_setting[official_year]", date("Y"), array('class' => 'form-control', 'readonly' => true)) }}
        </div>
      </div>
      @if ($errors->first("new_official_year_date"))
        <div class="row">
          <div class="col-sm-8 col-sm-offset-3">
            <div class="alert alert-danger">
              Please Select the above options first
            </div>
          </div>
        </div>
      @endif
    </div>
  </div>
  
  <div class="form-group">
    <div class="col-sm-8 col-sm-offset-3">
      <a class="btn btn-danger pull-left" href="{{ URL::previous() }}">Cancel</a>
      <input class="btn btn-primary pull-right" type="submit" value="Update">
    </div>
  </div>
{{ Form::close() }}