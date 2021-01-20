<?php

require_once 'conn.php'

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <title>Ingredients Table</title>
</head>

<body>

    <div class="container">
        <div style=" width:100%; border: 1px solid black; margin-bottom : 10px; float : left">

            <form style="float : left" action="ingredient.php" method="post">
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-12" style="margin: 10px">
                            <div class="col-md-4">
                                <label for="in_name">Name</label>
                            </div>
                            <div class="col-md-8">
                                <input type="text" class="form-control" id="in_name" name="in_name"
                                    placeholder="Enter Ingredient Name">
                            </div>
                        </div>
                        <div class="col-md-12" style="margin: 10px">
                            <div class="col-md-4">
                                <label for="province">Province</label>

                            </div>
                            <div class="col-md-8">
                                <input type="text" class="form-control" id="province" name="province"
                                    placeholder="Enter Province Name">
                            </div>
                        </div>
                        <div class="col-md-12" style="margin: 10px">
                            <div class="col-md-4">
                                <label for="price">Price</label>

                            </div>
                            <div class="col-md-8">
                                <input type="text" class="form-control" id="price" name="price"
                                    placeholder="Enter Price">
                            </div>
                        </div>
                        <div class="col-md-12" style="margin: 10px">
                            <div class="col-md-4">
                                <label for="quantity">Quantity</label>

                            </div>
                            <div class="col-md-8">
                                <input type="text" class="form-control" id="quantity" name="quantity"
                                    placeholder="Enter Quantity">
                            </div>
                        </div>
                        <div class="col-md-12" style="margin: 10px">
                            <div class="col-md-4">
                                <label for="supplier">Supplier</label>

                            </div>
                            <div class="col-md-8">
                                <input type="text" class="form-control" id="supplier" name="supplier"
                                    placeholder="Enter Supplier Name">
                            </div>
                        </div>
                        <div class="col-md-12" style="margin: 10px">
                            <div class="col-md-4">
                                <label>Visibility</label>
                            </div>
                            <div class="col-md-4">
                                <input class="form-check-input" type="radio" name="visible" id="visible" value=1>
                                <label class="form-check-label" for="visible">
                                    Show
                                </label>

                            </div>
                            <div class="col-md-4">
                                <input class="form-check-input" type="radio" name="visible" id="visible" value=0>
                                <label class="form-check-label" for="visible">
                                    Hidden
                                </label>
                            </div>
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
        
<?php
    echo '<table class="table table-striped">
        <tr>
            <th> <font face="Arial">Id</font> </th>
            <th> <font face="Arial">Name</font> </th>
            <th> <font face="Arial">Province</font> </th>
            <th> <font face="Arial">Price</font> </th>
            <th> <font face="Arial">Quantity</font> </th>
            <th> <font face="Arial">Supplier</font> </th>
            <th> <font face="Arial">Visibility</font> </th>
        </tr>';

$sql = "select * from fetch_all_ingredient()";
$result = pg_query($db, $sql);

while ($row = pg_fetch_assoc($result)) {
    $visibility = ($row["is_hidden"] == "t") ? 'Hidden' : 'Show';

    echo '<tr>
                  <td>' . $row["id"] . '</td>
                  <td>' . $row["name"] . '</td>
                  <td>' . $row["province"] . '</td>
                  <td>' . $row["price"] . '</td>
                  <td>' . $row["quantity"] . '</td>
                  <td>' . $row["supplier"] . '</td>
                  <td>' . $visibility . '</td>
              </tr>';
}

// post data to database
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $in_name = $_POST['in_name'];
    $province = $_POST['province'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];
    $supplier = $_POST['supplier'];
    $visible = $_POST['visible'];
    $vis = ($visible == 0) ? false : true;

    if ($visible == 1) {
        $sql = "SELECT add_ingredient('$in_name', '$province', '$price', '$quantity', '$supplier', false)";
    } else {
        $sql = "SELECT add_ingredient('$in_name', '$province', '$price', '$quantity', '$supplier', true)";
    }

    //$sql = "SELECT add_ingredient('$in_name', '$province', '$price', '$quantity', '$supplier', $vis)";
    var_dump($sql);
    $result = pg_query($db, $sql);
    //var_dump($result);

}

pg_close($db);
?>

            </table>

        </div>
    </div>

    <script>
    if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
    }
</script>

</body>

</html>