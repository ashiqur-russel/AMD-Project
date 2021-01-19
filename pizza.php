<?php

require_once 'conn.php'

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <title>Pizza Table</title>
</head>

<body>



    <?php

echo '<table class="table table-striped">
      <tr>
          <th> <font face="Arial">Id</font> </th>
          <th> <font face="Arial">Name</font> </th>
          <th> <font face="Arial">Size</font> </th>
          <th> <font face="Arial">Price</font> </th>
                    <th> <font face="Arial">Add-Ons</font> </th>

      </tr>';

$sql = "select * from fetch_all_pizza()";
$result = pg_query($db, $sql);
//$row = pg_fetch_row($result);
echo "<br/>";

while ($row = pg_fetch_assoc($result)) {

    $field1name = $row["id"];
    $field2name = $row["name"];
    $field3name = $row["size"];
    $field4name = $row["price"];

    echo '<tr>
                  <td>' . $field1name . '</td>
                  <td>' . $field2name . '</td>
                  <td>' . $field3name . '</td>
                  <td>' . $field4name . '</td>
                  <td>' . $field5name . '</td>
              </tr>';

    echo "<br/>";
}

pg_close($con);
?>

    </table>



</body>

</html>