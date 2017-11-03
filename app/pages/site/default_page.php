<!DOCTYPE html>

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
                
        <div id="content">
            <?php echo isset($content) ? $content : ''; ?>
        </div>
        
        <div id="footer">
            <?php echo isset($footer) ? $footer : ''; ?>
        </div>
        
    </body>
    
</html>
