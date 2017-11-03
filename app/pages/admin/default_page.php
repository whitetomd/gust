<!DOCTYPE html>

<?php $status = isset($status) ? $status : ''; ?>
<?php $status_error = isset($status_error) ? $status_error : ''; ?>

<html>
    
    <head>
        <meta charset="UTF-8">
        <title><?php echo isset($title) ? $title : '[Untitled]'; ?></title>
        <?php echo $links; ?>
        <?php echo $scripts; ?>    
    </head>
    
    <body>
                
        <div id="navtop">
            <?php echo isset($navtop) ? $navtop : ''; ?>
        </div>
        
        <div id="header">
            <?php echo isset($header) ? $header : ''; ?>
        </div>
        
        <?php if (!empty($status)) { ?><div class="status"><?php echo $status; ?></div><?php } ?>
        <?php if (!empty($status_error)) { ?><div class="status-error"><?php echo $status_error; ?></div><?php } ?>        
        
        <div id="content">
            <?php echo isset($content) ? $content : ''; ?>
        </div>
        
        <div id="footer">
            <?php echo isset($footer) ? $footer : ''; ?>
        </div>
        
    </body>
    
</html>
