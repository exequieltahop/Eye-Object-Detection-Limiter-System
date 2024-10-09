<!-- session handler -->
<?php  
    require __DIR__.'/./service-provider/general/session.php';
    require __DIR__.'/./service-provider/general/session-route-logic.php'; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- set dynamic title -->
    <title>
        <?php
            if(SessionHas('Title')){
                echo Session('Title');
            }else{
                echo 'App';
            }
        ?>
    </title>
    <!-- bs -->
    <link rel="stylesheet" href="./public/css/bootstrap.min.css">
    <!-- Alertify js -->
    <script src="./public/alertifyjs/alertify.min.js"></script>
    <link rel="stylesheet" href="./public/alertifyjs/css/alertify.min.css">
    <link rel="stylesheet" href="./public/alertifyjs/css/themes/default.min.css">
    <!-- favicon -->
    <link rel="shortcut icon" href="./public/favicon_io/favicon.ico" type="image/x-icon">
    <!-- script http requests -->
    <script src="./public/js/HTTP_REQUEST.js"></script>
</head>
<body class="bg-light">
    <!-- include route -->
    <?php
        require __DIR__.'/route/web.php';
    ?>
</body>
</html>