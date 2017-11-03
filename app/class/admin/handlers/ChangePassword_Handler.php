<?php

class ChangePassword_Handler {
        
    function onLoad(Form $form, &$status, &$status_error) {
        
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
            $form->fill($user->getData());
            $status = '';
            return TRUE;
        }
        catch (Exception $ex) {
            $errcode = $ex->getCode();
            $errmsg = $ex->getMessage();
            $status_error = "ERROR #$errcode: $errmsg";
            return FALSE;            
        }
    }
    
    function onSubmit(Form $form, &$status, &$status_error) {

        $app = App::instance();        
        $id = isset($app->route->args[0]) ? $app->route->args[0] : FALSE;
        
        if (!$id) {
            $status_error = "ERROR: No user id given";
            return FALSE;
        }
        
        $user = new User();
        $result = $user->fetch($id);        
        
        if (!$result) {
            $status_error = 'ERROR: User not found';
            return FALSE;
        }
        
        $form->fill($_POST);
        $form->sanitize();
        $valid = $form->validate();
        
        if ($valid) {
            try {                
                $user->setPassword($form->password->value);
                $user->update();
                $status = 'Password updated successfully, please wait...';
                return TRUE;
            }
            catch(Exception $ex) {
                $errcode = $ex->getCode();
                $errmsg = $ex->getMessage();
                $status_error = "ERROR #$errcode: $errmsg";
                return FALSE;
            }
        }
        else {
            $status_error = 'Please fix errors and re-submit...';
            return FALSE;
        }
        
    }
    
}
