<form method="post">

    <?php echo $email; ?>
    
    <table>
        
        <tr>
            <td>First name:</td>
            <td><?php echo $firstname; ?></td>
            <td><?php echo $firstname->message; ?></td>
        </tr>
        
        <tr>
            <td>Last name:</td>
            <td><?php echo $lastname; ?></td>
            <td><?php echo $lastname->message; ?></td>         
        </tr>

        <tr><td colspan="3">&nbsp;</td></tr>
                
        <tr>
            <td colspan="2">Privileges:</td>
            <td></td>
            <td><?php echo $privileges->message; ?></td>
        </tr>

        <tr>     
            <td></td>
            <td colspan="2">
                <?php echo $privileges; ?>
            </td>                        
        </tr>
        
    </table>

    <input type="submit" value="Update"/>

</form>

<script>document.getElementsByName('firstname')[0].focus();</script>
