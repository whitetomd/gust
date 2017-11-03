<?php

include_once 'Rule.php';
include_once 'Sanitize.php';

class Form_Input {
        
    public $name = '';
    public $type = '';
    public $value = '';    
    public $message = '';
    
    public $options = NULL;  
    public $attributes = NULL;
    public $rules = NULL;
    public $sanitizers = NULL;
        
    function __construct($name, $type, $options=array()) {
        $this->options = new Map($options);
        $this->attributes = new Map();
        $this->rules = new Set();
        $this->sanitizers = new Set();
        $this->name = $name;
        $this->type = $type;
        $this->attributes->add('id', "id-$name");
    }    
    
    private function attributesToString() {
        $attr = '';
        $attributes = $this->attributes->all();
        foreach ($attributes as $key=>$value) {
            $attr .= "$key=\"$value\" ";
        }
        return rtrim($attr);
    }    
    
    private function optionsToString($selectedValue) {
        $opts = '';
        $options = $this->options->all();
        foreach ($options as $caption => $value) {
            $opts .= "<option value=\"$value\"";
            if ($selectedValue === $value) {
                $opts .= " selected=\"selected\" ";
            }
            $opts .= ">$caption";
            $opts .= "</option>";
        }        
        return $opts;
    }
    
    function validate() {
        $rules = $this->rules->all();
        foreach ($rules as $rule) {
            $msg = '';
            $valid = $rule->validate($this->value, $msg);
            if (!$valid) {
                $this->message = $msg;
                return FALSE;
            }
        }
        return TRUE;
    }    
    
    function sanitize() {
        $sanitizers = $this->sanitizers->all();
        foreach ($sanitizers as $sanitizer) {            
            $this->value = $sanitizer->clean($this->value);
        }        
    }    
    
    function asInput($type) {
        $name = $this->name;
        $value = $this->value;
        $attr = $this->attributesToString();
        return "<input name=\"$name\" type=\"$type\" value=\"$value\" $attr/>";
    }
    
    function asFile() {
        return $this->asInput('file');
    }
    
    function asText() {
        return $this->asInput('text');
    }

    function asPassword() {
        return $this->asInput('password');
    }

    function asHidden() {
        return $this->asInput('hidden');
    }

    function asCheckbox() {
        $name = $this->name;
        $value = $this->value;
        $attr = $this->attributesToString();
        $html = '';

        $html .= "<input name=\"$name\" type=\"checkbox\"";
        if (!empty($value)) {
            $html .= " checked=\"checked\" $attr/>";
        } else {
            $html .= " $attr/>";
        }
        return $html;
    }

    function asRadio() {
        $name = $this->name;
        $id = $this->attributes->id;
        $value = $this->value;
        $attr = $this->attributesToString();
        $html = '';

        $options = $this->options->all();
        foreach ($options as $caption => $_value) {
            $radioid = "$id-$_value";
            $html .= "<input name=\"$name\" id=\"$radioid\" type=\"radio\" value=\"$_value\"";
            if ($value === $_value) {
                $html .= " checked=\"checked\" $attr/>";
            } else {
                $html .= " $attr/>";
            }
            $html .= $caption;
            $html .= '<br>';
        }

        return $html;
    }

    function asTextarea() {
        $name = $this->name;
        $value = $this->value;
        $attr = $this->attributesToString();
        $html = '';

        $html .= "<textarea name=\"$name\" $attr>";
        $html .= $value;
        $html .= "</textarea>";
        return $html;
    }

    function asSelect() {
        $name = $this->name;
        $value = $this->value;
        $attr = $this->attributesToString();
        $html = '';

        $html .= "<select name=\"$name\" value=\"$value\" $attr>";        
        $html .= $this->optionsToString($value);
        $html .= "</select>";

        return $html;
    }

    function asCombobox() {
        $name = $this->name;
        $id = $this->attributes->id;
        $value = $this->value;
        $listid = "$id-list";
        $attr = $this->attributesToString();
        $html = '';

        $html .= "<input name=\"$name\" type=\"datalist\" value=\"$value\" list=\"$listid\" $attr/>";
        $html .= "<datalist id=\"$listid\">";
        $html .= $this->optionsToString($value);        
        $html .= "</datalist>";

        return $html;
    }
    
    function __toString() {
        return $this->render();
    }
    
    function render() {
        switch ($this->type) {
            case 'text': return $this->asText();
            case 'file': return $this->asFile();
            case 'hidden': return $this->asHidden();
            case 'password': return $this->asPassword();
            case 'checkbox': return $this->asCheckbox();
            case 'radio': return $this->asRadio();
            case 'select': return $this->asSelect();
            case 'textarea': return $this->asTextarea();
            case 'datalist':
            case 'combobox':
                return $this->asCombobox();
        }
    }
        
}
