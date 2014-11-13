<?php
    session_start();
    
    include 'class.php';
    if(isset($_POST['Message'])){
        $chat = new chat();
        $chat->setMsgUserID($_SESSION['UserID']);
        $chat->setMessage($_POST['Message']);
        $chat->InsertChatMessage();
    }
?>