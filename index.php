<?php require_once 'conn.php';?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
        <link rel="stylesheet" href="css/style.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <title>Home Page</title>
    </head>
    <body>
        <div>
            <?php include_once './nav/nav.php'?>
        </div>
        <div class="container">
            <h1 class="main-body-h1">Welcome <br> <br> To <br> <br> Pizza Baker</h1>
        </div>
    </body>

    <?php include('footer.php'); ?>

</html>