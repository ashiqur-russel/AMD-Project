<?php require_once 'conn.php';?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <title>Order Page</title>
    </head>
    <body>
        <div>
            <?php include_once './nav/nav.php'?>
        </div>
        <div class="container">
            <div class="col-md-12">
                <h2 style="text-align: center">View Order List</h2>
            </div>

            <div style="height:auto; width:100%; border: 1px solid black; float: left">

                <table class="table table-striped">
                    <tr>
                        <th> <font face="Arial">Id</font> </th>
                        <th> <font face="Arial">Name</font> </th>
                        <th> <font face="Arial">Province</font> </th>
                        <th> <font face="Arial">Price</font> </th>
                        <th> <font face="Arial">Quantity</font> </th>
                        <th> <font face="Arial">Supplier</font> </th>
                        <th> <font face="Arial">Visibility</font> </th>
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
    </body>

</html>