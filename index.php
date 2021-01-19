<!DOCTYPE html>
<html>

<body>

    <h1>My first PHP page</h1>

    <?php

require_once 'conn.php';

$sql = "select * from fetch_all_ingredient()";

$result = pg_query($db, $sql);
$row = pg_fetch_row($result);
$res = $row[0];
var_dump($row);

echo $row[0];

?>

</body>

</html>