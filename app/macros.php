<?php

HTML::macro('nav_link', function($route_name, $link_name, $text)
{
    $routes = array(
            "usersListing" => "users",
            "userCreate" => "users",
            "userEdit" => "users",
            "leaves.report" => "reports",
            "leaves.create" => "add_leave",
            "leaves.edit" => "add_leave",
            "holidayCreate" => "holidays",
            "holidayEdit" => "holidays",
            "holidaysListing" => "holidays",
           "users.settings"  => "settings",
           "leaves.pendingLeaves" => "pendingLeaves",
           "myLeaves" =>"myleaves",
           "leaveRequests" => "leaverequests",
           "usersHome" => "usersHome"
    );
    $menuhrefs = array(
        "users" => "usersListing",
        "reports" => "leaves.report",
        "add_leave" => "leaves.create",
        "holidays" => "holidaysListing",
        "settings" => "users.settings",
        "pendingLeaves" => "leaves.pendingLeaves",
        "myleaves" => "myLeaves",
        "leaverequests" => "leaveRequests",
        "usersHome" => "usersHome"
    );
    $class = "";
    if($routes[$route_name] == $link_name){
        $class="lms-active";
    }
    $href  = URL::route($menuhrefs[$link_name]);
    return '<li class="' . $class . '"><a href="' . $href . '">' . $text . '</a></li>';

});