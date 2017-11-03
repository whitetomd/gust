<?php

    $app = App::instance();

/******************** Main Site Routes ********************/
    $app->routes->add('/',        array('site/default_controller', 'index')   );
    $app->routes->add('/home',    array('site/default_controller', 'index')   );
    $app->routes->add('/about',   array('site/default_controller', 'about')   );
    $app->routes->add('/contact', array('site/default_controller', 'contact') );


/******************** Admin Routes ********************/    
    $app->routes->add('/admin', array('admin/admin_controller', 'index'));
    $app->routes->add('/login', array('admin/admin_controller', 'login'));
    $app->routes->add('/logout', array('admin/admin_controller', 'logout'));
    
    // User manager routes
    $app->routes->add('/usermgr', array('admin/usermgr_controller', 'index'));
    $app->routes->add('/usermgr/add', array('admin/usermgr_controller', 'add_user'));
    $app->routes->add('/usermgr/edit', array('admin/usermgr_controller', 'edit_user'));
    $app->routes->add('/usermgr/delete', array('admin/usermgr_controller', 'delete_user'));
    $app->routes->add('/usermgr/changepass', array('admin/usermgr_controller', 'change_user_pass'));
    
    
    $app->routes->add('/test', array('test/test_controller', 'index') );