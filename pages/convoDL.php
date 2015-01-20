<?php
session_start();
include 'class.php';
include 'conn.php';

if(isset($_POST['hash'])) {
    $sql = $stmt->prepare("SELECT * FROM private_msg WHERE group_hash = :hash");
    $sql->execute(array(
       "hash" => $_POST['hash'] 
    ));

    $file = fopen("chat_data/".$_SESSION['UserID'] . "_" . $_POST['hash'] . "_chatlog.html", "w") or die("Unable to open file!");
    $txt = '<!DOCTYPE html>
    <html>
        <head>
            <title>'.$_POST['hash'].'</title>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <style>
                body{ background-color: #373737;}
                #main { width: 500px;margin: 0 auto;}
                p {color:#0099CC;}
                .pmsg{color: white; text-decoration: none;}
            </style>
        </head>
        <body>
            <div id="main">
                <span style="color:white;font-size: 2em;">Chat history for '.$_POST['hash'].'</span><br/>
                ';
    fwrite($file, $txt);
    
    while($f = $sql->fetch()){

        $mesec = array(
            "01" => "january",
            "02" => "february",
            "03" => "march",
            "04" => "april",
            "05" => "mai",
            "06" => "june",
            "07" => "july",
            "08" => "august",
            "09" => "september",
            "10" => "october",
            "11" => "november",
            "12" => "december",
        );

        $novidatumura = explode(" ", $f['msg_time']);
        $datum = str_replace('-', '.', $novidatumura[0]);
        $ura = date('H:i',strtotime($novidatumura[1]));

        $datumexpl = explode(".", $datum);

        $txt = "<br/></p><p><a class='pmsg' href='http://devps1.marefx.com/webchat/Home.php?page=profile&view=".replaceID($f['from_id'])."'>".replaceID($f['from_id'])."</a> <span style='font-size: 10px;'>". $datumexpl[2] . " " . $mesec[$datumexpl[1]] . " " . $datumexpl[0] . " @ " . $ura ."</span><br/>".$f['message']."";
    
        fwrite($file, $txt);
    }

    $txt = '
            </div>
        </body>
    </html>';
    fwrite($file, $txt);

    fclose($file);
    
    //download file...
    
    $filePath = "chat_data/".$_SESSION['UserID'] . "_" . $_POST['hash'] . "_chatlog.html";
    
    if(file_exists($filePath)) {
        $fileName = basename($filePath);
        $fileSize = filesize($filePath);

        // Output headers.
        header("Cache-Control: private");
        header("Content-Type: application/stream");
        header("Content-Length: ".$fileSize);
        header("Content-Disposition: attachment; filename=".$fileName);

        // Output file.
        readfile ($filePath);                   
        exit();
    }
    else {
        die('The provided file path is not valid.');
    }
    
    
    header("Location: ../Home.php?page=private&success=1");
    
} else {
    echo "Error.";
}