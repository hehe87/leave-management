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
    <link href='http://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'>
    <!-- including Stylesheets -->
    {{ HTML::style('assets/css/bootstrap.min.css') }}
    {{ HTML::style('assets/css/ui-lightness/jquery-ui-1.10.4.css') }}
    {{ HTML::style('assets/css/jquery.alerts.css') }}
    {{ HTML::style('assets/css/jquery.dataTables.min.css') }}
    {{ HTML::style('assets/css/dataTables.bootstrap.css') }}
    {{ HTML::style('assets/css/bootstrap-multiselect.css') }}
    {{ HTML::style('assets/css/mdp.css') }}
    {{ HTML::style('assets/css/pepper-ginder-custom.css') }}
    {{ HTML::style('assets/css/prettify.css') }}
    {{ HTML::style('assets/css/bootstrap-timepicker.min.css') }}
    {{ HTML::style('assets/css/admin_panel.css') }}
    {{ HTML::style('assets/css/style.css') }}
    <!-- end including Stylesheets -->

    <script type="text/javascript">
      window.currentYear = "{{ date('Y') }}";
    </script>
  </head>
  <body>
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-12 page_header">
          <div class="row">
            <div class="page_heading_text col-sm-6">
              Leave Management
            </div>
            <div class="col-sm-3 col-sm-offset-2">
              <div class="link show h4-new welcome-message pull-right">Welcome Administrator</div>
            </div>
            <div class="col-sm-1">
              <a class="link logout-link pull-right" href="{{ URL::route('userLogout') }}">
                Logout
              </a>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <!-- Left Panel Menus -->
        <ul id="left-panel" class="col-lg-2">
          {{ HTML::nav_link(Route::currentRouteName(), "users", "Users") }}
          {{ HTML::nav_link(Route::currentRouteName(), "add_leave", "Add Leave") }}
          {{ HTML::nav_link(Route::currentRouteName(), "holidays", "Holidays") }}
          {{ HTML::nav_link(Route::currentRouteName(), "pendingLeaves", "Pending Leaves") }}
          {{ HTML::nav_link(Route::currentRouteName(), "reports", "Reports") }}
          {{ HTML::nav_link(Route::currentRouteName(), "settings", "Settings") }}
          <li class="small-window-show">
            <a class="link" href="{{ URL::route('userLogout') }}">
              Logout
            </a>
          </li>
        </ul>
        <!-- End Left Panel Menus -->
        <!-- Content Panel -->
        <div id="content-panel" class="col-lg-10">
          @if(Session::get("message"))
            <div class="form-group">
              <div class="col-sm-12 alert alert-success">
                {{ Session::get("message") }}
              </div>
            </div>
          @endif
          @yield('content')
        </div>
        <!-- End Content Panel -->
      </div>
      <div class="page_footer">
        <div class="col-lg-6 col-lg-offset-6">
          <span class="pull-right">
            &copy; {{ date('Y') }} Rubico IT Private Limited
          </span>
        </div>
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
    <div id="blockUI" class="hide">
      <img src="{{ asset('assets/img/loading.gif') }}"/>
    </div>

    <!-- Including Scripts -->
    {{ HTML::script('assets/js/jquery.min.js') }}
    {{ HTML::script('assets/js/jquery-migrate.js') }}
    {{ HTML::script('assets/js/bootstrap.min.js') }}
    {{ HTML::script('assets/js/jquery.ui.js') }}
    {{ HTML::script('assets/js/jquery.easing.js') }}
    {{ HTML::script('assets/js/jquery.dataTables.min.js') }}
    {{ HTML::script('assets/js/dataTables.bootstrap.js') }}
    {{ HTML::script('assets/js/bootstrap-multiselect.js') }}
    {{ HTML::script('assets/js/jquery.ui.core.js') }}
    {{ HTML::script('assets/js/jquery.ui.datepicker.js') }}
    {{ HTML::script('assets/js/jquery.ui.multidatespicker.js') }}
    {{ HTML::script('assets/js/jquery.alerts.js') }}
    {{ HTML::script('assets/js/prettify.js') }}
    {{ HTML::script('assets/js/bootstrap-timepicker.min.js') }}
    {{ HTML::script('assets/js/common.js') }}
    {{ HTML::script('assets/js/admin_panel.js') }}
    <!-- End including Scripts -->
  </body>
</html>