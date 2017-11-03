<?php

class Rule extends Anonymous {

    protected $messageInvalid = '';
    
    function __construct($messageInvalid, $function, $data=array()) {
        parent::__construct($this, $function, $data);
        $this->messageInvalid = $messageInvalid;        
    }

    function getInvalidMessage() {
        return $this->messageInvalid;
    }
            
    function validate($value, &$message) {
        $valid = $this->call($value);
        if (!$valid) { $message = $this->getInvalidMessage(); }
        return $valid;
    }
    
    function validateRequired($value) {
        if (empty($value)) {
            return FALSE;
        }
        return TRUE;
    }

    function validateEmail($value) {
        if (filter_var($value, FILTER_VALIDATE_EMAIL) === FALSE) {
            return FALSE;
        }
        return TRUE;
    }

    function validateInt($value) {
        if (filter_var('' . $value, FILTER_VALIDATE_INT) === FALSE) {
            return FALSE;
        }
        return TRUE;
    }

    function validateFloat($value) {
        if (filter_var('' . $value, FILTER_VALIDATE_FLOAT) === FALSE) {
            return FALSE;
        }
        return TRUE;
    }

    function validateMinLength($value) {
        $min = $this->data['min'];
        if ((strlen('' . $value) >= $min) === FALSE) {
            return FALSE;
        }
        return TRUE;
    }

    function validateMaxLength($value) {
        $max = $this->data['max'];
        if ((strlen('' . $value) <= $max) === FALSE) {
            return FALSE;
        }
        return TRUE;
    }

    function validateRange($value) {
        $min = $this->data['min'];
        $max = $this->data['max'];
        if (($value >= $min) && ($value <= $max) === FALSE) {
            return FALSE;
        }
        return TRUE;
    }

    function validateWhitelist($value) {
        $whitelist = $this->data['whitelist'];
        if (in_array($value, $whitelist) === FALSE) {
            return FALSE;
        }
        return TRUE;
    }
    
    function validateBlacklist($value) {
        $blacklist = $this->data['blacklist'];
        if (in_array($value, $blacklist) === TRUE) {
            return FALSE;
        }
        return TRUE;
    }    
     
    function validateCharacterBlacklist($value) {
        $blacklist = $this->data['blacklist'];
        foreach ($blacklist as $char) {
            if (strpos($value, $char) !== FALSE) {
                return FALSE;
            }
        }
        return TRUE;
    }
    
    static function required($messageInvalid = '<span style="color:red;">required field</span>') {
        return new Rule($messageInvalid, 'validateRequired');
    }

    static function email($messageInvalid = '<span style="color:red;">invalid email address</span>') {
        return new Rule($messageInvalid, 'validateEmail');        
    }

    static function _int($messageInvalid = '<span style="color:red;">invalid whole number</span>') {
        return new Rule($messageInvalid, 'validateInt');
    }

    static function _float($messageInvalid = '<span style="color:red;">invalid floating point number</span>') {
        return new Rule($messageInvalid, 'validateFloat');
    }

    static function min_length($min, $messageInvalid = '<span style="color:red;">minimum length requirement not met</span>') {
        return new Rule($messageInvalid, 'validateMinLength', array('min'=>$min));
    }

    static function max_length($max, $messageInvalid = '<span style="color:red;">maximum length exceeded</span>') {
        return new Rule($messageInvalid, 'validateMaxLength', array('max'=>$max));
    }

    static function _range($min, $max, $messageInvalid = '<span style="color:red;">value not in range</span>') {
        return new Rule($messageInvalid, 'validateRange', array('min'=>$min, 'max'=>$max));
    }

    static function whitelist($whitelist, $messageInvalid = '<span style="color:red;">value not in allowed list</span>') {
        return new Rule($messageInvalid, 'validateWhitelist', array('whitelist'=>$whitelist));
    }

    static function blacklist($blacklist, $messageInvalid = '<span style="color:red;">value in disallowed list</span>') {
        return new Rule($messageInvalid, 'validateBlacklist', array('blacklist'=>$blacklist));
    }    
    
    static function character_blacklist($blacklist, $messageInvalid = '<span style="color:red;">value contains disallowed character</span>') {
        return new Rule($messageInvalid, 'validateCharacterBlacklist', array('blacklist'=>$blacklist));
    }    
}
