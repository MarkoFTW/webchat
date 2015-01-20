<?php
session_start();
include 'class.php';
$c = new Profile();
$c->setUserID2($_SESSION['UserID']);
if(isset($_POST['censor'])){
    if($_POST['censor'] == "off") {
        $c->changeSettings("0", 1);
    } else {
        $c->changeSettings("1", 1);
    }
} elseif(isset($_POST['bday'])){
    $c->changeSettings($_POST['bday'], 3);
} elseif(isset($_POST['gender'])){
    if($_POST['gender'] == "male") {
        $c->changeSettings("1", 2);
    } elseif($_POST['gender'] == "alien") {
        $c->changeSettings("0", 2);
    } elseif($_POST['gender'] == "female"){
        $c->changeSettings("2", 2);
    }
} else {
    echo "Error";
}