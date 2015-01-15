<?php

    /*error_reporting(E_ALL);
    ini_set('display_errors', '1');*/
    include 'class.php';
    
    if(isset($_POST['Username']) && isset($_POST['Email']) && isset($_POST['Password']) && isset($_POST['Password1'])) {
        if (trim($_POST['Username']) != "" || trim($_POST['Email']) != "" || trim($_POST['Password']) != "" || trim($_POST['Password1']) != ""){
            if(filter_var($_POST['Email'], FILTER_VALIDATE_EMAIL)){
                $user = new user();
                $user->setUsername(trim($_POST['Username']));
                $user->setEmail(trim($_POST['Email']));
                $user->setPassword(sha1(trim($_POST['Password'])));
                $user->setPassword1(sha1(trim($_POST['Password1'])));
                $user->setIP($_SERVER['REMOTE_ADDR']);
                if(!$user->FindEmail()){
                    echo "Email in use!";
                    header("Location: ../index.php?error=5");
                } else if(!$user->FindUsername()){
                    echo "Username in use!";
                    header("Location: ../index.php?error=6");
                } else {
                    $user->InsertUser();
                }
            } else {
                header("Location: ../index.php?error=7");
            }
        } else {
            echo "Empty fields!";
            header("Location: ../index.php?error=4");
        }
    } else {
        echo "Error.";
    }

?>