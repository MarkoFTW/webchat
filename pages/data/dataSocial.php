<?php
include '../conn.php';

$result = $stmt->prepare("SELECT Type, count(Type) FROM users GROUP BY Type");
$result->execute();

$rows = array();
while ($r = $result->fetch()){
    if($r['Type'] == 1){
        $row[0] = "Website";
        $row[1] = $r[1];
    } else {
        $row[0] = "Facebook";
        $row[1] = $r[1];
    }
    /*$row[0] = $r[0];
    $row[1] = $r[1];*/
    array_push($rows,$row);
}

print json_encode($rows, JSON_NUMERIC_CHECK);
?>