@extends('layouts.admin_layout')
<!--
  Page Name:                        index.blade.php
  author :		            Nicolas Naresh
  Date:			            June, 03 2014
  Purpose:		            This page displays users listing by including users/listing.blade.php file
  Table referred:		    -
  Table updated:	            -
  Most Important Related Files:      views/users/listing.blade.php, views/layouts/admin_layout.blade.php
-->

@section('content')
  <div class="row">
    <div class="col-lg-2 pull-left">
      <div class="form-group">
        <a class="btn btn-primary form-control normal-button" href="{{ URL::route('userCreate') }}">Add New User</a>
      </div>
    </div>
    <div class="col-lg-3 pull-right">
      <div class="form-group has-feedback">
        <input type="text" class="form-control" id="user-search" placeholder="Search Users" data-search_url="{{ URL::route('usersSearch') }}">
        <span class="glyphicon glyphicon-search form-control-feedback" style="top: 0px;"></span>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-lg-12">
      <table class="table table-striped table-hover table-condensed">
        <thead>
          <tr>
            <th>
              Name
            </th>
            <th>
              Email
            </th>
            <th>
              IN / OUT Time
            </th>
            <th>
              Phone Number
            </th>
            <th class="text-center">
              All Leaves<br>(This Year)
            </th>
            <th class="text-center">
              Available Leaves<br>(This Year)
            </th>
            <th>
              Carry Forward
            </th>
            <th class="text-center">
              Actions
            </th>
          </tr>
        </thead>
        <tbody id="user-listing-tbody">
          @include('users.listing', array('users'=>$users))
        </tbody>
      </table>
    </div>
  </div>
@stop