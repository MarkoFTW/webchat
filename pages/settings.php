<?php
session_start();
include 'class.php';

if(isset($_POST['censor'])){
    $c = new Profile();
    $c->setUserID2($_SESSION['UserID']);
    if($_POST['censor'] == "off") {
        $c->changeCensor("0");
    } else {
        $c->changeCensor("1");
    }
} else {
    echo "Error";
}