<div class="text-center">

    <?php
    include 'conn.php';
    include_once 'class.php';
    if(empty($_GET['q'])){
        echo "Empty search";
    } else {
        
        if(isset($_GET['q']) && !empty($_GET['q'])){
            $q = $_GET['q'];
            $a = "%".$_GET['q']."%";
            $strSQL_Result = $stmt->prepare("SELECT * FROM users WHERE Username LIKE :find ORDER BY UserID LIMIT 10");
            $strSQL_Result->execute(array('find' => $a));
            $rows = $strSQL_Result->rowCount();
            if ($rows >= 1){
                while($row = $strSQL_Result->fetch()){
                    $username = $row['Username'];
                    $b_username = '<strong>'.$q.'</strong>';
                    $final_username = str_ireplace($q, $b_username, $username);
                    ?>
                    <div class="show" align="left">
                        <a href="Home.php?page=profile&view=<?php echo $username; ?>"><img alt="profilepic" src="<?php $getPic = new user(); $getPic->FindPic($row['UserID'], "1"); ?>" style="width:30px; height:30px; float:left; margin-right:6px;" /><span class="name"><?php echo $final_username; ?></span>&nbsp;<br/><?php echo $final_email; ?></a><br/>
                    </div>
                    <?php
                } 
            } else {
                echo "No users found";
            }
        }
        
    }
    ?>
    
</div>