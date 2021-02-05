<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <title>Ingredient Page</title>
</head>

<body>
    <?php
        include_once './nav/nav.php';
        require_once './conn.php';

        $cart = [];
        $result = null;
        $pizza_size = '';
        $ingredients = '';
        $pizza_price = '';
        $total_ing_price = 0;
        $total_order_price = 0;

        $sql = "SELECT * FROM fetch_all_pizza()";
        $pizza_list = pg_query($db, $sql);

        $sql = "SELECT * FROM fetch_all_ingredient_detail()";
        $ingredient_list = pg_query($db, $sql);

        $json = json_decode(file_get_contents('cart.json'), true);

        if (!empty($json)) {
            $cart = $json;
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (isset($_POST['submit'])) {
                $pizza_id = $_POST['pizza_id'];
                $p_size = $_POST['pizza_size' . $pizza_id];
                $p_price = $_POST['pizza_price' . $pizza_id];

                if (!empty($json)) {
                    $cart = [];
                }

                $cart_item = array("pizza" => $p_size, "price" => $p_price);
                $cart[] = $cart_item;
                file_put_contents('cart.json', json_encode($cart));
            }

            if (isset($_POST['add_ingredient'])) {
                foreach ($_POST['ing_id'] as $ing_id) {
                    $ing_name = $_POST['ing_name' . $ing_id];
                    $ing_province = $_POST['ing_province' . $ing_id];
                    $ing_price = $_POST['ing_price' . $ing_id];

                    $cart_item = array("id" => $ing_id, "ing" => $ing_name . ' (' . $ing_province . ')', "price" => $ing_price);
                    array_push($cart, $cart_item);
                    file_put_contents('cart.json', json_encode($cart));
                }
            }

            if (isset($_POST['order'])) {
                foreach ($cart as $item) {
                    if (!empty($item['pizza'])) {
                        $pizza_size = $item['pizza'];
                        $pizza_price = $item['price'];
                    }
                    if (!empty($item['ing'])) {
                        if ($ingredients != '') $ingredients .= ', ';
                        $ingredients .= $item['ing'];
                        $total_ing_price += $item['price'];

                        $ing_id = $item['id'];
                        $sql = "SELECT update_ingredient_quantity($ing_id)";
                        $result = pg_query($db, $sql);
                    }
                }
                $total_order_price = $pizza_price + $total_ing_price;

                $sql = "SELECT add_order($pizza_size, '$ingredients', $pizza_price, $total_ing_price, $total_order_price)";
                $result = pg_query($db, $sql);

                $cart = [];
                file_put_contents('cart.json', json_encode($cart));
            }
        }
        ?>

    <div class="container">
        <div class="row">
             <div class="col-md-12">
            <h2 style="text-align: center">Order Pizza</h2>
            </div>
            <div class="col-md-6 internal-div2">
                <form method="POST" style="margin-bottom: 20px;">
                    <table class="table table-striped">
                        <thead>
                            <th></th>
                            <th>Pizza Size</th>
                            <th>Price</th>
                        </thead>
                        <tbody>
                            <?php
                            while ($row = pg_fetch_assoc($pizza_list)) { ?>
                                <tr>
                                    <td><input type="checkbox" class="chk" value="<?php echo $row['id']; ?>" name="pizza_id"></td>
                                    <td><input type="hidden" name="<?php echo 'pizza_size' . $row['id']; ?>" value="<?php echo $row['size']; ?>"><?php echo $row['size']; ?></td>
                                    <td><input type="hidden" name="<?php echo 'pizza_price' . $row['id']; ?>" value="<?php echo $row['price']; ?>"><?php echo $row['price']; ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                    
                    <input type="submit" name="submit" value="Add to List" onclick="getdata()">

                    <br></br>

                    <table class="table table-striped">
                        <thead>
                            <th></th>
                            <th>Ingredient Name</th>
                            <th>Province</th>
                            <th>Price</th>
                        </thead>
                        <tbody>
                            <?php
                            while ($row = pg_fetch_assoc($ingredient_list)) { ?>
                                <tr>
                                    <td><input type="checkbox" value="<?php echo $row['ing_detail_id']; ?>" name="ing_id[]"></td>
                                    <td><input type="hidden" name="<?php echo 'ing_name' . $row['ing_detail_id']; ?>" value="<?php echo $row['name']; ?>"><?php echo $row['name']; ?></td>
                                    <td><input type="hidden" name="<?php echo 'ing_province' . $row['ing_detail_id']; ?>" value="<?php echo $row['province']; ?>"><?php echo $row['province']; ?></td>
                                    <td><input type="hidden" name="<?php echo 'ing_price' . $row['ing_detail_id']; ?>" value="<?php echo $row['price']; ?>"><?php echo $row['price']; ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                    <input type="submit" name="add_ingredient" value="Add to list">
                </form>
            </div>
            <!-- order list will appear from here -->
            <div class="col-md-6 internal-div2" style="float: right;">
                <div id=" tbl-header">
                    <h2 style="text-align: center;">Order List</h2>
                </div>
                <div id="order-show-table">
                    <form method="POST">
                        <table class="table table-striped">
                            <thead>
                                <th>#</th>
                                <th>Item</th>
                                <th>Price</th>
                            </thead>
                            <tbody>
                                <?php
                                $t_price = 0;
                                $count = 1;
                                foreach ($cart as $row) { ?>
                                    <tr>
                                        <td><?php echo $count; ?></td>
                                        <td>
                                            <?php
                                            if (!empty($row['pizza'])) {
                                                echo $row['pizza'] . ' cm pizza';
                                            } else {
                                                echo 'Ing. ' . $row['ing'];
                                            }
                                            ?>
                                        </td>
                                        <td><?php $t_price += $row['price']; echo $row['price']; ?></td>
                                    </tr>
                                <?php $count++;
                                } ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="2">Total Price</td>
                                    <td><?php echo $t_price; ?></td>
                                </tr>
                            </tfoot>
                        </table>
                        <input type="submit" name="order" style="float: right;" value="Place Order">
                        <br></br>
                    </form>
                </div>
                <h3><?php if ($result != null) echo pg_fetch_result($result, 0); ?></h3>
            </div>
        </div>
    </div>

    <script>
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }
        $('input.chk').on('change', function() {
            $('input.chk').not(this).prop('checked', false);
        });
    </script>

</body>

<?php include('footer.php'); ?>

</html>