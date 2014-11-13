<?php
include 'conn.php';
include_once 'class.php';
if($_POST['search1']){
    $q = $_POST['search1'];
    $a = "%".$_POST['search1']."%";
    $strSQL_Result = $stmt->prepare("SELECT * FROM users WHERE Username LIKE :find ORDER BY UserID LIMIT 5");
    $strSQL_Result->execute(array('find' => $a));
    $rows = $strSQL_Result->rowCount();
    if ($rows >= 1){
        while($row = $strSQL_Result->fetch()){
            $username = $row['Username'];
            $b_username = '<strong>'.$q.'</strong>';
            $final_username = str_ireplace($q, $b_username, $username);
            ?>
            <div class="show1" align="left">
                <img alt="profilepic" src="<?php $getPic = new user(); $getPic->FindPic($row['UserID'], "2"); ?>" style="width:30px; height:30px; float:left; margin-right:6px;" /><span class="name1"><?php echo $final_username; ?></span>&nbsp;<br/><?php echo $final_email; ?><br/>
            </div>
            <?php
        }        
    }
    else {
        ?>
        <div class="show1" align="left">
            <img alt="profilepic" src="http://www.madisonfund.org/wp-content/uploads/2011/06/Empty-Face.jpg" style="width:30px; height:30px; float:left; margin-right:6px;" /><span class="name1"><?php echo "No users found"; ?></span>&nbsp;<br/><?php echo $final_email; ?><br/>
        </div>
        <?php 
    }
}elseif($_POST['Profile']){
    $find_id = $stmt->prepare("SELECT * FROM users WHERE Username = :uname");
    $find_id->execute(array('uname' => $_POST['Profile']));
    $getid = $find_id->fetch();
    echo $getid['UserID'];
}
?>