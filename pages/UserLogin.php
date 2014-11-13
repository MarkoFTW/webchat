<?php
    session_start();
    include 'class.php';
    include 'conn.php';

    if(isset($_POST['UserMailLogin']) && isset($_POST['UserPasswordLogin'])) {
        $user = new user();
        $user->setEmail($_POST['UserMailLogin']);
        $user->setPassword(sha1($_POST['UserPasswordLogin']));
        $user->UserLogin();

        $_SESSION['UserID'] = $user->getUserID();
        $_SESSION['Username'] = $user->getUsername();
        $_SESSION['Email'] = $user->getEmail();
        $_SESSION['Type'] = $user->getType();
        
    }
    
?>