<?php

error_reporting(E_ALL | E_STRICT);

define('_DIR_ROOT_', rtrim( str_replace("\\", '/', dirname(__FILE__)), '/') );
define('_PROTOCOL_', ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://");
define('_DOMAIN_', $_SERVER['HTTP_HOST']);
define('_APP_PATH_', rtrim(substr($_SERVER['REQUEST_URI'], 0, strpos($_SERVER['SCRIPT_NAME'], 'index.php')), '/'));
define('_URL_ROOT_', _PROTOCOL_ . _DOMAIN_ . _APP_PATH_);
define('_ROUTE_', implode('', explode(_APP_PATH_, $_SERVER['REQUEST_URI'], 2)));

include 'sys/funcs.php';
include 'sys/Anonymous.php';
include 'sys/Map.php';
include 'sys/Set.php';
include 'sys/Page.php';
include 'sys/View.php';
include 'sys/App.php';
include 'app/init.php';

App::instance()->run();