<?php

    session_start();
    include 'class.php';
    
    if(isset($_POST['myEmail']) && empty($_POST['myUser'])) {
        include 'conn.php';
        $getEmail = $stmt->prepare("SELECT * FROM users WHERE Email = :email");
        $getEmail->execute(array(
            'email' => $_POST['myEmail']
        ));
        $rows = $getEmail->rowCount();
        if($rows == 1) {
            $newPass = rand();
            $updatePass = $stmt->prepare("UPDATE users SET Password = :pw WHERE Email = :mail");
            $updatePass->execute(array(
                'pw' => sha1($newPass),
                'mail' => $_POST['myEmail']
            ));
            $resetpass = new mailer();
            $resetpass->sendEmail($_POST['myEmail'], "Password reset", "Your new password is: " . $newPass, "From: noreply@domain.com");
        } else {
            echo "No email found.";
            header("Location: ../index.php?error=3");
        }
     } elseif (isset($_POST['myUser']) && empty($_POST['myEmail'])) {
        include 'conn.php';
        $getUser = $stmt->prepare("SELECT * FROM users WHERE Username = :user");
        $getUser->execute(array(
            'user' => $_POST['myUser']
        ));
        $rows = $getUser->rowCount();
        $getmail = $getUser->fetch();
        if($rows == 1) {
            $newPass = rand();
            $updatePass = $stmt->prepare("UPDATE users SET Password = :pw WHERE Username = :user");
            $updatePass->execute(array(
                'pw' => sha1($newPass),
                'user' => $_POST['myUser']
            ));
            $resetpass = new mailer();
            $resetpass->sendEmail($getmail['Email'], "Password reset", "Your new password is: " . $newPass, "From: noreply@domain.com");
        } else {
            echo "No user found.";
            header("Location: ../index.php?error=3");
        }
    } else {
        header("Location: ../index.php?error=3");
    }
?>