<?php require_once 'conn.php'?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <title>Pizza Page</title>
</head>

<body>
    <div>
        <?php include_once './nav/nav.php'?>
    </div>



    <?php
// post data to database
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $pizza_size = $_POST['pizza_size'];
    $pizza_price = $_POST['pizza_price'];
    $sql = "SELECT add_pizza('$pizza_size', '$pizza_price')";
    $result = pg_query($db, $sql);
}

?>
    <div class="container">
        <div class="col-md-12">
            <h2 style="text-align: center">Pizza Management</h2>
        </div>
        <div style=" width:100%; border: 1px solid black; margin-bottom : 10px; float : left">

            <form style="float : left" action="pizza.php" method="post">
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-12" style="margin: 10px"><u>
                                <h3>Pizza Insertion</h3>
                            </u></div>
                        <div class="col-md-12" style="margin: 10px">
                            <div class="col-md-4">
                                <label for="pizza_size">Pizza Size</label>
                            </div>
                            <div class="col-md-4">
                                <input type="text" class="form-control" id="pizza_size" name="pizza_size"
                                    placeholder="Enter Pizza Size">
                            </div>
                            <div class="col-md-4" style="padding-top: 7px">cm</div>
                        </div>
                        <div class="col-md-12" style="margin: 10px">
                            <div class="col-md-4">
                                <label for="pizza_price">Pizza Price</label>
                            </div>
                            <div class="col-md-4">
                                <input type="text" class="form-control" id="pizza_price" name="pizza_price"
                                    placeholder="Enter Pizza Price">
                            </div>
                            <div class="col-md-4" style="padding-top: 7px">€</div>
                        </div>
                        <div class="col-md-12" style="margin: 10px;">
                            <button style="margin-left: 40px;" type="submit" class="btn btn-primary"
                                name="submit">Submit</button>
                        </div>
                    </div>
                </div>


            </form>

        </div>

        <div style="height:auto; width:100%; border: 1px solid black; float: left">
            <div class="col-md-12"><u>
                    <h3>View Pizza Details</h3>
                </u></div>
            <?php

echo '<table class="table table-striped">
      <tr>
        <th> <font face="Arial">Id</font> </th>
          <th> <font face="Arial">Size</font> </th>
          <th> <font face="Arial">Price</font> </th>
      </tr>';

$sql = "select * from fetch_all_pizza()";
$result = pg_query($db, $sql);

while ($row = pg_fetch_assoc($result)) {
    ?>
            <form method="post">
                <tr>
                    <td><?php echo $row["id"]; ?></td>
                    <td><?php echo $row["size"]; ?></td>
                    <td><?php echo $row["price"]; ?></td>
                </tr>
            </form>
            <?php }?>

            </table>

        </div>
    </div>

    <script>
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
    </script>

</body>

</html>