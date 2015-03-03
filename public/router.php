<?php
// router.php

$route = parse_url(substr($_SERVER["REQUEST_URI"], 1))["path"];

if (is_file($route)) {
    if(substr($route, -4) == ".php"){
        require $route;         // Include requested script files
        exit;
    }
    return false;               // Serve file as is
} else {                        // Fallback to index.php
    $_GET["q"] = $route;        // Try to emulate the behaviour of your htaccess here, if needed
    require "index.php";
}