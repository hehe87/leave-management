@extends('layouts.admin_layout')
<!--
  Page Name:                        index.blade.php
  author :		            Nicolas Naresh
  Date:			            June, 03 2014
  Purpose:		            This page displays holidays listing
  Table referred:		    -
  Table updated:	            -
  Most Important Related Files:     views/layouts/admin_layout.blade.php
-->


@section('content')
  <div class="row">
    <div class="col-lg-2 pull-left">
      <div class="form-group">
        <a class="btn btn-primary form-control normal-button" href="{{ URL::route('holidayCreate') }}">Add New Holiday</a>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-lg-12">
          @if( 0 == count($holidays) )
            <h3 align="center">No Holidays Found</h3>
          @else
      <table class="table table-striped table-hover table-condensed">
        <thead>
          <tr>
          </tr>
          <tr>
            <th>
              Date
            </th>
            <th>
              Description
            </th>
            <th class="text-center">
              Actions
            </th>
          </tr>
        </thead>
        <tbody>
          @foreach ($holidays as $holiday)
            <tr>
              <td>
                {{ date('d-m-Y', strtotime($holiday->holidayDate)) }}
              </td>
              <td>
                {{$holiday->holidayDescription}}
              </td>
              <td align="center">
                <table>
                  <tr>
                    <td><a href="{{ URL::route('holidayEdit',array('id' => $holiday->id)) }}" class="btn btn-primary btn-xs normal-button" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-edit"></span></a></td>
                    <td>&nbsp;&nbsp;</td>
                    <td><a href="{{ URL::route('holidayDestroy',array('id' => $holiday->id)) }}" class="btn btn-primary btn-xs normal-button" onclick="return confirm('Are you Sure');"><span class="glyphicon glyphicon-remove-circle"></span></a></td>
                  </tr>
                </table>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
        @endif
    </div>
  </div>
  <div class="row">

  </div>
@stop