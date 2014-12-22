<?php
include_once 'class.php';
if(isset($_GET['do']) && $_GET['do'] == "show" && isset($_GET['hash'])){
    $hashloc = new msgs();
    if($hashloc->findHash($_GET['hash'])){
        echo "<div id='shownew'><a href='Home.php?page=private&do=show' class='pmsg'>Show conversations</a> | ";
        echo "<a href='Home.php?page=private&do=new' class='pmsg'>New conversation</a></div>";
        echo "<div id='privMsg'>";
        $showConvos = new msgs();
        $showConvos->setHash($_GET['hash']);
        $showConvos->setUserID($_SESSION['UserID']);
        $showConvos->DisplayConvo();
        echo "</div>";
    } else {
        header("Location: Home.php?page=private");
    }
?>
<form method="POST">
    <?php
    if(isset($_POST['message']) && !empty($_POST['message'])){
        $convo = new msgs();
        $convo->setHash($_GET['hash']);
        $convo->setUserID($_SESSION['UserID']);
        $convo->setMessage($_POST['message']);
        $convo->InsertConvoMsg();
        header("Location: Home.php?page=private&do=show&hash=". $_GET['hash'] ."");
    }
    ?>
    <textarea name="message" rows="7" cols="60" class="privText" id="sendPrivate"></textarea>
    <input type="submit" value="Send message" class="inputSend" id="inputSend"/>
</form>
<?php
} elseif(isset($_GET['do']) && $_GET['do'] == "new" && isset($_GET['user'])){
    echo "<div id='shownew'><a href='Home.php?page=private&do=show' class='pmsg'>Show conversations</a> | ";
    echo "<a href='Home.php?page=private&do=new' class='pmsg'>New conversation</a><br/>";
    echo "Sending message to user ". $_GET['user'] .".</div>";
        $convo = new msgs();
        $convo->setUserID($_SESSION['UserID']);
        $convo->setRecptID($_GET['user']);
        $convo->CheckValidConvo("no");
    ?>
<form method="POST">
    <?php
    if(isset($_POST['message']) && !empty($_POST['message'])){
        $convo = new msgs();
        $convo->setUserID($_SESSION['UserID']);
        $convo->setRecptID($_GET['user']);
        $convo->setMessage($_POST['message']);
        $convo->CheckValidConvo("yes");
        $convo->InsertConvoMsg();
    } else {
        //echo "Empty message.";
    }
    ?>
    <textarea name="message" rows="7" cols="60" class="privText" id="sendPrivate1"></textarea>
    <input type="submit" value="Send message" class="inputSend" id="inputSend1"/>
</form>
    
<?php    
} elseif(isset($_GET['do']) && $_GET['do'] == "new"){
    echo "<div id='shownew'><a href='Home.php?page=private&do=show' class='pmsg'>Show conversations</a> | ";
    echo "<a href='Home.php?page=private&do=new' class='pmsg'>New conversation</a></div>";
    ?>
    <br/>
    
    <div id="content1" class="text-center">
        <div class="col-xs-12">
            <form class="navbar-form" role="search">
            <div class="input-group">
                <input type="text" class="form-control search1" placeholder="Search" id="searchid1"> <!-- name="q"-->
                <div class="input-group-btn">
                    <button class="btn btn-default" type="submit" id="finduser1"><i class="glyphicon glyphicon-search"></i></button>
                </div>
            </div>
            </form>
            <div id="result1"></div>
        </div>      
    </div>
<?php
}  else {
    echo "<div id='shownew'><a href='Home.php?page=private&do=show' class='pmsg'>Show conversations</a> | ";
    echo "<a href='Home.php?page=private&do=new' class='pmsg'>New conversation</a><br/>";
   
    $showConvoNames = new msgs();
    $showConvoNames->setUserID($_SESSION['UserID']);
    $showConvoNames->ShowAllConvos();
    echo "</div>";
}
?>