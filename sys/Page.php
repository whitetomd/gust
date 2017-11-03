<?php

class Page extends Map {

    protected $path = '';

    public $metas = NULL;
    public $links = NULL;
    public $scripts = NULL;
    
    function __construct($path) {
        parent::__construct();
        $this->path = $path;
        $this->metas = new Set();
        $this->links = new Set();
        $this->scripts = new Set();
    }

    function setPath($path) {
        $this->path = $path;
    }
    
    function render() {      
        $path = $this->path;
        $metas = implode("\n", $this->metas->all()) . "\n";
        $links = implode("\n", $this->links->all()) . "\n";
        $scripts = implode("\n", $this->scripts->all()) . "\n";
        extract($this->all());
        include _DIR_ROOT_ . "/app/pages/$path";
    }
    
}
