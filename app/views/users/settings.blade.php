@extends('layouts.admin_layout')
<!--
  Page Name:                        settings.blade.php
  author :		            Nicolas Naresh
  Date:			            June, 03 2014
  Purpose:		            This page displays settings page to admin
  Table referred:		    -
  Table updated:	            -
  Most Important Related Files:     views/layouts/admin_layout.blade.php
-->


@section('content')
  <div class="row">
    <div class="col-sm-12">
      <ul class="nav nav-tabs settings-tab-links">
        <li class="active"><a href="#account">Account Settings</a></li>
        <li><a href="#gapi">Google API Settings</a></li>
      </ul>
      
      <div class="tab-content">
        <div class="tab-pane fade in active" id="account">
          <div class="row">
            <div class="col-sm-12">
              @include("users.admin_account_settings")
            </div>
          </div>
        </div>
        <div class="tab-pane fade" id="gapi">
          <div class="row">
            <div class="col-sm-12">
              @include("users.google_api_settings")
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@stop