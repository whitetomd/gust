<?php

class Pdo_Database {

    const DEFAULT_CHARSET = 'utf8';
    const DEFAULT_COLLATION = 'utf8_general_ci';
      
    protected $pdo;
      
    function __construct($pdo) {
        $this->pdo = $pdo;
    }
    
    function execute($statement, $data=array()) {
        $_statement = NULL;
        
        if ($statement instanceof PDOStatement) {            
            $_statement = $statement;                        
        }
        else {            
            //echo $statement . '<br>';
            $_statement = $this->pdo->prepare('' . $statement);
        }
        
        //echo $_statement->queryString . '<br>';
        
        $_statement->execute($data);        
        return $_statement;        
    }
    
    function create($table, $data) {
        $cols = '(';
        $vals = '(';
        foreach ($data as $fname => $value) {
            $cols .= "$fname,";
            $vals .= ":$fname,";
        }
        $cols = rtrim($cols, ',');
        $vals = rtrim($vals, ',');
        $cols .= ')';
        $vals .= ')';
        $stmt = "INSERT INTO $table $cols VALUES $vals";
        $this->execute($stmt, $data);        
    }

    function update($table, $key, $id, $data) {
                
        $stmt = "UPDATE $table SET ";
        
        foreach ($data as $fname => $value) {
            $stmt .= "$fname = :$fname,";
        }
        
        $stmt = rtrim($stmt, ',');
        $stmt .= " WHERE $key = '$id'";

        $this->execute($stmt, $data);        
    }
    
    function delete($table, $key, $id) {
        //echo "DELETING WHERE $key === $id FROM TABLE $table...<br>";
        $stmt = "DELETE FROM $table ";
        $stmt .= " WHERE $key=:$key";
        $this->execute($stmt, array($key => $id));        
    }
    
    function findOne($table, $key, $value) {
        $sql = "SELECT * FROM $table WHERE $key=:$key LIMIT 1";
        $stmt = $this->execute($sql, array($key => $value));        
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        if (is_array($result) && count($result) > 0) {            
            return $result[0];        
        }
        else {
            return FALSE;
        }        
    }

    function select($table, $where = '', $orderBy = '', $sortDir = '', $limit = FALSE) {
        $sql = "SELECT * FROM $table";
        
        if (!empty($where)) {
            $sql .= " WHERE $where";
        }

        if (!empty($orderBy)) {
            $sql .= " ORDER BY $orderBy";
            if (!empty($sortDir)) {
                $sql .= " $sortDir";
            }
        }

        if ($limit) {
            $sql .= " LIMIT $limit";
        }

        //echo "$sql<br>";
        
        $stmt = $this->execute($sql);
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
        
    }

    /* example:
     * $fields = array(
     *     'id' => array('type'=>'int', 'options'=>'AUTO INCREMENT'),
     *     'firstname' => array('type'=>'varchar(128)', 'options'=>'NOT NULL'),
     *     'lastname' => array('type'=>'varchar(128)', 'options'=>'NOT NULL'),
     *     'birthdate' => array('type'=>'date', 'options'=>'NOT NULL')
     * );
     */
    function createTable($table_name, $fields) {
        $stmt = "CREATE TABLE $table_name(";        
        foreach ($fields as $field_name=>$field_data) {            
            $type = $field_data['type'];
            $options = isset($field_data['options']) ? $field_data['options'] : '';            
            $stmt .= "$field_name $type $options,";
        } 
        $stmt = rtrim($stmt, ',');
        $stmt .= ')';
        $this->execute($stmt);        
    }
    
}
