<?php
    session_start();
    
    include_once 'class.php';
    if(isset($_POST['Message1']) && isset($_POST['Hash'])){
        $convo = new msgs();
        $convo->setHash($_POST['Hash']);
        $convo->setUserID($_SESSION['UserID']);
        $convo->setMessage($_POST['Message1']);
        $convo->InsertConvoMsg();
    } elseif(isset($_POST['Message2']) && isset($_POST['User'])){
        $convo = new msgs();
        $convo->setUserID($_SESSION['UserID']);
        $convo->setRecptID($_POST['User']);
        $convo->setMessage($_POST['Message2']);
        $convo->CheckValidConvo("yes");
        $convo->InsertConvoMsg();
        header("Location: ../Home.php?page=private&do=show&hash=".$convo->getHash());
    }
?>