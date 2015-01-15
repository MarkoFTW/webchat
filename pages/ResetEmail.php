<?php

ini_set('display_errors',"1");
session_start();
include "class.php";

if(isset($_POST['passwordCurrE']) && isset($_POST['email1']) && isset($_POST['email2'])) {
    if (!empty(trim($_POST['passwordCurrE'])) || !empty($_POST['email1']) || !empty($_POST['email2'])){
        if(trim($_POST['email1']) == trim($_POST['email2'])){
            $user = new user();
            $user->setUserID($_SESSION['UserID']);
            $user->setOldPassword(sha1(trim($_POST['passwordCurrE'])));
            $user->setPassword(trim($_POST['email1']));
            $user->setPassword1(trim($_POST['email2']));
            $user->ChangeEmail();
        } else {
            //echo "New emails do not match!";
            header("Location: ../Home.php?page=profile&a=email&error=1");
        }
    } else {
        //echo "Empty fields!";
        header("Location: ../Home.php?page=profile&a=email&error=2");
    }
} else {
    echo "Error.";
}