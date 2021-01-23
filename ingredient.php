<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <title>Ingredient Page</title>
</head>

<body>
    <div>
        <?php include_once './nav/nav.php'?>
    </div>

<?php
require_once 'conn.php';
$single_row = null;

//fetching all available supplier which are not hidden
$sql = "SELECT * FROM fetch_available_supplier()";
$supplier_list = pg_query($db, $sql);

// post data to database
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //checking type of form posting; $_POST['submit'] means its called from New Entry form
    if (isset($_POST['submit'])) {
        $in_name = $_POST['in_name'];
        $province = $_POST['province'];
        $price = $_POST['price'];
        $quantity = $_POST['quantity'];
        $supplier = $_POST['supplier'];
        $visible = $_POST['visible'];

        //checking if supplier id is present; if present we have to update the existing; if not insert new supplier
        if (empty($_POST['ingredient_id'])) {
            //calling insert function and returning the sql string
            $sql = insert_ingredient($in_name, $province, $price, $quantity, $supplier, $visible);
        } else {
            //calling update function and returning the sql string
            $sql = update_ingredient($_POST['ingredient_id'], $in_name, $province, $price, $quantity, $supplier, $visible);
        }
        //performing sql query and returning result
        $result = pg_query($db, $sql);
    }

    //$_POST['update'] means if is called from a row of the table and existing ingreident will update
    if (isset($_POST['update'])) {
        $id = $_POST['btn_update'];
        $sql = "SELECT * FROM fetch_ingredient($id)";
        $response = pg_query($db, $sql);
        $single_row = pg_fetch_assoc($response);
    }

    //performing delete operation of the seleted ingredient
    if (isset($_POST['delete'])) {
        $id = $_POST['btn_delete'];
        $sql = "SELECT * FROM delete_ingredient($id)";
        $result = pg_query($db, $sql);
    }

}

//function to insert new ingredient; only making sql query and returning the query as string
function insert_ingredient($in_name, $province, $price, $quantity, $supplier, $visible)
{
    //checking visiblity and creating query depending on visibility
    if ($visible == 1) {
        $sql = "SELECT add_ingredient('$in_name', '$province', '$price', '$quantity', '$supplier', false)";
    } else {
        $sql = "SELECT add_ingredient('$in_name', '$province', '$price', '$quantity', '$supplier', true)";
    }

    return $sql;
}

//function to update existing ingredient; only making sql query and returning the query as string
function update_ingredient($in_id, $in_name, $province, $price, $quantity, $supplier, $visible)
{
    //checking visiblity and creating query depending on visibility
    if ($visible == 1) {
        $sql = "SELECT update_ingredient('$in_id', '$in_name', '$province', '$price', '$quantity', '$supplier', false)";
    } else {
        $sql = "SELECT update_ingredient('$in_id', '$in_name', '$province', '$price', '$quantity', '$supplier', true)";
    }
    return $sql;

}

