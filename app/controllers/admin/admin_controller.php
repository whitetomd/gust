<?php

import('lib/views/Navigation_View');
import('app/class/admin/auth/Auth');
import('app/class/admin/models/User');

class admin_controller extends Page {
        
    function __construct() {
        parent::__construct('admin/default_page.php');
        $this->links->add(stylesheet(asset('css/admin/page.css')));
        $this->add('navtop', new Navigation_View());
    }
    
    function index($args) {
        Auth::approve();
        $this->title = 'Admin';
        $this->navtop->add(url('usermgr'), 'User Manager');
        $this->navtop->add(url('logout'), 'Logout');
        $this->content = '<h2>Admin Page</h2>';
        $this->render();
    }
    
    function login($args) {     

        $user = new User();
        $user->fetchLoggedIn();
        
        $this->links->add(stylesheet(asset('css/admin/forms.css')));
        
        if (is_postback()) {
            try {
                $user = new User();
                $result = $user->login($_POST['email'], $_POST['password']);
                if ($result) { 
                    $route = isset($args[0]) ? $args[0] : 'admin';
                    $url = url($route);                
                    $this->status = 'Login successful, please wait...';
                    redirect($url, 2);
                }
                else {
                    $this->status_error = 'Invalid login credentials';
                }
            }
            catch (Exception $ex) {
                $errcode = $ex->getCode();
                $errmsg = $ex->getMessage();
                $this->status_error = "ERROR #$errcode: $errmsg";
            }
        }
        
        $this->title = 'Login';
        $this->content = View::render('admin/forms/frm_login.php');
        $this->render();
    }
    
    function logout($args) {
        try {
            $user = new User();
            $user->logout();            
            redirect(url(''), 2);
            echo "<b style=\"color: green;\">Logout successful, please wait...</b>";
        } catch (Exception $ex) {
            $errcode = $ex->getCode();
            $errmsg = $ex->getMessage();
            die("<b style=\"color: #cc0000;\">ERROR #$errcode: $errmsg</b>");
        }
    }
    
}
