<?php

import('lib/forms/Form');
include 'PrivilegesInput.php';

class AddUser_Form extends Form {
    
    function __construct() {
        
        parent::__construct('admin/forms/frm_add_user.php');
        
        $privileges = load('config/privileges');
        
        $this->add('firstname', self::text('firstname'));
        $this->add('lastname', self::text('lastname'));
        $this->add('email', self::text('email'));
        $this->add('password', self::password('password'));
        $this->add('repeat', self::password('repeat'));
        $this->add('privileges', new PrivilegesInput($privileges));
        
        $this->firstname->rules->add(Rule::required());
        $this->lastname->rules->add(Rule::required());
        $this->email->rules->add(Rule::required());
        $this->email->rules->add(Rule::email());
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
