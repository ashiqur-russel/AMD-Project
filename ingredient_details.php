<?php require_once 'conn.php';?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
        <title>View Ingredient Page</title>
    </head>
    <body>
        <div>
            <?php include_once './nav/nav.php'?>
        </div>

<?php 
require_once 'conn.php';
$ing_id = $_GET['ing_id'];
$ing_name = $_GET['ing_name'];
$ing_detail_id = isset($_GET['id']) ? $_GET['id'] : '';

$single_row = null;

//fetching all available supplier which are not hidden
$sql = "SELECT * FROM fetch_supplier_by_ingredient('$ing_name')";
$supplier_list = pg_query($db, $sql);

// post data to database
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //checking type of form posting; $_POST['submit'] means its called from New Entry form
    if (isset($_POST['submit'])) {
        $province = $_POST['province'];
        $price = $_POST['price'];
        $quantity = $_POST['quantity'];
        $supplier = $_POST['supplier'];
        $visibility = $_POST['visiblility'];
        //checking if supplier id is present; if present we have to update the existing; if not insert new supplier
        if (empty($_POST['ing_detail_id'])) {
            //calling insert function and returning the sql string
            $sql = insert_detail($ing_id, $province, $price, $quantity, $supplier, $visibility);
        }
        $result = pg_query($db, $sql);
    }
    if(isset($_POST['open_modal'])) {
        $id = $_POST['btn_update'];
        $ing_detail_id = $id;
        echo "<script>$(document).ready(function(){
            $('#myModalUpdate').modal('show')
         });</script>";
    }
    if(isset($_POST['update'])) {
        var_dump($ing_detail_id);
        $u_price = $_POST['updated_price'];
        $u_visibility = $_POST['updated_visibility'];
        $sql = update_detail($ing_detail_id, $u_price, $u_visibility);
        $result = pg_query($db, $sql);

    }
    //performing delete operation of the seleted ingredient
    if (isset($_POST['delete'])) {
        $id = $_POST['btn_delete'];
        $sql = "SELECT * FROM delete_ingredient_detail($id)";
        $result = pg_query($db, $sql);
    }
}

//function to insert new ingredient; only making sql query and returning the query as string
function insert_detail($ing_id, $province, $price, $quantity, $supplier, $visibility)
{
    if($visibility == 1) {
        //checking visiblity and creating query depending on visibility
        $sql = "SELECT add_ingredient_detail($ing_id, '$province', $price, $quantity, '$supplier', false)";
    } else {
        //checking visiblity and creating query depending on visibility
        $sql = "SELECT add_ingredient_detail($ing_id, '$province', $price, $quantity, '$supplier', true)";
    }
    
    return $sql;
}

function update_detail($id, $price, $visibility)
{
    if($visibility == 1) {
        //checking visiblity and creating query depending on visibility
        $sql = "SELECT update_ingredient_detail($id, $price, false)";
    } else {
        //checking visiblity and creating query depending on visibility
        $sql = "SELECT update_ingredient_detail($id, $price, true)";
    }
    
    return $sql;
}

