<?php

HTML::macro('menuItem', function($routes, $caption, $attribute = []) {
    $active = false;
    foreach ($routes as $route) {
        if (Route::currentRouteAction() == $route) {
            $active = true;
            break;
        }
    }
    return '<li role="presentation" class="nav nav-pills nav-stacked' . ($active ? ' active' : '') . '">' . HTML::linkAction($routes[0], $caption, $attribute) . '</li>';
});
