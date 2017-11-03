<?php

import('lib/views/Navigation_View');
import('lib/views/SortableTable_View');
import('app/class/admin/auth/Auth');
import('app/class/admin/models/User');

class usermgr_controller extends Page {
    
    function __construct() {
        parent::__construct('admin/default_page.php');
        $this->links->add(stylesheet(asset('css/admin/page.css')));
        $this->links->add(stylesheet(asset('css/admin/usermgr.css')));
        $this->add('navtop', new Navigation_View());
    }
    
    function index($args) {
        Auth::approve('view users');
        import('app/class/admin/views/UserTable_View');
        $user = new User();
        //if (!$user->tableExists()) { $user->createTable(); }
        $rows = $user->select();
        $view = new UserTable_View($rows, 'ASC');
        
        $this->navtop->add(url('admin'), 'Admin Home');
        $this->navtop->add(url('usermgr/add'), 'Add User');
        $this->title = 'Usermgr';
        $this->content = $view;
        $this->render();                
    }
    
    function add_user($args) {        
        Auth::approve('add users');
        import('app/class/admin/forms/AddUser_Form');
        $this->links->add(stylesheet(asset('css/admin/forms.css')));
                
        $status = '';
        $status_error = '';
        
        $form = new AddUser_Form();

        if (is_postback()) {
            import('app/class/admin/handlers/AddUser_Handler');
            $handler = new AddUser_Handler();
            $result = $handler->onSubmit($form, $status, $status_error);
            if ($result) {
                redirect(url('usermgr'), 2);
            }
        }
        
        $this->navtop->add(url('usermgr'), 'Back');
        $this->title = 'Add User';
        $this->header = '<h3>Add User</h3>';
        $this->status = $status;
        $this->status_error = $status_error;
        $this->content = $form;
        $this->render();        
    }
    
    function edit_user($args) {
        Auth::approve('edit users');
        import('app/class/admin/forms/EditUser_Form');
        import('app/class/admin/handlers/EditUser_Handler');
        
        $id = isset($args[0]) ? $args[0] : '';
        
        $this->links->add(stylesheet(asset('css/admin/forms.css')));
                
        $status = '';
        $status_error = '';
                
        $form = new EditUser_Form();
        $handler = new EditUser_Handler();
        
        if (is_postback()) {
            $result = $handler->onSubmit($form, $status, $status_error);
            if ($result) {
                redirect(url('usermgr'), 2);
            }
        }
        else {
            $handler->onLoad($form, $status, $status_error);
        }
        
        $this->navtop->add(url('usermgr/changepass', array($id)), 'Change Password');
        $this->navtop->add(url('usermgr'), 'Back');
        $this->title = 'Edit User';
        $this->header = '<h3>Edit User</h3>';
        $this->status = $status;
        $this->status_error = $status_error;
        $this->content = $form;
        $this->render();        
    }

    function delete_user($args) {
        Auth::approve('delete users');
        import('app/class/admin/handlers/DeleteUser_Handler');
        
        $status = '';
        $status_error = '';        
        
        $handler = new DeleteUser_Handler();
        $handler->onSubmit($status, $status_error);
        
        $this->navtop->add(url('usermgr'), 'Back');
        $this->title = 'Delete User';
        $this->header = '<br>';
        $this->status = $status;
        $this->status_error = $status_error;
        
        $this->render();                
    }

    function change_user_pass($args) {
        Auth::approve('edit users');
        import('app/class/admin/forms/ChangePassword_Form');
        import('app/class/admin/handlers/ChangePassword_Handler');
        
        $id = isset($args[0]) ? $args[0] : '';
        
        $this->links->add(stylesheet(asset('css/admin/forms.css')));
                
        $status = '';
        $status_error = '';
                
        $form = new ChangePassword_Form();
        $handler = new ChangePassword_Handler();
        
        if (is_postback()) {
            $result = $handler->onSubmit($form, $status, $status_error);
            if ($result) {
                redirect(url('usermgr'), 2);
            }
        }
        else {
            $handler->onLoad($form, $status, $status_error);
        }
        
        $this->navtop->add(url('usermgr/edit', array($id)), 'Back');
        $this->title = 'Change Password';
        $this->header = '<h3>Change Password</h3>';
        $this->status = $status;
        $this->status_error = $status_error;
        $this->content = $form;
        $this->render();                
    }    
    
}
