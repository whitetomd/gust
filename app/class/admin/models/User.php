<?php

import('lib/db/Db_Model');
import('lib/util/PasswordHasher');

class User extends Db_Model {
    
    const LOGIN_KEY = '@@_LOGGED_IN_USER_@@';
    
    public $firstname = '';
    public $lastname = '';
    public $email = '';
    public $hashword = FALSE;
    public $privileges = 0;
    
    private static $dbpath = "app/data/users.db";
    
    function __construct() {
        parent::__construct('users', 'email');
        $this->setProperty('firstname', 'type', 'varchar(128)');
        $this->setProperty('lastname', 'type', 'varchar(128)');
        $this->setProperty('email', 'type', 'varchar(256)');
        $this->setProperty('email', 'options', 'NOT NULL PRIMARY KEY');
        $this->setProperty('hashword', 'type', 'varchar(256)');
        $this->setProperty('privileges', 'type', 'int');
    }
    
    function getDb() {        
        return db_sqlite(_DIR_ROOT_ . '/' . self::$dbpath);
    }
    
    function create($password) {
        $user = new User();
        $key = $this->getIdKey();
        $id = $this->$key;
        if ($user->fetch($id)) {
            throw new Exception('User already exists', 1);
        }
        $this->setPassword($password);
        parent::create(NULL);
    }
    
    function setPassword($password) {        
        $hasher = new PasswordHasher();
        $this->hashword = $hasher->create($password);
    }

    function hasPrivilege($privilege) {
        if (intval($privilege) & intval($this->privileges)) {
            return TRUE;
        }
        return FALSE;
    }
    
    function login($id, $password) {
        $result = $this->fetch($id);
        if (!$result) { return FALSE; }
        $hasher = new PasswordHasher();
        $result = $hasher->check($password, $this->hashword);
        if (!$result) { return FALSE; }
        $_SESSION[self::LOGIN_KEY] = $this->getData();
        return TRUE;
    }
    
    function logout() {
        if (isset($_SESSION[self::LOGIN_KEY])) {
            unset($_SESSION[self::LOGIN_KEY]);
            return TRUE;
        }
        return FALSE;
    }
    
    function fetchLoggedIn() {
        if (isset($_SESSION[self::LOGIN_KEY])) {
            $this->setData($_SESSION[self::LOGIN_KEY]);
            return TRUE;
        }
        return FALSE;
    }
        
}
