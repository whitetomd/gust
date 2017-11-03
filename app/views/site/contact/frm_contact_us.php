<form method="post" style="padding: 16px;">
    
    <table>
        
        <tr>
            <td>Text:</td>
            <td><?php echo $text; ?></td>
            <td><?php echo $text->message; ?></td>
        </tr>
        
        <tr>
            <td>Checkbox:</td>
            <td><?php echo $checkbox; ?></td>
            <td><?php echo $checkbox->message; ?></td>
        </tr>        
        
        <tr>
            <td>Combobox:</td>
            <td><?php echo $combobox; ?></td>
            <td><?php echo $combobox->message; ?></td>
        </tr>        

        <tr>
            <td>File:</td>
            <td><?php echo $file; ?></td>
            <td><?php echo $file->message; ?></td>
        </tr>
        
        <tr>
            <td>Password:</td>
            <td><?php echo $password; ?></td>
            <td><?php echo $password->message; ?></td>
        </tr>
        
        <tr>
            <td>Radio:</td>
            <td><?php echo $radio; ?></td>
            <td><?php echo $radio->message; ?></td>
        </tr>
        
        <tr>
            <td>Select:</td>
            <td><?php echo $select; ?></td>
            <td><?php echo $select->message; ?></td>
        </tr>
        
        <tr>
            <td>Text Area:</td>
            <td></td>
            <td><?php echo $textarea->message; ?></td>
        </tr>

        <tr>
            <td colspan="2"><?php echo $textarea; ?></td>
            <td></td>
        </tr>
        
    </table>
    
    <input type="submit" value="Submit">
    
</form>
