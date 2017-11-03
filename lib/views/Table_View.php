<?php

class Table_View extends View {

    protected $columns = array();
    protected $data = array();
    
    public $attributes = NULL;

    function __construct($columns, $data) {
        parent::__construct('');
        $this->columns = $columns;
        $this->data = $data;
        $this->attributes = new Map();
    }
    
    function open() {
        $html = '<table';
        
        $attributes = $this->attributes->all();
        
        foreach ($attributes as $key=>$value) {
            $html .= " $key=\"$value\"";
        }
        
        $html .= '>';
        return "$html\n";
    }
        
    function columnHeading($name, $label) {
        $html = '<th>';        
        $html .= $label;        
        $html .= '</th>';
        return $html;
    }
    
    function columnHeadings() {
        $html = '';
        foreach ($this->columns as $name=>$label) {
            $html .= $this->columnHeading($name, $label);
        }
        return "$html\n";
    }
            
    function column($name, $value) {
        $html = "<td>$value</td>";
        return $html;
    }
    
    function row($data) {
        $html = '';        
        foreach ($this->columns as $name=>$label) {             
            if (isset($data[$name])) {
                $html .= $this->column($name, $data[$name]);
            }
        }
        return "$html\n";
    }
    
    function rows($data) {
        $html = '';     
        //var_dump($data);
        foreach ($data as $row) {
            $html .= "<tr>\n";
            $html .= $this->row($row);
            $html .= "</tr>\n";
        }
        return $html;
    }
    
    function close() {
        $html = '</table>';
        return "$html\n";
    }
    
    function __toString() {
        return $this->open() . $this->columnHeadings() . $this->rows($this->data) . $this->close();
    }
}
