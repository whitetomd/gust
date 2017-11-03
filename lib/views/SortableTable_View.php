<?php

include 'Table_View.php';

class SortableTable_View extends Table_View {

    protected $sort_url = '';
    protected $direction = '';
    
    function __construct($columns, $data, $sort_url, $direction) {
        parent::__construct($columns, $data);
        $this->sort_url = $sort_url;
        $this->direction = $direction;
    }
    
    function columnHeading($name, $label) {
        $url = $this->sort_url . "/$name/" . $this->direction;
        $html = "<a href=\"$url\">$label</a>";       
        return parent::columnHeading($name, $html);
    }
    
}
