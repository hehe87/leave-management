<!--
  Page Name:                       admin_layout.blade.php
  author :		            Nicolas Naresh
  Date:			            June, 03 2014
  Purpose:		            This page acts as a layout for admin panel
  Table referred:		    -
  Table updated:	            -
  Most Important Related Files:      --
-->
<!DOCTYPE html>
<html>
  <head>
    <link rel="icon" href="{{ asset('assets/img/lms.ico') }}" type="image/x-icon">
    <link rel="shortcut icon" href="{{ asset('assets/img/lms.ico') }}" type="image/x-icon">
    <link rel="shortcut icon" href="{{ asset('assets/img/lms.ico') }}" type="image/vnd.microsoft.icon">
    <!-- including Stylesheets -->
    <link type="text/css" media="all" rel="stylesheet" href="{{{asset('assets/css/bootstrap.min.css')}}}">
    <link type="text/css" media="all" rel="stylesheet" href="{{{asset('assets/css/ui-lightness/jquery-ui-1.10.4.css')}}}">
    {{ HTML::style('assets/css/jquery.dataTables.min.css') }}
    {{ HTML::style('assets/css/dataTables.bootstrap.css') }}
    {{ HTML::style('assets/css/bootstrap-multiselect.css') }}
    {{ HTML::style('assets/css/mdp.css') }}
    {{ HTML::style('assets/css/pepper-ginder-custom.css') }}
    {{ HTML::style('assets/css/prettify.css') }}
    <link type="text/css" media="all" rel="stylesheet" href="{{{asset('assets/css/admin_panel.css')}}}">
    {{ HTML::style('assets/css/style.css') }}
    <!-- end including Stylesheets -->
    
    <script type="text/javascript">
      window.currentYear = "{{ date('Y') }}";
    </script>
  </head>
  <body>
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-12 page_header text-center">
          <div class="row">
            <div class="text-center page_heading_text">
              Leave Management Admin Panel
            </div>
          </div>
          <div class="row">
            <div class="col-lg-6 col-lg-offset-3">
              <div class="link show h4-new">Welcome Administrator</div>
            </div>
            <div class="col-lg-3">
              <div class="text-center">
                <span class="link">Logged in as <b>{{ Auth::user()->name }}</b></span>
                <a class="link logout-link" href="{{ URL::route('userLogout') }}">
                  Logout
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <!-- Left Panel Menus -->
        <ul id="left-panel" class="col-lg-2">
          @if (Route::currentRouteName() === "usersListing")
            <li class="lms-active">
              <a href="{{URL::route('usersListing')}}">Users</a>
            </li>
          @else
            <li>
              <a href="{{URL::route('usersListing')}}">Users</a>
            </li>
          @endif
          
          <li>
            <a href="{{ URL::route('leaves.report') }}">Reports</a>
          </li>
          
          @if (Route::currentRouteName() === "holidaysListing")
            <li class="lms-active">
              <a href="{{URL::route('holidaysListing')}}">Holidays</a>
            </li>
          @else
            <li>
              <a href="{{URL::route('holidaysListing')}}">Holidays</a>
            </li>
          @endif
          <li>
              <a href="{{URL::route('users.settings')}}">Settings</a>
            </li>
          <li class="small-window-show">
            <a class="link" href="#">Logged in as <b>{{ Auth::user()->name }}</b></a>
          </li>
          <li class="small-window-show">
            <a class="link" href="{{ URL::route('userLogout') }}">
              Logout
            </a>
          </li>
        </ul>
        <!-- End Left Panel Menus -->
        <!-- Content Panel -->
        <div id="content-panel" class="col-lg-10">
          @yield('content')  
        </div>
        <!-- End Content Panel -->
      </div>
    </div>
    
    
    <div class="modal fade" id="user-modal">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title">Modal title</h4>
          </div>
          <div class="modal-body">
            <p>One fine body&hellip;</p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary normal-button" data-dismiss="modal">Close</button>
          </div>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    
    
    
    <!-- Including Scripts -->
    <script type="text/javascript" src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/jquery.ui.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/jquery.easing.js') }}"></script>
    {{ HTML::script('assets/js/jquery.dataTables.min.js') }}
    {{ HTML::script('assets/js/dataTables.bootstrap.js') }}	
    {{ HTML::script('assets/js/bootstrap-multiselect.js') }}
    {{ HTML::script('assets/js/jquery.ui.multidatespicker.js') }}
    {{ HTML::script('assets/js/prettify.js') }}
    <script type="text/javascript" src="{{ asset('assets/js/admin_panel.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/common.js') }}"></script>
    <!-- End including Scripts -->
  </body>
</html>