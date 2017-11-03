<?php

class DeleteUser_Handler {
        
    function onSubmit(&$status, &$status_error) {
        
        $app = App::instance();        
        $id = isset($app->route->args[0]) ? $app->route->args[0] : FALSE;
        
        if (!$id) {
            $status_error = "ERROR: No user id given";
            return FALSE;
        }
        
        try {
            $user = new User();
            $result = $user->fetch($id);
            if (!$result) { 
                $status_error = 'ERROR: User not found';
                return TRUE;
            }
            $user->delete();
            $status = 'User deleted successfully';
            return TRUE;
        }
        catch (Exception $ex) {
            $errcode = $ex->getCode();
            $errmsg = $ex->getMessage();
            $status_error = "ERROR #$errcode: $errmsg";
            return FALSE;            
        }
        
    }
    
}
