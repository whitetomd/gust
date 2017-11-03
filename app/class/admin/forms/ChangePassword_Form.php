<?php

import('lib/forms/Form');

class ChangePassword_Form extends Form {
    
    function __construct() {
        parent::__construct('admin/forms/frm_change_pass.php');

        $this->add('firstname', self::text('firstname'));
        $this->add('lastname', self::text('lastname'));
        $this->add('email', self::text('email'));
        $this->add('password', self::password('password'));
        $this->add('repeat', self::password('repeat'));
  
        $this->firstname->attributes->add('disabled', 'disabled');
        $this->lastname->attributes->add('disabled', 'disabled');
        $this->email->attributes->add('disabled', 'disabled');
        
        $this->password->rules->add(Rule::required());
        $this->repeat->rules->add(Rule::required());                
    }

    function validate($validMessage = '') {
        $valid = parent::validate($validMessage);
        $password = $this->password;
        $repeat = $this->repeat;
        if ($password->value !== $repeat->value) {
            $password->message = '<span style="color:red;">passwords do not match</span>';
            $valid = FALSE;
        }
        return $valid;
    }    
    
}
