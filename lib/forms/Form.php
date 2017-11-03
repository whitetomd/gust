<?php

include_once 'Form_Input.php';

class Form extends View {
    
    function __construct($path) {
        parent::__construct($path);
    }

    function validate($validMessage='') {
        $valid = TRUE;
        $inputs = $this->all();
        foreach ($inputs as $name=>$input) {
            if ($input instanceof Form_Input) {
                $input->message = $validMessage;
                $tmp = $input->validate();
                if (!$tmp) { $valid = FALSE; }
            }
        }        
        return $valid;
    }
    
    function sanitize() {
        $inputs = $this->all();
        foreach ($inputs as $name=>$input) {
            if ($input instanceof Form_Input) {
                $input->sanitize();
            }
        }        
    }
    
    function getInput($name) {
        if ($this->has($name)) {
            $input = $this->$name;
            if ($input instanceof Form_Input) {
                return $input;
            }        
        }
        return FALSE;
    }
    
    function setInputValue($name, $value) {
        $input = $this->getInput($name);
        if ($input) {
            $input->value = $value;
            return TRUE;
        }
        return FALSE;
    }
    
    function fill($data) {
        foreach ($data as $key=>$value) {
            $this->setInputValue($key, $value);
        }
    }
    
    function getData() {
        $data = array();
        $inputs = $this->all();
        foreach ($inputs as $name=>$input) {
            if ($input instanceof Form_Input) {
                $data[$name] = $input->value;
            }
        }
        return $data;
    }
    
    static function label($name, $options=array()) { return new Form_Input($name, 'label', $options); }
    static function text($name) { return new Form_Input($name, 'text'); }
    static function file($name) { return new Form_Input($name, 'file'); }
    static function hidden($name) { return new Form_Input($name, 'hidden'); }
    static function password($name) { return new Form_Input($name, 'password'); }
    static function checkbox($name) { return new Form_Input($name, 'checkbox'); }
    static function radio($name, $options) { return new Form_Input($name, 'radio', $options); }
    static function select($name, $options) { return new Form_Input($name, 'select', $options); }
    static function textarea($name) { return new Form_Input($name, 'textarea'); }
    static function combobox($name, $options) { return new Form_Input($name, 'combobox', $options); }    
    
}
