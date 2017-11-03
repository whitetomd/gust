<?php

import('app/class/admin/models/User');

class test_controller {

    function index($args) {
        $user = new User();
        $user->firstname = 'admin';
        $user->lastname = 'admin';
        $user->email = 'admin@mysite.com';
        $user->privileges = 0x7FFF;
        
        $user->create('admin');
        
        $data = $user->getData();
        var_export($data);
    }
    
}
