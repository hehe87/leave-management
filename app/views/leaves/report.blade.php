@extends('layouts.admin_layout')

@section('content')
  <div class="row">
    <div class="col-lg-12">
      <form action="" method="get" id="report-form" role="form">
        <div class="row">
          <div class="col-lg-2">
            <select class="form-control required" name="leave_type">
              <option value="CSR" {{  Input::get("leave_type") === "CSR" ? "selected" : "" }}>CSR</option>
              <option value="LEAVE" {{  Input::get("leave_type") === "LEAVE" ? "selected" : "" }}>Leave</option>
              <option value="FH" {{  Input::get("leave_type") === "LEAVE" ? "selected" : "" }}>First Half</option>
              <option value="SH" {{  Input::get("leave_type") === "LEAVE" ? "selected" : "" }}>Second Half</option>
              <option value="LONG" {{  Input::get("leave_type") === "LEAVE" ? "selected" : "" }}>Long Leave</option>              
            </select>
          </div>
          <div class="col-lg-2">
            <select class="form-control" id="date-option" name="date_option">
              <option value="between-dates"{{  Input::get("date_option") === "between-dates" ? "selected" : "" }}>Between Dates</option>
              <option value="by-month"{{  Input::get("date_option") === "by-month" ? "selected" : "" }}>By Month</option>
              <option value="by-year"{{  Input::get("date_option") === "by-year" ? "selected" : "" }}>By Year</option>
              <option value="by-date"{{  Input::get("date_option") === "by-date" ? "selected" : "" }}>By Date</option>
            </select>
          </div>
          <div class="col-lg-3">
            <div class="row" id="date_option_inputs">
              @if(Input::get("date_option")== NULL || (Input::get("date_option") === "between-dates"))
                <div class="col-sm-6"><input type="text" name="from_date" value="{{ Input::get('from_date') }}" class="form-control date_control required" placeholder="From"/></div>
                <div class="col-sm-6"><input type="text" name="to_date" value="{{ Input::get('to_date') }}" class="form-control date_control required" placeholder="To"/></div>
              @else
                @if(Input::get("date_option") === "by-month")
                  <div class="col-sm-12">
                    <select class="form-control" id="date-option" name="month">
                      @for($i=1;$i<=12;$i++)
                        <option value="{{ $i }}" {{ Input::get("month") == $i ? "selected" : "" }}>{{ $i }}</option>
                      @endfor
                    </select>
                  </div>
                @else
                  @if(Input::get("date_option") === "by-year")
                    <div class="col-sm-12">
                      <select class="form-control" id="date-option" name="year">
                        @for($i=2014;$i<=2015;$i++)
                          <option value="{{ $i }}" {{ Input::get("year") == $i ? "selected" : "" }}>{{ $i }}</option>
                        @endfor
                      </select>
                    </div>
                    
                  @else
                    <div class="col-sm-12">
                      <input type="text" name="on_date"  value="{{ Input::get('on_date') }}" class="form-control date_control" placeholder="On Date"/>
                    </div>
                  @endif
                @endif
              @endif
            </div>
          </div>
          <div class="col-lg-3">
            <input type="text" class="form-control" placeholder="Employee Name" value="{{ Input::get('employee_name') }}" name="employee_name" autocomplete="off" id="user-search"  data-search_url="{{ URL::route('usersSearch') }}" data-view="singleColumnList" data-onblank="nil"/>
            <div id="lm-autosearch">
              <table class="table">
                <tbody id="user-listing-tbody">
                  
                </tbody>
              </table>
            </div>
          </div>
          <div class="col-lg-2">
            <input type="submit" name="generate_report" class="btn btn-primary normal-button" value="Get Report"/>
          </div>
        </div>
      </form>
    </div>
  </div>
  <div class="row margin-top-10 {{ !is_null($leaves) ? 'show' : 'hide' }}">
    @if(isset($leaves) && (count($leaves->toArray())!=0))
      <table class="table table-striped table-bordered table-hover ">
        <thead>
          <tr>
            <th style="vertical-align: middle; text-align: center;">
              Date
            </th>
            @if($leaves->first()->leave_type === "CSR")
              <th style="width: 21.5%;">
                From Time
              </th>
              <th>
                To Time
              </th>
            @else
              <th>
                Reason
              </th>
            @endif
            <th>
              Approved By
            </th>
          </tr>
        </thead>
        
          @foreach($leaves as $leave)
            <tbody>
              <tr>
                @if($leave->leave_type === "CSR")
                  <td style="border: 1px solid #ddd vertical-align: middle; text-align: center;">{{ date("d-m-Y",strtotime($leave->leave_date)) }}</td>
                @else
                  <td style="border: 1px solid #ddd vertical-align: middle; text-align: center;">{{ date("d-m-Y",strtotime($leave->leave_date)) }}</td>
                  <td>{{ $leave->reason }}</td>
                  <td align="center">
                    <a class="btn btn-primary normal-button btn-xs view-approvals" data-url="{{ URL::route('approval.leaveApprovals', array('id' => $leave->id))}}" title="View Approvals"><span class="glyphicon glyphicon-eye-open"></span></a>
                  </td>
                @endif
                @if($leave->leave_type === "CSR")
                  <td colspan="2">
                    <table class="table table-bordered margin-bottom-0">
                      @foreach($leave->csrs as $csr)
                        <tr>
                          <td>
                            {{ $csr->from_time }}
                          </td>
                          <td>
                            {{ $csr->to_time }}
                          </td>
                        </tr>
                      @endforeach
                    </table>
                  </td>
                  <td align="center" style="vertical-align: middle;">
                    <a class="btn btn-primary normal-button btn-xs view-approvals" data-url="{{ URL::route('approval.leaveApprovals', array('id' => $leave->id))}}" title="View Approvals"><span class="glyphicon glyphicon-eye-open"></span></a>
                  </td>
                @endif
              </tr>
            </tbody>
          @endforeach
      </table>
    @endif
  </div>
@stop