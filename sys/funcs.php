<?php

function import($path) {
    include_once _DIR_ROOT_ . "/$path.php";
}

function load($path) {
    return include(_DIR_ROOT_ . "/$path.php");
}

function get_public_vars($object) {
    return get_object_vars($object);
}

function is_assoc($array) {
    return (bool)count(array_filter(array_keys($array), 'is_string'));
}    

function is_postback() {
    return $_SERVER['REQUEST_METHOD'] == 'POST';
}

function redirect($url, $delay = 0) {
    if ($delay) {
        header("Refresh: $delay; url=$url");
    } else {
        header("Location: $url");
    }
}
    
function url($route, $args = array()) {
    $route = ltrim($route, '/');
    $url = _URL_ROOT_;
    if (!empty($route)) {
        $url .= "/$route";
        foreach ($args as $arg) {
            $url .= '/' . ltrim($arg, '/');
        }
    }
    return $url;
}

function asset($path) {
    return _URL_ROOT_ . "/app/assets/$path";
}

function stylesheet($href) {
    return "<link rel=\"stylesheet\" type=\"text/css\" href=\"$href\"/>";
}

function script($src) {
    return "<script src=\"$src\"></script>";
}

function db_mysql($username) {
    import('lib/db/Mysql_Database');
    $config = include(_DIR_ROOT_ . '/config/db.php');    
    $db = new Mysql_Database($username, $config['users'][$username], $config);
    return $db;
}

function db_sqlite($path) {
    import('lib/db/Sqlite_Database');
    $db = new Sqlite_Database($path);
    return $db;
}
