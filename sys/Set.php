<?php

class Set {
    
    private $data = NULL;
    
    function __construct($data=array()) {
        $this->data = $data;
    }
    
    function add($item) {
        $this->data[] = $item;
        return count($this->data) - 1;
    }
    
    function remove($index) {
        unset($this->data[$index]);
    }
    
    function get($index) {
        return $this->data[$index];
    }
    
    function all() {
        return $this->data;
    }
    
    function length() {
        return count($this->data);
    }
}
