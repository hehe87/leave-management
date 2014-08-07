<!--
  Page Name:                        extra_leaves.blade.php
  author :		            Nicolas Naresh
  Date:			            June, 10 2014
  Purpose:		            This page contains the form for adding/updating extra leaves for selected
                                    user/users.
  Table referred:		    -
  Table updated:	            -
  Most Important Related Files:     -
-->
{{ Form::open(array('url' => URL::route('users.postSettings'), 'method' => 'post', 'role' => 'form', 'class' => 'form-horizontal not-rounded')) }}
  <legend class="form-signin-heading">Add Extra Leaves(For Current Year)</legend>
  <div class="form-group">
    <div class="col-lg-12">
      <div class="row">
        <div class="col-lg-3">
          <label class="control-label">Employee Name *</label>
        </div>
        <div class="col-lg-8">
          <input type="text" class="form-control" placeholder="Search Employee" value="{{ Input::get('extra_leaves.employee_name') != '' ? Input::get('extra_leaves.employee_name') : (isset($data['username']) ? $data['username'] : '' ) }}" name="extra_leaves[employee_name]" autocomplete="off" id="user-search"  data-search_url="{{ URL::route('usersSearch') }}" data-view="singleColumnList" data-onblank="nil" data-onselect="getExtraLeaves" data-onselectajaxurl="{{ URL::route('users.getExtraLeaves') }}"/>
          <div id="lm-autosearch">
            <table class="table hide">
              <tbody id="user-listing-tbody">
                
              </tbody>
            </table>
          </div>
        </div>
      </div>
      @if ($errors->first('employee_name'))
        <div class="row">
          <div class="col-sm-8 col-sm-offset-3">
            <div class="alert alert-danger">
              {{{ $errors->first('employee_name') }}}
            </div>
          </div>
        </div>
      @endif
    </div>
  </div>
  
  
  <div class="form-group">
    <div class="col-lg-12">
      <div class="row">
        <div class="col-lg-3">
          <label class="control-label">Select Leave *</label>
        </div>
        <div class="col-lg-3">
          @if (isset($data) && !isset($data['paternityLeave']) && !isset($data['maternityLeave']))
            {{ Form::radio('extra_leaves[leave_type]', "paternity", '' ,array("class" => "")) }} Paternity Leaves
          @else
            @if(isset($data) && isset($data['paternityLeave']))
              Paternity Leave Taken
            @else
              @if(!isset($data['maternityLeave']))
                {{ Form::radio('extra_leaves[leave_type]', "paternity", '' ,array("class" => "")) }} Paternity Leaves
              @endif
            @endif
          @endif
        </div>
        <div class="col-lg-3">
          @if (isset($data) && !isset($data['maternityLeave']) && !isset($data['paternityLeave']))
            {{ Form::radio('extra_leaves[leave_type]', "maternity", '' ,array("class" => "")) }} Maternity Leaves
          @else
            @if(isset($data) && isset($data['maternityLeave']))
              Maternity Leave Taken
            @else
              @if(!isset($data['paternityLeave']))
                {{ Form::radio('extra_leaves[leave_type]', "maternity", '' ,array("class" => "")) }} Maternity Leaves
              @endif
            @endif
          @endif
        </div>
        <div class="col-lg-3">
          {{ Form::radio('extra_leaves[leave_type]', "extra", '' ,array("class" => "extra-leave-leave_type")) }} Extra Leaves  
        </div>
      </div>
      @if ($errors->first('leave_type'))
        <div class="row">
          <div class="col-sm-8 col-sm-offset-3">
            <div class="alert alert-danger">
              {{{ $errors->first('leave_type') }}}
            </div>
          </div>
        </div>
      @endif
    </div>
  </div>
  
  
  <div class="form-group fade extra-leave-description {{ Input::old('extra_leaves.leave_type') == "extra"? 'in' : ''  }}">
    <div class="col-lg-12">
      <div class="row">
        <div class="col-lg-3">
          <label class="control-label">Extra Leaves</label>
        </div>
        <div class="col-lg-8">
          {{ Form::text('extra_leaves[leaves_count]', "", array("class" => "form-control", "placeholder" => "Number of extra leaves"))}}
        </div>
      </div>
      @if ($errors->first('leaves_count'))
        <div class="row">
          <div class="col-sm-8 col-sm-offset-3">
            <div class="alert alert-danger">
              {{{ $errors->first('leaves_count') }}}
            </div>
          </div>
        </div>
      @endif
    </div>
  </div>
  
  <div class="form-group fade extra-leave-description {{ Input::old('extra_leaves.leave_type') == "extra"? 'in' : ''  }}">
    <div class="col-lg-12">
      <div class="row">
        <div class="col-lg-3">
          <label class="control-label">Comment</label>
        </div>
        <div class="col-lg-8">
          {{ Form::text('extra_leaves[description]', "", array("class" => "form-control", "placeholder" => "Description"))}}
        </div>
      </div>
      @if ($errors->first('description'))
        <div class="row">
          <div class="col-sm-8 col-sm-offset-3">
            <div class="alert alert-danger">
              {{{ $errors->first('description') }}}
            </div>
          </div>
        </div>
      @endif
    </div>
  </div>
  
  <div class="form-group fade {{ Input::old('extra_leaves.leave_type') ? 'in' : ''  }}" id="extra-leave-fromdate">
    <div class="col-lg-12">
      <div class="row">
        <div class="col-lg-3">
          <label class="control-label">From Date</label>
        </div>
        <div class="col-lg-8">
          {{ Form::text("extra_leaves[from_date]", "", array("class" => "form-control date_control", "placeholder" => "From Date")) }}
        </div>
      </div>
      @if ($errors->first('from_date'))
        <div class="row">
          <div class="col-sm-8 col-sm-offset-3">
            <div class="alert alert-danger">
              {{{ $errors->first('from_date') }}}
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