<!--
  Page Name:                       login_layout.blade.php
  author :		            Nicolas Naresh
  Date:			            May, 30 2014
  Purpose:		            This page acts as a layout for login/forgotpassword panel
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
    <link href='http://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'>
    <!-- including Stylesheets -->
    <link type="text/css" media="all" rel="stylesheet" href="{{{asset('assets/css/bootstrap.min.css')}}}">
    <link type="text/css" media="all" rel="stylesheet" href="{{{asset('assets/css/ui-lightness/jquery-ui-1.10.4.css')}}}">
    {{ HTML::style('assets/css/style.css') }}
    <link type="text/css" media="all" rel="stylesheet" href="{{{asset('assets/css/login.css')}}}">
    <!-- end including Stylesheets -->
  </head>
  <body>

    <div class="container-fluid">
      <div class="row">
        <br/>
        <br/>
        <div class="col-sm-4 col-sm-offset-4 login-well well">
          <div class="row">
            <div class="col-sm-12">
              @if(Session::has('message'))
                <div class="alert alert-info">
                  {{ Session::get('message') }}
                </div>
              @endif
              @if (Session::has("success"))
                <div class="alert alert-success">
                  {{ Session::get('success') }}
                </div>
              @else
                @if (Session::has("error"))
                  <div class="alert alert-danger">
                    {{ Session::get('error') }}
                  </div>
                @endif
              @endif
            </div>
          </div>
          @yield('content')
        </div>
        <div class="page_footer">
          <div class="col-lg-6 col-lg-offset-6">
            <span class="pull-right">
              &copy; {{ date('Y') }} Rubico IT Private Limited
            </span>
          </div>
        </div>
      </div>
    </div>

    <!-- including Scripts -->
    <script type="text/javascript" src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/jquery.ui.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/common.js') }}"></script>
    <!-- end including Scripts -->
  </body>
</html>