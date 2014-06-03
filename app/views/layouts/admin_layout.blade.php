<!DOCTYPE html>
<html>
  <head>
    <!-- including Stylesheets -->
    <link type="text/css" media="all" rel="stylesheet" href="{{{asset('assets/css/bootstrap.min.css')}}}">
    <link type="text/css" media="all" rel="stylesheet" href="{{{asset('assets/css/ui-lightness/jquery-ui-1.10.4.css')}}}">
    <link type="text/css" media="all" rel="stylesheet" href="{{{asset('assets/css/admin_panel.css')}}}">
    <!-- end including Stylesheets -->
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
                <a class="link" href="#">Logged in as <b>{{ Auth::user()->name }}</b></a>
                <a class="link logout-link" href="{{ URL::route('userLogout') }}">
                  Logout
                </a>
              </div>
            </div>
          </div>
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
            <a href="">Leaves</a>
          </li>
          
          <li>
            <a href="">Reports</a>
          </li>
          
          @if (Route::currentRouteName() === "holidaysListing")
            <li class="active">
              <a href="{{URL::route('holidaysListing')}}">Holidays</a>
            </li>
          @else
            <li>
              <a href="{{URL::route('holidaysListing')}}">Holidays</a>
            </li>
          @endif
          
          <li class="small-window-show">
            <a class="link" href="#">Logged in as <b>{{ Auth::user()->name }}</b></a>
          </li>
          <li class="small-window-show">
            <a class="link" href="{{ URL::route('userLogout') }}">
              Logout
            </a>
          </li>
          <!--<li class="small-window-show">
            <a class="link hide-panel">Hide Panel</a>
          </li>-->
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
    <script type="text/javascript" src="{{ asset('assets/js/admin_panel.js') }}"></script>
    <!-- end including Scripts -->
  </body>
</html>