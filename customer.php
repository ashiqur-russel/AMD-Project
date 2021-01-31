<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <title>Ingredient Page</title>
</head>

<body>
    <?php 
include_once './nav/nav.php';
require_once './conn.php';

$item = [];

$sql = "SELECT * FROM fetch_all_pizza()";
$pizza_list = pg_query($db, $sql);

$sql = "SELECT * FROM fetch_all_ingredient_detail()";
$ingredient_list = pg_query($db, $sql);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //checking type of form posting; $_POST['submit'] means its called from New Entry form
    if (isset($_POST['submit'])) {
        $pizza_id = $_POST['id'];
        $pizza_size = $_POST['pizza_size'.$pizza_id];
        $pizza_price = $_POST['pizza_price'.$pizza_id];

        $item[] = array("name" => $pizza_size, "price" => $pizza_price);
    }
}
?>

    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <form method="POST">
                    <table class="table table-striped">
                        <thead>
                            <th></th>
                            <th>Pizza Size</th>
                            <th>Price</th>
                        </thead>
                        <tbody>
                        <?php
                        while($row = pg_fetch_assoc($pizza_list)){ ?>
                            <tr>
                                <td><input type="checkbox" class="chk" value="<?php echo $row['id']; ?>" name="id"></td>
                                <td><input type="hidden" name="<?php echo 'pizza_size'.$row['id']; ?>" value="<?php echo $row['size']; ?>"><?php echo $row['size']; ?></td>
                                <td><input type="hidden" name="<?php echo 'pizza_price'.$row['id']; ?>" value="<?php echo $row['price']; ?>"><?php echo $row['price']; ?></td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                    <br>
                    <input type="submit" name="submit" value="Submit" onclick="getdata()">

                    <table class="table table-striped">
                        <thead>
                            <th></th>
                            <th>Ingredient Name</th>
                            <th>Province</th>
                            <th>Price</th>
                        </thead>
                        <tbody>
                            <?php
                            while($row = pg_fetch_assoc($ingredient_list)){ ?>
                            <tr>
                                <td><input type="checkbox" value="<?php echo $row['id']; ?>" name="id[]"></td>
                                <td><?php echo $row['name']; ?></td>
                                <td><?php echo $row['province']; ?></td>
                                <td><?php echo $row['price']; ?></td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </form>
            </div>
            <!-- order list will appear from here -->
            <div class="col-md-6">
                <div id=" tbl-header">
                    <h2 style="color:Black;text-align: center;">Order List</h2>
                </div>
                <div id="order-show-table">
                    <table class="table table-striped">
                        <thead>
                            <th>#</th>
                            <th>Item</th>
                            <th>Price</th>
                        </thead>
                        <tbody>
                            <?php
                            $count = 1;
                            foreach ($item as $row) { ?>
                            <tr>
                                <td><?php echo $count; ?></td>
                                <td><?php echo $row['name']; ?></td>
                                <td><?php echo $row['price']; ?></td>
                            </tr>
                            <?php $count++; } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }
        $('input.chk').on('change', function () {
            $('input.chk').not(this).prop('checked', false);
        });
        
    </script>

</body>

</html>