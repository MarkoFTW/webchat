<?php
include_once 'class.php';
$a = new user();
$a->setUserID($_SESSION['UserID']);
    if($a->CheckAdmin()) {
        echo "<div class='container' id='adminCP'>";
        User::listCensor();
        ?>
        <br/><br/><br/>
        <h4 style='color:white;'><b>Add censored words:</b></h4>
        <form method="POST" action="pages/admincp.php">
            Word: <input class='form-control' type="text" name="a" value="Example"><br/>
            Censor: <input class='form-control' type="text" name="b" value="Ex**ple"><br/>
            <input type="submit" class="btn btn-primary btn-load btn-sm" data-loading-text="Adding censor..." value="Add censor">
        </form>
        <?php
        echo "</div>";
        if(isset($_GET['d']) && !empty($_GET['d'])){
            $a->remCensor($_GET['d']);
        } elseif (isset($_POST['a']) && !empty($_POST['a'])){
            $a->addCensor($_POST['a'], $_POST['b']);
            header("Location: ../Home.php?page=admincp");
        }
    } else {
        echo "access denied";
    }
?>