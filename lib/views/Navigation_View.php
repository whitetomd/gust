<?php

class Navigation_View extends View {

    function __construct() {
        parent::__construct('');
    }
        
    function open() {
        return '<ul>';
    }
        
    function link($url, $caption) {
        return "<li><a href=\"$url\">$caption</a></li>";
    }
    
    protected function links() {
        $html = '';
        $items = $this->all();
        foreach ($items as $url=>$caption) {
            $html .= $this->link($url, $caption);
        }
        return $html;
    }
    
    function close() {
        return '</ul>';
    }
    
    function __toString() {
        $html = '';
        $html .= $this->open();
        $html .= $this->links();
        $html .= $this->close();
        return $html;
    }
}
