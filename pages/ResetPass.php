<?php

    session_start();
    include 'class.php';
    
    if(isset($_POST['OldPassword']) && isset($_POST['NewPassword']) && isset($_POST['NewPassword1'])) {
        if (trim($_POST['OldPassword']) != "" || trim($_POST['NewPassword']) != "" || trim($_POST['NewPassword1']) != ""){
            if(trim($_POST['NewPassword']) == trim($_POST['NewPassword1'])){
                $user = new user();
                $user->setUserID($_SESSION['UserID']);
                $user->setOldPassword(sha1($_POST['OldPassword']));
                $user->setPassword(sha1($_POST['NewPassword']));
                $user->setPassword1(sha1($_POST['NewPassword1']));
                $user->ChangePass();
            } else {
                echo "New passwords do not match!";
            }
        } else {
            echo "Empty fields!";
            header("Location: ../Home.php?page=profile&error=1");
        }
    } else {
        echo "Error.";
    }

?>