<?php
session_start();
include 'class.php';

$showConvos = new msgs();
$showConvos->setHash($_GET['hash']);
$showConvos->setUserID($_SESSION['UserID']);
$showConvos->DisplayConvo();
    
?>