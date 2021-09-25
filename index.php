<!DOCTYPE html>
<?php
   include 'includes/auto_loader.php';
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Book Catalog</title>
        <link rel="stylesheet" type="text/css" href="style.css" />
    </head>
    <body>
        
            <?php
                $data = new Data();
                $data->getInfo();
            ?>
            
    </body>
</html>
