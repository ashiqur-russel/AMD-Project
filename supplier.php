<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <title>Supplier Page</title>
</head>

<body>

    <div>
        <?php include_once './nav/nav.php'?>
    </div>

<?php
require_once 'conn.php';
$single_row = null;
// check type of request
// run only when POST method is called
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //checking type of form posting; $_POST['submit'] means its called from New Entry form
    if (isset($_POST['submit'])) {
        $supplier_name = $_POST['supplier_name'];
        $visible = $_POST['visible'];

        //checking if supplier id is present; if present we have to update the existing; if not insert new supplier
        if (empty($_POST['supplier_id'])) {
            //calling insert function and returning the sql string
            $sql = insert_supplier($supplier_name, $visible);
        } else {
            //calling update function and returning the sql string
            $sql = update_supplier($_POST['supplier_id'], $supplier_name, $visible);
        }
        //performing sql query and returning result
        $result = pg_query($db, $sql);
    }

    //$_POST['update'] means if is called from a row of the table and existing supplier will update
    if (isset($_POST['update'])) {
        $id = $_POST['btn_update'];
        $sql = "SELECT * FROM fetch_supplier($id)";
        $response = pg_query($db, $sql);
        $single_row = pg_fetch_assoc($response);
    }

    //performing delete operation of the seleted supplier
    if (isset($_POST['delete'])) {
        $id = $_POST['btn_delete'];
        $sql = "SELECT * FROM delete_supplier($id)";
        $result = pg_query($db, $sql);
    }
}

//function to insert new supplier; only making sql query and returning the query as string
function insert_supplier($supplier_name, $visible)
{
    //checking visiblity and creating query depending on visibility
    if ($visible == 1) {
        $sql = "SELECT add_supplier('$supplier_name', false)";
    } else {
        $sql = "SELECT add_supplier('$supplier_name', true)";
    }
    return $sql;
}

//function to update existing supplier; only making sql query and returning the query as string
function update_supplier($supplier_id, $supplier_name, $visible)
{
    //checking visiblity and creating query depending on visibility
    if ($visible == 1) {
        $sql = "SELECT update_supplier('$supplier_id', '$supplier_name', false)";
    } else {
        $sql = "SELECT update_supplier('$supplier_id', '$supplier_name', true)";
    }
    return $sql;
}
?>

    <div class="container">
        <div class="col-md-12">
            <h2 style="text-align: center">Supplier Management</h2>
        </div>
        <div style=" width:100%; border: 1px solid black; margin-bottom : 10px; float : left">
            <form style="float : left" action="supplier.php" method="post">
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-12" style="margin: 10px"><u>
                                <h3>Supplier Insertion</h3>
                            </u></div>
                        <div class="col-md-12" style="margin: 10px">
                            <div class="col-md-4">
                                <label for="supplier_name">Supplier Name</label>
                            </div>
                            <div class="col-md-4" style="display:none">
                                <input type="hidden" class="form-control" id="supplier_id" name="supplier_id"
                                    value="<?php echo $single_row["id"]; ?>">
                            </div>
                            <div class="col-md-4">
                                <input type="text" class="form-control" id="supplier_name" name="supplier_name"
                                    value="<?php echo $single_row["name"]; ?>" placeholder="Enter Supplier Name">
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
                    <h3>View Supplier Details</h3>
                </u></div>

<?php
echo '<table class="table table-striped">
        <tr>
            <th> <font face="Arial">Id</font> </th>
            <th> <font face="Arial">Name</font> </th>
            <th> <font face="Arial">Visibility</font> </th>
            <th> <font face="Arial">Update</font> </th>
            <th> <font face="Arial">Delete</font> </th>
        </tr>';

$sql = "select * from fetch_all_supplier()";
$result = pg_query($db, $sql);
//print_r($result);

while ($row = pg_fetch_assoc($result)) {
    $visibility = ($row["is_hidden"] == "t") ? 'Hidden' : 'Show';
    ?>
            <form method="post">
                <tr>
                    <td><?php echo $row["id"]; ?></td>
                    <td><?php echo $row["name"]; ?></td>
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
    //prevent browser from resubmit the form
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
    </script>
</body>

</html>