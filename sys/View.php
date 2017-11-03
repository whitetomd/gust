<?php

class View extends Map {

    protected $path = '';
    
    function __construct($path) {
        parent::__construct();
        $this->path = $path;
    }
    
    function __toString() {                
        $path = $this->path;
        return self::render($path, $this->all());
    }
        
    static function render($path, $params=array()) {        
        ob_start();
        extract($params);        
        include _DIR_ROOT_ . "/app/views/$path";
        return ob_get_clean();        
    }
    
}
