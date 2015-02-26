<?php
include_once 'class.php';
if(isset($_GET['do']) && $_GET['do'] == "show" && isset($_GET['hash'])){
    $hashloc = new msgs();
    if($hashloc->findHash($_GET['hash'])){
        echo "<div id='shownew'><a href='Home.php?page=private&do=show' class='pmsg'>Show conversations</a> | ";
        echo "<a href='Home.php?page=private&do=new' class='pmsg'>New conversation</a></div>";
        ?>
        <div id="dlCONVO">
            <form method="post" action="pages/convoDL.php">
                <input type="hidden" name="hash" value="<?php echo $_GET['hash']; ?>">
                <input type="submit" class="btn btn-primary btn-load btn-sm" data-loading-text="Downloading..." value="Download conversation">
            </form>
        </div>
        <?php
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
        header('Location: '.$_SERVER['REQUEST_URI']);        
    }
    ?>
    <textarea name="message" rows="7" cols="60" class="privText" id="sendPrivate"></textarea>
    <input type="submit" value="Send message" class="inputSend" id="inputSend"/>
</form>
<?php
} elseif(isset($_GET['do']) && $_GET['do'] == "new" && isset($_GET['user'])){
    if(empty(htmlspecialchars($_GET['user']))){
        echo 'Error: username not found.';
        header("Location: Home.php?page=private&do=new");
    } else {
        echo "<div id='shownew'><a href='Home.php?page=private&do=show' class='pmsg'>Show conversations</a> | ";
        echo "<a href='Home.php?page=private&do=new' class='pmsg'>New conversation</a><br/>";
        echo "Sending message to ". replaceID($_GET['user']) .".</div>";
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
            //echo "Empty message";
        }
        ?>
        <textarea name="message" rows="7" cols="60" class="privText" id="sendPrivate1"></textarea>
        <input type="submit" value="Send message" class="inputSend" id="inputSend1"/>
    </form>

    <?php    
    }
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
    
    if(isset($_GET['success']) && $_GET['success'] == 1){
        echo '<p><span style="color:green">Chat history has been generated, downloading...</span></p>';  
    } elseif(isset($_GET['error']) && $_GET['error'] == 1){
        echo '<p><span style="color:red">Error</span></p>';
    }
    
    echo "</div>";
      
}
?>