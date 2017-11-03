<?php

function _pubvars_($obj) {
    return get_object_vars($obj);
}

class DataStruct {

    private $properties = array();

    function hasKey($key) {
        return array_key_exists($key, _pubvars_($this));
    }

    function getKeys() {
        return array_keys(_pubvars_($this));
    }

    function getValues() {
        return array_values(_pubvars_($this));
    }

    function __set($key, $value) {
        if ($this->hasKey($key)) {
            $this->$key = $value;
        } else {
            throw new Exception("key \"$key\" does not exist");
        }
    }

    function __get($key) {
        if ($this->hasKey($key)) {
            return $this->$key;
        } else {
            throw new Exception("key \"$key\" does not exist");
        }
    }

    function setData($assoc_array) {
        $keys = $this->getKeys();
        foreach ($keys as $key) {
            if (isset($assoc_array[$key])) {
                $this->$key = $assoc_array[$key];
            }
        }
    }

    function getData() {
        return _pubvars_($this);
    }
    
    function hasProperty($key, $name) {
        if ($this->hasKey($key)) {
            if (isset($this->properties[$key]) && isset($this->properties[$key][$name])) {
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            throw new Exception("key \"$key\" does not exist");
        }        
    }
    
    function setProperty($key, $name, $value) {
        if ($this->hasKey($key)) {
            if (!isset($this->properties[$key])) {
                $this->properties[$key] = array();
            }
            $this->properties[$key][$name] = $value;
        } else {
            throw new Exception("key \"$key\" does not exist");
        }
    }

    function getProperty($key, $name) {
        if ($this->hasKey($key)) {
            if (isset($this->properties[$key]) && isset($this->properties[$key][$name])) {
                return $this->properties[$key][$name];
            } else {
                throw new Exception("property \"$name\" does not exist");
            }
        } else {
            throw new Exception("key \"$key\" does not exist");
        }
    }

    function getProperties($key) {
        if ($this->hasKey($key)) {
            return isset($this->properties[$key]) ? $this->properties[$key] : array();
        } else {
            throw new Exception("key \"$key\" does not exist");
        }
    }

    function toJSON() {
        return json_encode($this->getData(), TRUE);
    }

    function propertiesToString($key) {
        $s = '';
        $properties = $this->getProperties($key);
        foreach ($properties as $name => $value) {
            $s .= "$name=\"$value\" ";
        }
        return rtrim($s);
    }

}
