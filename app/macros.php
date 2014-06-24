<?php
HTML::macro('nav_link', function($route, $text)
{
    $class = ( URI::is($route) or URI::is($route.'/*') ) ? 'class="active"' : '';
    $href  = URL::to($route);

    $action = Request::route();
    $action = $action->action;

    if ( isset($action['as']) )
    {
        $class = ( ($action['as'] == $route) or ($action['as'] == $route.'/*') ) ? 'class="lms-active"' : '';
        $href  = URL::to_route($route);
    }

    return '<li ' . $class . '><a href="' . $href . '">' . $text . '</a></li>';
});