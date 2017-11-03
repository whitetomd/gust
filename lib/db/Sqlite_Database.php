<?php

include 'Pdo_Database.php';

class Sqlite_Database extends Pdo_Database {
  
    function __construct($filepath) {
        $dsn = self::createDSN($filepath);
        $pdo = new PDO($dsn);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, FALSE);        
        parent::__construct($pdo);        
    }
    
    static function createDSN($filepath) {
        $dsn = '';
        $dsn .= "sqlite:$filepath";  
        return $dsn;        
    }
    
    function getTableNames() {
        $sql = "SELECT * FROM sqlite_master WHERE type='table'";
        $result = $this->execute($sql);
        $rows = $result->fetchAll(PDO::FETCH_ASSOC);
        $names = array();
        foreach ($rows as $row) {
            $names[] = $row['name'];
        }
        return $names;        
    }

    function getColumnNames($table_name) {
        $result = $this->execute("PRAGMA table_info($table_name)");
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $names = array();
        foreach ($result as $row) {
           $names[] = $row['name'];
        }        
        return $names;
    }    
}
