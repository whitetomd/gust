<?php

include 'Pdo_Database.php';

class Mysql_Database extends Pdo_Database {
    
    function __construct($username, $password, $config) {
        
        $db_name = $config['db_name'];
        $charset = $config['charset'];
        $collation = $config['collation'];
        $host = $config['host'];        
        $port = $config['port'];        
        
        $dsn = $this->createDSN($host, $port, $db_name, $charset);
        $pdo = new PDO($dsn, $username, $password, array());
        $pdo->setAttribute(PDO::ATTR_AUTOCOMMIT, TRUE);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, FALSE); 
                
        parent::__construct($pdo);
        
        $sql = "SET NAMES $charset COLLATE $collation";
        $this->execute($sql);        
    }
    
    static function createDSN($host, $port, $dbname, $charset) {        
        $dsn = '';
        $dsn .= "mysql:";        
        $dsn .= "host=$host;";
        $dsn .= "port=$port;";
        $dsn .= "charset=$charset;";
        $dsn .= "dbname=$dbname;";        
        return $dsn;        
    }
    
    function getTableNames() {
        $sql = 'SHOW TABLES';
        $result = $this->pdo->query($sql);
        return $result->fetchAll(PDO::FETCH_COLUMN);        
    }

    function getColumnNames($table_name) {
        $columns = array();
        $rs = $this->pdo->query("SELECT * FROM $table_name LIMIT 0");
        for ($i = 0; $i < $rs->columnCount(); $i++) {
            $col = $rs->getColumnMeta($i);
            $columns[] = $col['name'];
        }
        return $columns;        
    }    
}
