<!DOCTYPE html>
<html>
  <head>
    <!-- including Stylesheets -->
    <link type="text/css" media="all" rel="stylesheet" href="{{{asset('assets/css/bootstrap.min.css')}}}">
    <link type="text/css" media="all" rel="stylesheet" href="{{{asset('assets/css/datepicker.css')}}}">
	{{ HTML::style('assets/css/style.css') }}
    <!-- end including Stylesheets -->
  </head>
  <body>
    <div class="container-fluid">
      @yield('content')
    </div>
    <!-- including Scripts -->
    <script type="text/javascript" src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/bootstrap-datepicker.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/common.js') }}"></script>
    <!-- end including Scripts -->
  </body>
</html>