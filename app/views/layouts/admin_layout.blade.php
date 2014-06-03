<!DOCTYPE html>
<html>
  <head>
    <!-- including Stylesheets -->
    <link type="text/css" media="all" rel="stylesheet" href="{{{asset('assets/css/bootstrap.min.css')}}}">
    <link type="text/css" media="all" rel="stylesheet" href="{{{asset('assets/css/ui-lightness/jquery-ui-1.10.4.css')}}}">
	{{ HTML::style('assets/css/jquery.dataTables.min.css') }}
	{{ HTML::style('assets/css/dataTables.bootstrap.css') }}
    <link type="text/css" media="all" rel="stylesheet" href="{{{asset('assets/css/admin_panel.css')}}}">
    <!-- end including Stylesheets -->
  </head>
  <body>
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-12 page_header">
          <div class="text-center page_heading_text">
            Leave Management Admin Panel
          </div>
          <a class="pull-right logout-link" href="{{ URL::route('userLogout') }}">
            Logout
          </a>
        </div>
      </div>
      <div class="row">
        <ul id="left-panel" class="col-lg-2">
          @if (Route::currentRouteName() === "usersListing")
            <li class="active">
              <a href="{{URL::route('usersListing')}}">Users</a>
            </li>
          @else
            <li>
              <a href="{{URL::route('usersListing')}}">Users</a>
            </li>
          @endif
          <li>
            <a href="{{ URL::to('/leaves/') }}">Leaves</a>
          </li>
          <li>
            <a href="">Reports</a>
          </li>
        </ul>
        <div id="content-panel" class="col-lg-10">
          @yield('content')  
        </div>
      </div>
    </div>
    <!-- including Scripts -->
    <script type="text/javascript" src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/jquery.ui.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/jquery.easing.js') }}"></script>
	{{ HTML::script('assets/js/jquery.dataTables.min.js') }}
	{{ HTML::script('assets/js/dataTables.bootstrap.js') }}
    <script type="text/javascript" src="{{ asset('assets/js/admin_panel.js') }}"></script>
    <!-- end including Scripts -->
  </body>
</html>