?>

        <div class="container">
            <div class="col-md-12">
                <div class="col-md-9" style="float: left"><h2 style="text-align: right; padding-right: 50px">View Ingredient Details List</h2></div>
                <div class="col-md-3" style="float: left; padding-top: 15px"><button type="button" class="button btn btn-primary" data-toggle="modal" data-target="#myModal">Add Ingredient</button></div>
            </div>

            <div style="height:auto; width:100%; border: 1px solid black; float: left">

                <table class="table table-striped">
                    <tr>
                        <th> <font face="Arial">Id</font> </th>
                        <th> <font face="Arial">Provenance</font> </th>
                        <th> <font face="Arial">Price</font> </th>
                        <th> <font face="Arial">Quantity</font> </th>
                        <th> <font face="Arial">Supplier</font> </th>
                        <th> <font face="Arial">Visibility</font> </th>
                        <th> <font face="Arial">Action</font> </th>
                    </tr>
                    <?php
                    $sql = "select * from fetch_ingredient_detail_by_ing_id($ing_id)";
                    $result = pg_query($db, $sql);
                    while ($row = pg_fetch_assoc($result)) {
                        $display = ($row["is_hidden"] == "t") ? 'Hidden' : 'Show';
                    ?>
                        <form method="post">
                            <tr>
                                <td><?php  echo $row["id"]; ?></td>
                                <td><?php  echo $row["province"]; ?></td>
                                <td><?php  echo $row["price"]; ?></td>
                                <td><?php  echo $row["quantity"]; ?></td>
                                <td><?php  echo $row["supplier"]; ?></td>
                                <td><?php  echo $display; ?></td>
                                <td><button type="button" class="button btn btn-primary" data-toggle="modal" data-target="#myModalRestock">Restock</button></td>
                                <input type="hidden" name="btn_update" value="<?php echo $row["id"]; ?>" />
                                <input type="hidden" name="btn_delete" value="<?php echo $row["id"]; ?>" />
                                <td><button type="submit" class="button btn btn-primary" name="open_modal" data-toggle="modal" data-target="#myModalUpdate">Update</button></td>
                                <td><input type="submit" class="button btn btn-primary" name="delete" value="Delete" /></td>
                            </tr>
                        </form>
                    <?php }?>
                </table>
            </div>
        </div>
        <!-- Modal for Add ingredient details -->
        <div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Ingredient Insertion</h4>
            </div>
            <div class="modal-body">
                <form class="form-group" style="float : left; margin: 10px" action="ingredient_details.php?ing_id=<?php echo $ing_id; ?>&ing_name=<?php echo $ing_name; ?>" method="post">
                    <div >
                        <div class="row">
                            <div class="col-md-12" style="margin: 10px">
                                <div class="col-md-4">
                                    <label for="province">Regional Provenance</label>
                                </div>
                                <div class="col-md-5">
                                    <input type="text" class="form-control" id="province" name="province" placeholder="Enter Province Name">
                                </div>
                                <div class="col-md-3"></div>
                            </div>
                            <div class="col-md-12" style="margin: 10px">
                                <div class="col-md-4">
                                    <label for="price">Price</label>
                                </div>
                                <div class="col-md-4">
                                    <input type="text" class="form-control" id="price" name="price" placeholder="Enter Price">
                                </div>
                                <div class="col-md-4" style="padding-top: 7px">€ / Quantity (in Stück)</div>
                            </div>
                            <div class="col-md-12" style="margin: 10px">
                                <div class="col-md-4">
                                    <label for="quantity">Quantity</label>

                                </div>
                                <div class="col-md-4">
                                    <input type="text" class="form-control" id="quantity" name="quantity" placeholder="Enter Stock">
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
                                    <input class="form-check-input" type="radio" name="visiblility" id="visiblility" value=1>
                                    <label class="form-check-label" for="visible">
                                        Show
                                    </label>

                                </div>
                                <div class="col-md-4">
                                    <input class="form-check-input" type="radio" name="visiblility" id="visiblility" value=0>
                                    <label class="form-check-label" for="visible">
                                        Hidden
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-12 modal-footer">
                                <button style="margin-left: 40px;" type="submit" class="btn btn-primary" name="submit">Submit</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
            </div>
            </div>
        </div>
        </div>

        <!-- Modal for Restock ingredient quantity -->
        <div id="myModalRestock" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Restock Quantity</h4>
            </div>
            <div class="modal-body">
                <form class="form-group" style="float : left; margin: 10px" action="ingredient_details.php?ing_id=<?php echo $ing_id; ?>&ing_name=<?php echo $ing_name; ?>" method="post">
                    <div >
                        <div class="row">
                            <div class="col-md-12" style="margin: 10px">
                                <div class="col-md-4">
                                    <label for="supplier">Supplier Name</label>
                                </div>
                                <div class="col-md-4">
                                    <select class="form-control" id="supplier" name="supplier">
                                        <option selected="selected" disabled>Choose Supplier</option>
                                        <?php
                                        //fetching all available supplier which are not hidden
                                        $sql = "SELECT * FROM fetch_supplier_by_ingredient('$ing_name')";
                                        $supplier_list = pg_query($db, $sql);                              
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
                                    <label for="quantity">Quantity</label>

                                </div>
                                <div class="col-md-4">
                                    <input type="text" class="form-control" id="quantity" name="quantity" placeholder="Enter Stock">
                                </div>
                                <div class="col-md-4"></div>
                            </div>
                            <div class="col-md-12 modal-footer">
                                <button style="margin-left: 40px;" type="submit" class="btn btn-primary" name="submit">Submit</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
            </div>
            </div>
        </div>
        </div>

        <!-- Modal for Update ingredient Price, Supplier & Visibility -->
        <div id="myModalUpdate" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Update Ingredient Details</h4>
            </div>
            <div class="modal-body">
                <form class="form-group" style="float : left; margin: 10px" action="ingredient_details.php?ing_id=<?php echo $ing_id; ?>&ing_name=<?php echo $ing_name; ?>&id=<?php echo $ing_detail_id; ?>" method="post">
                    <div >
                        <div class="row">
                            <div class="col-md-12" style="margin: 10px">
                                <div class="col-md-4">
                                    <label for="price">Price</label>
                                </div>
                                <div class="col-md-4">
                                    <input type="text" class="form-control" id="updated_price" name="updated_price" placeholder="Enter Price">
                                </div>
                                <div class="col-md-4" style="padding-top: 7px">€ / Quantity (in Stück)</div>
                            </div>
                            <div class="col-md-12" style="margin: 10px">
                                <div class="col-md-4">
                                    <label>Visibility</label>
                                </div>
                                <div class="col-md-4">
                                    <input class="form-check-input" type="radio" name="updated_visibility" id="updated_visibility" value=1>
                                    <label class="form-check-label" for="visible">
                                        Show
                                    </label>

                                </div>
                                <div class="col-md-4">
                                    <input class="form-check-input" type="radio" name="updated_visibility" id="updated_visibility" value=0>
                                    <label class="form-check-label" for="visible">
                                        Hidden
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-12 modal-footer">
                                <button style="margin-left: 40px;" type="submit" class="btn btn-primary" name="update">Update</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
            </div>
            </div>
        </div>
        </div>

        <script>
            if (window.history.replaceState) {
                window.history.replaceState(null, null, window.location.href);
            }
        </script>
    </body>
</html>
