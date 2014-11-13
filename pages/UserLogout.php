<?php
    session_start();
    include 'class.php';
    include 'conn.php';
    
    if(isset($_POST['submitlogout'])){
        
        $userid = $_SESSION['UserID'];
        
        $sql=$stmt->prepare("DELETE FROM online WHERE OnlineID = :OnlineName");
        $sql->execute(array(
            'OnlineName' => $userid
            ));
        
        
        $_SESSION = array();
        session_destroy();
        header("Location: ../index.php");
    }
?>