<?php

class App {
    
    public $routes = NULL;
    public $route = NULL;
    
    private static $instance = NULL;
               
    private function __construct() {
        $this->routes = new Map();
    }
    
    static function instance() {
        if (is_null(self::$instance)) {
            self::$instance = new App();
        }
        return self::$instance;
    }
    
    private function map($route) {
        $map = '';
        $route_keys = $this->routes->keys();
        foreach ($route_keys as $route_key) {
            if (substr($route, 0, strlen($route_key)) === $route_key) {
                $map = $route_key;
            }
        }
        return $map;
    }    
        
    private function dispatch($map, $args) {
        $data = $this->routes->$map;
        
        $controller_parts = explode('/', $data[0]);        
        $controller_name = end($controller_parts);
        $controller_path = substr($data[0], 0, strlen($data[0]) - strlen($controller_name));
        $action = $data[1];
        
        $this->route = new stdClass();
        
        $filepath = "app/controllers/$controller_path$controller_name.php";
        if (!file_exists($filepath)) { $this->throw404(); }
        $this->route->path = $controller_path;
        include $filepath;
                
        if (!class_exists($controller_name)) { $this->throw404(); }
        $this->route->controller = $controller_name;
        $controller_object = new $controller_name();
                
        if (!method_exists($controller_object, $action)) { $this->throw404(); }
        $this->route->action = $action;
        $this->route->args = $args;
        $controller_object->$action($args);
    }
    
    private function route(&$args) {
        $parts = explode('/', $_SERVER['REQUEST_URI']);
        $route = '/' . implode('/', array_slice($parts, 2));
        $map = $this->map($route);
        $remainder = ltrim(substr($route, strlen($map)), '/');
        $args = explode('/', $remainder);
        if (isset($args[0]) && empty($args[0])) { $args=array_slice($args,1); }
        return $map;
    }
    
    function throw404() {
        header('Status: 404 Not Found');
        $file404_path = _DIR_ROOT_ . '/404.php';
        include $file404_path;
        die();
    }
    
    function run() {
        session_start();
        $args = NULL;
        $map = $this->route($args);
        $this->dispatch($map, $args);
    }
}
