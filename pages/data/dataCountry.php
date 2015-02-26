<?php
include '../conn.php';

$result = $stmt->prepare("SELECT country, count(country) FROM users GROUP BY country");
$result->execute();
$rows = array();
while ($r = $result->fetch()){
    $row[0] = $r[0];
    $row[1] = $r[1];
    array_push($rows,$row);
}
print json_encode($rows, JSON_NUMERIC_CHECK);
?>