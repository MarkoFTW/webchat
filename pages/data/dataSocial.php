<?php
include '../conn.php';

$Qresult = $stmt->prepare("SELECT Type, count(Type) FROM users GROUP BY Type");
$Qresult->execute();
$category = array();
$category['name'] = 'LoginType';
$series1 = array();
$series1['name'] = 'Users';

while ($r = $Qresult->fetch()){
    if($r['Type'] == 1){
        $category['data'][] = "Website";
        $series1['data'][] = $r[1];
    } else {
        $category['data'][] = "Facebook";
        $series1['data'][] = $r[1];
    }
}

$result = array();
array_push($result,$category);
array_push($result,$series1);

print json_encode($result, JSON_NUMERIC_CHECK);
?>