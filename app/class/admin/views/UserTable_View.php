<?php

import('lib/views/SortableTable_View');

class UserTable_View extends SortableTable_View {

    static $_columns = array(
        'email' => 'Email',
        'firstname' => 'First Name',
        'lastname' => 'Last Name'
    );
    
    function __construct($data, $direction) {
        parent::__construct(self::$_columns, $data, url('usermgr'), $direction);
        $this->attributes->add('class', 'usertable-view');
    }
    
    function column($name, $value) {
        $html = $value;
        $user = new User();
        $key = $user->getIdKey();
        if ($name === $key) {
            $html = '';
            $url_delete = url('usermgr/delete', array($value));
            $onclick = "return confirm('Are you sure you want to delete this user?');";
            $html .= "<a href=\"$url_delete\" onclick=\"$onclick\" class=\"lnk-delete\">&#10006;</a>";
            $url_edit = url('usermgr/edit', array($value));
            $html .= "<a href=\"$url_edit\" class=\"lnk-edit\">$value</a>";
        }
        return parent::column($name, $html);
    }
}
