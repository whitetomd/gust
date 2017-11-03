<?php

class Sanitize extends Anonymous {

    function __construct($function, $data = array()) {
        parent::__construct($this, $function, $data);
    }
    
    function clean($input) {
        return $this->call($input);
    }
    
    protected static function utf8_decode($input) {
        return strtr($input, "???????Â¥ÂµÃ€ÃÃ‚ÃƒÃ„Ã…Ã†Ã‡ÃˆÃ‰ÃŠÃ‹ÃŒÃÃŽÃÃÃ‘Ã’Ã“Ã”Ã•Ã–Ã˜Ã™ÃšÃ›ÃœÃÃŸÃ Ã¡Ã¢Ã£Ã¤Ã¥Ã¦Ã§Ã¨Ã©ÃªÃ«Ã¬Ã­Ã®Ã¯Ã°Ã±Ã²Ã³Ã´ÃµÃ¶Ã¸Ã¹ÃºÃ»Ã¼Ã½Ã¿", "SOZsozYYuAAAAAAACEEEEIIIIDNOOOOOOUUUUYsaaaaaaaceeeeiiiionoooooouuuuyy");
    }

// paranoid sanitization -- only let the alphanumeric set through
    function sanitizeParanoid($input) {
        $_input = self::utf8_decode($input);
        return preg_replace("/[^a-zA-Z0-9]/", "", $_input);
    }

//strip: strips out javascript, html tags, style tags, and multiline comments
    function sanitizeStripped($input) {
        $_input = self::utf8_decode($input);
        $search = array(
            '@<script[^>]*?>.*?</script>@si', // Strip out javascript
            '@<[\/\!]*?[^<>]*?>@si', // Strip out HTML tags
            '@<style[^>]*?>.*?</style>@siU', // Strip style tags properly
            '@<![\s\S]*?--[ \t\n\r]*>@'         // Strip multi-line comments            
        );
        return preg_replace($search, '', $_input);
    }

// sanitize a string for SQL input (simple slash out quotes and slashes)
    function sanitizeSql($input) {
        $_input = self::utf8_decode($input);
        $_input = addslashes($input); //gz
        $pattern = "/;/"; // jp
        return preg_replace($pattern, "", $_input);
    }

// sanitize a string for HTML (make sure nothing gets interpretted!)
    function sanitizeHtml($input) {
        $_input = self::utf8_decode($input);
        $pattern[0] = '/\&/';
        $pattern[1] = '/</';
        $pattern[2] = "/>/";
        $pattern[3] = '/\n/';
        $pattern[4] = '/"/';
        $pattern[5] = "/'/";
        $pattern[6] = "/%/";
        $pattern[7] = '/\(/';
        $pattern[8] = '/\)/';
        $pattern[9] = '/\+/';
        $pattern[10] = '/-/';
        $replacement[0] = '&amp;';
        $replacement[1] = '&lt;';
        $replacement[2] = '&gt;';
        $replacement[3] = '<br>';
        $replacement[4] = '&quot;';
        $replacement[5] = '&#39;';
        $replacement[6] = '&#37;';
        $replacement[7] = '&#40;';
        $replacement[8] = '&#41;';
        $replacement[9] = '&#43;';
        $replacement[10] = '&#45;';
        return preg_replace($pattern, $replacement, $_input);
    }

// make int int!
    function sanitizeInt($input) {
        $_input = self::utf8_decode($input);
        return intval($_input);
    }

// make float float!
    function sanitizeFloat($input) {
        $_input = self::utf8_decode($input);
        return floatval($_input);
    }

// sanitize an email using php's email filter
    function sanitizeEmail($input) {
        $_input = self::utf8_decode($input);
        return filter_var($_input, FILTER_SANITIZE_EMAIL);
    }

// sanitize a url using php's url filter
    function sanitizeUrl($input) {
        $_input = self::utf8_decode($input);
        return filter_var($_input, FILTER_SANITIZE_URL);
    }

// sanitize by removing disallowed (blacklisted) words
    function sanitizeBlacklist($input) {
        $_input = $input;
        $blacklist = $this->data['blacklist'];
        foreach ($blacklist as $word) {
            $_input = str_ireplace($word, '', $_input);
        }
        return $_input;
    }
    
    static function paranoid() {
        return new Sanitize('sanitizeParanoid');        
    }
    
    static function stripped() {
        return new Sanitize('sanitizeStripped');        
    }
    
    static function sql() {
        return new Sanitize('sanitizeSql');        
    }    
    
    static function html() {
        return new Sanitize('sanitizeHtml');        
    }
    
    static function int() {
        return new Sanitize('sanitizeInt');        
    }
    
    static function float() {
        return new Sanitize('sanitizeFloat');        
    }
    
    static function email() {
        return new Sanitize('sanitizeEmail');        
    }

    static function url() {
        return new Sanitize('sanitizeUrl');        
    }
    
    static function blacklist($blacklist) {
        return new Sanitize('sanitizeBlacklist', array('blacklist' => $blacklist));        
    }    
}