?>

    <div class="container">
        <div class="col-md-12">
            <h2 style="text-align: center">Ingredient Management</h2>
        </div>
        <div style=" width:100%; border: 1px solid black; margin-bottom : 10px; float : left">
            <form style="float : left" action="ingredient.php" method="post">
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-12" style="margin: 10px"><u>
                                <h3>Ingredient Insertion</h3>
                            </u></div>
                        <div class="col-md-4" style="display:none">
                            <input type="hidden" class="form-control" id="ingredient_id" name="ingredient_id"
                                value="<?php echo $single_row["id"]; ?>">
                        </div>
                        <div class="col-md-12" style="margin: 10px">
                            <div class="col-md-4">
                                <label for="in_name">Ingredient Name</label>
                            </div>
                            <div class="col-md-4">
                                <input type="text" class="form-control" id="in_name" name="in_name"
                                    value="<?php echo $single_row["name"]; ?>" placeholder="Enter Ingredient Name">
                            </div>
                            <div class="col-md-4"></div>
                        </div>
                        <div class="col-md-12" style="margin: 10px">
                            <div class="col-md-4">
                                <label for="province">Regional Provenance</label>

                            </div>
                            <div class="col-md-4">
                                <input type="text" class="form-control" id="province" name="province"
                                    value="<?php echo $single_row["province"]; ?>" placeholder="Enter Province Name">
                            </div>
                            <div class="col-md-4"></div>
                        </div>
                        <div class="col-md-12" style="margin: 10px">
                            <div class="col-md-4">
                                <label for="price">Price</label>
                            </div>
                            <div class="col-md-4">
                                <input type="text" class="form-control" id="price" name="price"
                                    value="<?php echo $single_row["price"]; ?>" placeholder="Enter Price">
                            </div>
                            <div class="col-md-4" style="padding-top: 7px">€ / Quantity (in Stück)</div>
                        </div>
                        <div class="col-md-12" style="margin: 10px">
                            <div class="col-md-4">
                                <label for="quantity">Stock</label>

                            </div>
                            <div class="col-md-4">
                                <input type="text" class="form-control" id="quantity" name="quantity"
                                    value="<?php echo $single_row["quantity"]; ?>" placeholder="Enter Stock">
                            </div>
                            <div class="col-md-4"></div>
                        </div>
                        <div class="col-md-12" style="margin: 10px">
                            <div class="col-md-4">
                                <label for="supplier">Supplier Name</label>
                            </div>
                            <div class="col-md-4">
                                <select class="form-control" id="supplier" name="supplier">
                                    <option selected="selected" disabled>Choose Supplier</option>
                                    <?php                                    
                                    // Iterating through the supplier array
                                    while ($item = pg_fetch_assoc($supplier_list)){
                                        $selected = ($item["name"] == $single_row["supplier"]) ? "selected" : "";
                                        echo '<option value="' .$item["name"]. '"'.$selected.'>' . $item["name"] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-4"></div>
                        </div>
                        <div class="col-md-12" style="margin: 10px">
                            <div class="col-md-4">
                                <label>Visibility</label>
                            </div>
                            <div class="col-md-4">
                                <input class="form-check-input" type="radio" name="visible" id="visible" value=1
                                    <?php echo ($single_row["is_hidden"] == 'f') ? 'checked' : '' ?>>
                                <label class="form-check-label" for="visible">
                                    Show
                                </label>

                            </div>
                            <div class="col-md-4">
                                <input class="form-check-input" type="radio" name="visible" id="visible" value=0
                                    <?php echo ($single_row["is_hidden"] == 't') ? 'checked' : '' ?>>
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
            <div class="col-md-12"><u>
                    <h3>View Ingredient Details</h3>
                </u></div>

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
            <th> <font face="Arial">Update</font> </th>
            <th> <font face="Arial">Delete</font> </th>
        </tr>';

$sql = "select * from fetch_all_ingredient()";
$result = pg_query($db, $sql);
while ($row = pg_fetch_assoc($result)) {
    $visibility = ($row["is_hidden"] == "t") ? 'Hidden' : 'Show';
    ?>
            <form method="post">
                <tr>
                    <td><?php echo $row["id"]; ?></td>
                    <td><?php echo $row["name"]; ?></td>
                    <td><?php echo $row["province"]; ?></td>
                    <td><?php echo $row["price"]; ?></td>
                    <td><?php echo $row["quantity"]; ?></td>
                    <td><?php echo $row["supplier"]; ?></td>
                    <td><?php echo $visibility; ?></td>
                    <input type="hidden" name="btn_update" value="<?php echo $row["id"]; ?>" />
                    <input type="hidden" name="btn_delete" value="<?php echo $row["id"]; ?>" />
                    <td><input type="submit" class="button btn btn-primary" name="update" value="Update" /></td>
                    <td><input type="submit" class="button btn btn-primary" name="delete" value="Delete" /></td>
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