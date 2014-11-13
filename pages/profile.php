<?php
if(isset($_GET['view']) && !empty($_GET['view'])/* && is_numeric($_GET['view'])*/){
    include_once 'class.php';
    echo "<br/>";
    $view = new user();
    $view->setProfile($_GET['view']);
    $view->viewProfile();
    $view->setUserID($_SESSION['UserID']);
    if($view->CheckAdmin()){
        $view->delUser();
    }
   
} elseif(isset($_GET['remove']) && $_GET['remove'] == 'user' && isset($_GET['user'])){
    include_once 'class.php';
    $a = new user();
    $a->setUserID($_SESSION['UserID']);
    $a->setProfile($_GET['user']);
    if($a->CheckAdmin()){
        //echo "ok";
       $a->removeUser();
    } else {
        echo "Access denied.";
    }
} elseif(isset($_GET['error']) && $_GET['error'] == 1){
    echo "<span style='color:red;'>Empty fields.</span>";
} elseif(isset($_GET['success']) && $_GET['success'] == 1){
    echo "<span style='color:green;'>Profile picture successfully changed.</span>";
} else {
    include_once 'class.php';
?>
<div id="ResetPass">
    <span class="ChangeProf">CHANGE PASSWORD</span>
    <form method="post" action="pages/ResetPass.php">
        <label>Old password:</label>
        <input type="password" name="OldPassword"><br/>
        <label>New password:</label>
        <input type="password" name="NewPassword"><br/>
        <label>Re-type password:</label>
        <input type="password" name="NewPassword1"><br/>
        <label class='change'><button type="submit">Change</button></label><br/>
    </form>
</div>
<br/><br/>
<div class="ChangeProf">
    <?php 
    $a = new user();
    $a->ProfilePic($_SESSION['UserID']);
    ?>
    CHANGE PROFILE PICTURE
    <form enctype="multipart/form-data" action="pages/ChangePIC.php" method="POST">
        Select picture: <input name="file" type="file" accept="image/*"/>
        <input type='hidden' name='UserID' value='<?php echo $_SESSION['UserID']; ?>'>
        <input type="submit" value="Change"/>
    </form>
    Maximum size: 5mb <br/>
    Allowed extensions: .png, .jpg, .jpeg, .gif
</div>
<?php
}
?>