<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <title>Order Page</title>
</head>

<body>

    <?php
    include_once './nav/nav.php';
    require_once './conn.php';

    $order_list = [];

    $sql = "SELECT * FROM fetch_all_order()";
    $order_list = pg_query($db, $sql);

    ?>
    <div class="container">
        <div class="col-md-12">
            <h2 style="text-align: center">View Order List</h2>
        </div>

        <div class="internal-div">

            <table class="table table-striped">
                <tr>
                    <th>Id</th>
                    <th>Pizza Size</th>
                    <th>Ingredients</th>
                    <th>Pizza Price</th>
                    <th>Ingredients Price</th>
                    <th>Total Price</th>
                </tr>

                <tbody>
                    <?php
                    while ($item = pg_fetch_assoc($order_list)) { ?>
                        <tr>
                            <td><?php echo $item['id']; ?></td>
                            <td><?php echo $item['pizza_size']; ?></td>
                            <td><?php echo $item['ingredients']; ?></td>
                            <td><?php echo $item['pizza_price']; ?></td>
                            <td><?php echo $item['ing_price']; ?></td>
                            <td><?php echo $item['total_price']; ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

<?php include('footer.php'); ?>

</html>