<?php

class AddUser_Handler {
        
    function onSubmit(Form $form, &$status, &$status_error) {
        
        $user = new User();
        $form->fill($_POST);
        $form->sanitize();
        $valid = $form->validate();
        
        if ($valid) {
            try {
                $user->setData($form->getData());
                $user->create($form->password->value);
                $status = 'User added successfully, please wait...';
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
