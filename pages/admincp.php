<?php
include_once 'class.php';
$a = new user();
$a->setUserID($_SESSION['UserID']);
    if($a->CheckAdmin()) {
        echo "admincp";
    } else {
        echo "access denied";
    }
?>