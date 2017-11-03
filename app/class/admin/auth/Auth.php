<?php

import('app/class/admin/models/User');

class Auth {
    
    static function approve($privilege='', $message='<b style="color: #cc0000;">ACCESS DENIED</b>') {
        $user = new User();        
        if ($user->fetchLoggedIn()) {
            if (!empty($privilege)) {
                $privileges = load('config/privileges');
                if ($user->hasPrivilege($privileges[$privilege])) {
                    return TRUE;
                }
                else {
                    die($message);
                }
            }
            return TRUE;
        }
        else {
            redirect(url('login'));
            return FALSE;
        }
    }   

}
