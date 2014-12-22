<?php

ini_set('display_errors',"1");
session_start();
include "class.php";

if(isset($_POST['passwordCurrE']) && isset($_POST['email1']) && isset($_POST['email2'])) {
    if (trim($_POST['passwordCurrE']) != "" || trim($_POST['email1']) != "" || trim($_POST['email2']) != ""){
        if(trim($_POST['email1']) == trim($_POST['email2'])){
            $user = new user();
            $user->setUserID($_SESSION['UserID']);
            $user->setOldPassword(sha1($_POST['passwordCurrE']));
            $user->setPassword($_POST['email1']);
            $user->setPassword1($_POST['email2']);
            $user->ChangeEmail();
            $_SESSION['Email'] = $_POST['email1'];
        } else {
            echo "New emails do not match!";
            header("Location: ../Home.php?p=profile&a=settings&error=5");
        }
    } else {
        echo "Empty fields!";
        header("Location: ../Home.php?p=profile&a=settings&error=4");
    }
} else {
    echo "Error.";
}