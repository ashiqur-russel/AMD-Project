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
        <div class="container">
            <div class="col-md-12">
                <div class="col-md-9" style="float: left"><h2 style="text-align: right; padding-right: 50px">View Ingredient Details List</h2></div>
                <div class="col-md-3" style="float: left; padding-top: 15px"><button type="button" class="button btn btn-primary" data-toggle="modal" data-target="#myModal">Add Ingredient</button></div>
            </div>

            <div style="height:auto; width:100%; border: 1px solid black; float: left">

                <table class="table table-striped">
                    <tr>
                        <th> <font face="Arial">Provenance Id</font> </th>
                        <th> <font face="Arial">Provenance</font> </th>
                        <th> <font face="Arial">Price</font> </th>
                        <th> <font face="Arial">Quantity</font> </th>
                        <th> <font face="Arial">Supplier</font> </th>
                        <th> <font face="Arial">Visibility</font> </th>
                        <th> <font face="Arial">Action</font> </th>
                    </tr>
                        <!-- <form method="post">
                            <tr>
                                <td><?php // echo $row["id"]; ?></td>
                                <td><?php // echo $row["name"]; ?></td>
                                <td><?php // echo $row["province"]; ?></td>
                                <td><?php // echo $row["price"]; ?></td>
                                <td><?php // echo $row["quantity"]; ?></td>
                                <td><?php // echo $row["supplier"]; ?></td>
                                <td><?php // echo $visibility; ?></td>
                                <input type="hidden" name="btn_update" value="<?php echo $row["id"]; ?>" />
                                <input type="hidden" name="btn_delete" value="<?php echo $row["id"]; ?>" />
                                <td><input type="submit" class="button btn btn-primary" name="update" value="Update" /></td>
                                <td><input type="submit" class="button btn btn-primary" name="delete" value="Delete" /></td>
                            </tr>
                        </form> -->

                </table>
            </div>
        </div>
        <!-- Modal -->
        <div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Ingredient Insertion</h4>
            </div>
            <div class="modal-body">
                <form style="float : left; margin: 10px" action="ingredient.php" method="post">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-4" style="display:none">
                                <input type="hidden" class="form-control" id="ingredient_id" name="ingredient_id">
                            </div>
                            <div class="col-md-12" style="margin: 10px">
                                <div class="col-md-4">
                                    <label for="province">Regional Provenance</label>

                                </div>
                                <div class="col-md-4">
                                    <input type="text" class="form-control" id="province" name="province" placeholder="Enter Province Name">
                                </div>
                                <div class="col-md-4"></div>
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
                                    <label for="quantity">Stock</label>

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
                            <div class="col-md-12" style="margin: 10px; text-align: center">
                                
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button style="margin-left: 40px;" type="submit" class="btn btn-primary" name="submit">Submit</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
            </div>

        </div>
        </div>
    </body>

</html>

