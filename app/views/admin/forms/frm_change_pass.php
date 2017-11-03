<form method="post">
    
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

        <tr>
            <td>Email:</td>
            <td><?php echo $email; ?></td>
            <td><?php echo $email->message; ?></td>              
        </tr>

        <tr>
            <td>Password:</td>
            <td><?php echo $password; ?></td>
            <td><?php echo $password->message; ?></td>                
        </tr>

        <tr>
            <td>Repeat:</td>
            <td><?php echo $repeat; ?></td>
            <td><?php echo $repeat->message; ?></td>
        </tr>
        
    </table>

    <br>
    <input type="submit" value="Change"/>

</form>

<script>document.getElementsByName('password')[0].focus();</script>
