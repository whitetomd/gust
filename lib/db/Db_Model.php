<?php

include_once 'DataStruct.php';

abstract class Db_Model extends DataStruct {
    
    private $tablename = '';
    private $id_key = '';
    
    function __construct($tablename, $id_key) {
        $this->tablename = $tablename;
        $this->id_key = $id_key;
    }

    abstract function getDb();
            
    function getTableName() {
        return $this->tablename;
    }
    
    function getIdKey() {
        return $this->id_key;
    }
    
    function getId() {
        $idkey = $this->getIdKey();
        return $this->$idkey;
    }
    
    function createTable() {                
        $db = $this->getDb();
        $db->createTable($this->getTableName(), $this->getFieldData());
    }
    
    function getFieldData() {
        $keys = $this->getKeys();
        $fields = array();
        foreach ($keys as $key) {
            $fields[$key] = array();
            $fields[$key]['type'] = $this->getProperty($key, 'type');
            if ($this->hasProperty($key, 'options')) {
                $fields[$key]['options'] = $this->getProperty($key, 'options');
            }
        }
        return $fields;
    }
    
    function select($where = '', $orderBy = '', $sortDir = '', $limit = FALSE) {
        $db = $this->getDb();
        $tablename = $this->getTableName();
        return $db->select($tablename, $where, $orderBy, $sortDir, $limit);
    }
    
    function fetch($id) {
        $db = $this->getDb();     
        $data = $db->findOne($this->getTableName(), $this->getIdKey(), $id);
        if ($data !== FALSE) {
            $this->setData($data);
            return TRUE;
        }
        return FALSE;
    }
    
    function find($key, $value) {
        $db = $this->getDb();     
        $data = $db->findOne($this->getTableName(), $key, $value);
        if ($data !== FALSE) {
            $this->setData($data);
            return TRUE;
        }
        return FALSE;
    }
    
    function create($args) {
        $db = $this->getDb();
        $db->create($this->getTableName(), $this->getData());
    }

    function update() {
        $db = $this->getDb();
        $data = $this->getData();
        $keyid = $this->getIdKey();
        $db->update($this->getTableName(), $keyid, $data[$keyid], $data);
    }    
    
    function delete() {
        $db = $this->getDb();
        $data = $this->getData();
        $keyid = $this->getIdKey();
        $db->delete($this->getTableName(), $keyid, $data[$keyid]);
    }    
    
}
