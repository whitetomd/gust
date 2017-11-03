<?php

class PrivilegesInput extends Form_Input {
    
    function __construct($privileges) {
        parent::__construct('privileges', 'user_defined', $privileges);
    }    
        
    private function script_onclick() {
        $my_name = $this->name;
return <<<JS
<script>
    function privilege_checkbox_onclick(checkbox) {
        var elem = document.getElementById('id-$my_name');
        var val = parseInt(elem.value);
        if (checkbox.checked) { 
            val |= parseInt(checkbox.value); 
        } 
        else { 
            val &= ~parseInt(checkbox.value); 
        }
        elem.value = '' + val;
    }
</script>
JS;
    }
    
    function render() {
        
        $my_name = $this->name;
        $my_value = $this->value;
        
        $hidden = "<input name=\"$my_name\" id=\"id-$my_name\" type=\"hidden\" value=\"$my_value\">";
        
        $options = $this->options->all();
        
        $checkboxes = '<table>';
        foreach ($options as $key=>$value) {
            $checkboxes .= "<tr>\n";
            $checkboxes .= "<td>";
            $checkboxes .= "$key";
            $checkboxes .= "</td>\n";
            $checkboxes .= "<td>";
            $onclick = 'privilege_checkbox_onclick(this);';
            
            if (intval($my_value) & intval($value)) {
                $checkboxes .= "<input type=\"checkbox\" checked=\"checked\" onclick=\"$onclick\" value=\"$value\">";
            }
            else {
                $checkboxes .= "<input type=\"checkbox\" onclick=\"$onclick\" value=\"$value\">";
            }
            
            $checkboxes .= "</td>\n";            
            $checkboxes .= "</tr>\n";
        }
        
        $checkboxes .= '</table>';
        
        $script = $this->script_onclick();
        
        return $script . "\n" . $hidden . "\n" . $checkboxes;
    }
}
