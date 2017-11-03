<?php

import('lib/forms/Form');
include 'PrivilegesInput.php';

class EditUser_Form extends Form {
    
    function __construct() {
        
        parent::__construct('admin/forms/frm_edit_user.php');
        
        $privileges = load('config/privileges');
        
        $this->add('email', self::hidden('email'));
        $this->add('firstname', self::text('firstname'));
        $this->add('lastname', self::text('lastname'));
        $this->add('privileges', new PrivilegesInput($privileges));
        
        $this->firstname->rules->add(Rule::required());
        $this->lastname->rules->add(Rule::required());
        
    }
    
}
