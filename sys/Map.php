<?php

class Map {
    
    private $data = NULL;
    
    function __construct($data=array()) {
        $this->data = $data;
    }

    function add($key, $item) {
        $this->data[$key] = $item;
    }
    
    function remove($key) {
        unset($this->data[$key]);
    }
    
    function __get($key) {
        return $this->data[$key];
    }
    
    function __set($key, $value) {
        $this->data[$key] = $value;
    }
    
    function values() {
        return array_values($this->data);
    }
    
    function keys() {
        return array_keys($this->data);
    }

    function has($key) {
        return in_array($key, array_keys($this->data));
    }
    
    function all() {
        return $this->data;
    }    

    function length() {
        return count($this->data);
    }

}
