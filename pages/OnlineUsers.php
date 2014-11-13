<?php
    session_start();
    include 'conn.php';
    
    if(isset($_SESSION['UserID'])){
        $sqlSelect=$stmt->prepare("SELECT OnlineID FROM online WHERE OnlineID= ? ");
        $sqlSelect->execute(array($_SESSION['UserID']));
        
        if($sqlSelect->rowCount() != 0){
            $sqlUpdate=$stmt->prepare("UPDATE online SET Seen=NOW() WHERE OnlineID =? ");
            $sqlUpdate->execute(array($_SESSION['UserID']));
        }else{
            $sqlInsert=$stmt->prepare("INSERT INTO online (OnlineID,Seen,LoginTime) VALUES (?,NOW(),NOW())");
            $sqlInsert->execute(array($_SESSION['UserID']));
        }
    }

    $sql=$stmt->prepare("SELECT * FROM online");
    $sql->execute();
    while($status = $sql->fetch()){
        $curtime=strtotime(date("Y-m-d H:i:s",strtotime('-25 seconds', time())));
        if(strtotime($status['Seen']) < $curtime){
            $sqlDelete=$stmt->prepare("DELETE FROM online WHERE OnlineID = ?");
            $sqlDelete->execute(array($status['OnlineID']));
        }
    }
    
    
?>