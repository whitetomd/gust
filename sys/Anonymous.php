<?php

class Anonymous {
    
    public $class = '';
    public $object = NULL;
    public $function = '';
    public $data = array();
    
    function __construct($classOrObject, $function, $data=array()) {
        if (is_object($classOrObject)) {
            $this->object = $classOrObject;            
        }
        else {
            $this->class = $classOrObject;
        }
        $this->function = $function;
        $this->data = $data;
    }
    
    function call() {
        $args = func_get_args();
        $object = $this->object;
        $function = $this->function;
        
        if (is_null($object)) {
            $class = $this->class;
            if (version_compare(PHP_VERSION, '5.3.0') >= 0) {
                return call_user_func_array(array($class, $function), $args);
            }
            else {
                return call_user_func("$class::$function", $args);
            }
        }
        else {                
            return call_user_func_array(array($object, $function), $args);
        }
    }
    
}
