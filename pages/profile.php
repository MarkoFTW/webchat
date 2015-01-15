<div class="row">
    <div class="col-sm-4 col-md-3 sidebar" id="sidebar1">
        <div class="list-group">
            <a href="Home.php?page=profile" class="list-group-item active">
                UserCP
            </a>
            <a href="Home.php" class="list-group-item">
                <i class="fa fa-comment-o"></i> Chat
            </a>
            <a href="Home.php?q=a" class="list-group-item">
                <i class="fa fa-search"></i> Search
            </a>
            <a href="Home.php?page=private" class="list-group-item">
                <i class="fa fa-envelope"></i> Messages <span class="badge"><?php $m = new Profile(); $m->setUserID2($_SESSION['UserID']); $m->showMessages(); ?></span>
            </a>
            <a href="#" data-toggle="collapse" data-target="#sub1" class="list-group-item"><i class="fa fa-user"></i> Settings <b class="caret"></b></a>
            <ul class="nav collapse" id="sub1">
                  <li><a href="Home.php?page=profile&a=email" class="list-group-item"><i>Email & Password</i></a></li>
                  <li><a href="Home.php?page=profile&a=settings" class="list-group-item"><i>Edit profile</i></a></li>
            </ul>
        </div>
    </div>
    <div class="col-md-8" id="profSettings">
        <?php
        if(isset($_GET['a']) && $_GET['a'] == "chat"){
            echo "chat";
        }elseif(isset($_GET['a']) && $_GET['a'] == "search"){
            echo "search";
        /*}elseif(isset($_GET['a']) && $_GET['a'] == "messages"){
            echo "msg";*/
        } elseif(isset($_GET['remove']) && $_GET['remove'] == 'user' && isset($_GET['user'])){
            include_once 'class.php';
            $a = new user();
            $a->setUserID($_SESSION['UserID']);
            $a->setProfile($_GET['user']);
            if($a->CheckAdmin()){
               $a->removeUser();
            } else {
                echo "Access denied.";
            }
        }elseif(isset($_GET['view']) && !empty($_GET['view'])){
            ?>
        <div id='profilepic'><img alt='profile' height='150' width='150' src="<?php $pic = new user(); $pic->findID($_GET['view']); $pic->FindPic($pic->getProfile(), 1); ?>"/></div>
            <?php 
            echo "<h1 style='color:white;'>" . $_GET['view'] . "</h1>";
            echo "<div id='sendMsg'><form action='Home.php' method='get'>";
            echo "<input type='hidden' name='page' value='private'>";
            echo "<input type='hidden' name='do' value='new'>";
            echo "<input type='hidden' name='user' value='".$pic->getProfile()."'>";
            echo "<input type='submit' class='btn btn-info btn-xs' value='Send message'/>";
            echo "</form></div>";
            $p = new Profile();
            $p->showFullProfile($_GET['view']);
            $pic->setProfile($_GET['view']);
            $pic->setUserID($_SESSION['UserID']);
            if($pic->CheckAdmin()){
                $pic->delUser();
            }
        /*}elseif(isset($_GET['a']) && $_GET['a'] == "files"){
            echo "files";*/
        }elseif(isset($_GET['a']) && $_GET['a'] == "settings"){
            ?>
        <div id="ChangeProf">
            <?php 
            $pic = new user();
            $pic->ProfilePic($_SESSION['UserID']);
            ?>
            <br/><h4 style="color:white;"><b>Change profile picture:</b></h4>
            <form enctype="multipart/form-data" action="pages/ChangePIC.php" method="POST">
                Select picture: <input name="file" type="file" accept="image/*"/>
                <input type='hidden' name='UserID' value='<?php echo $_SESSION['UserID']; ?>'>
                <input type="submit" class="btn btn-primary btn-load btn-sm" data-loading-text="Changing picture..." value="Change picture"/>
            </form>
            Maximum size: 5mb <br/>
            Allowed extensions: .png, .jpg, .jpeg, .gif<br/><br/>
            <?php
                if(isset($_GET['success']) && $_GET['success'] == 1 && $_GET['a'] == "settings"){
                    echo '<p><span style="color:green">Display picture successfully changed.</span></p>';  
                } elseif(isset($_GET['error']) && $_GET['error'] == 1 && $_GET['a'] == "settings"){
                    echo '<p><span style="color:red">Please select a display picture.</span></p>';
                }
            ?>
              
            <br/><br/>
            
            <h4 style="color:white;"><b>Turn censor on or off:</b></h4>
            <form method="post" action="pages/settings.php">
                <input type="radio" name="censor" value="on" <?php if(Profile::censorOpt($_SESSION['UserID']) == "1") { echo " checked"; } ?>>On
                <input type="radio" name="censor" value="off" <?php if(Profile::censorOpt($_SESSION['UserID']) == "0") { echo " checked"; }?>> Off<br/>
                <input type="submit" class="btn btn-primary btn-load btn-sm" data-loading-text="Changing censor..." value="Change censor">
            </form>
        </div>
        
        <?php
       
        }elseif(isset($_GET['a']) && $_GET['a'] == "email"){
         ?>
        <h3 style="color:white;"><b>Email & Password</b></h3>
        <h4>Email Address</h4>
        Current email address: <?php echo $_SESSION['Email'] ?><br/><br/>
        <div class="row">      
            <div class="col-sm-6 col-sm-offset-0">
                <form method="post" id="emailForm" action="pages/ResetEmail.php">
                    <input type="password" class="input-sm form-control" name="passwordCurrE" id="passwordCurrE" placeholder="Current Password" autocomplete="off" required><br/>
                    <input type="text" class="input-sm form-control" name="email1" id="email1" placeholder="New email" autocomplete="off" required>
                    <input type="text" class="input-sm form-control" name="email2" id="email2" placeholder="Confirm new email" autocomplete="off" required>
                    <input type="submit" class="col-xs-12 btn btn-primary btn-load btn-sm" data-loading-text="Changing email..." value="Change email">
                </form>
            </div><!--/col-sm-6-->
        </div><!--/row-->
        
        <br/>
            <?php
                if(isset($_GET['success']) && $_GET['success'] == 1 && $_GET['a'] == "email"){
                    echo '<p><span style="color:green">Email has been updated.</span></p>';  
                } elseif(isset($_GET['error']) && $_GET['error'] == 1 && $_GET['a'] == "email"){
                    echo '<p><span style="color:red">Inserted emails do not match.</span></p>';
                } elseif(isset($_GET['error']) && $_GET['error'] == 2 && $_GET['a'] == "email"){
                    echo '<p><span style="color:red">Please fill the empty fields.</span></p>';
                } elseif(isset($_GET['error']) && $_GET['error'] == 3 && $_GET['a'] == "email"){
                    echo '<p><span style="color:red">Entered password does not match with your current password.</span></p>';
                }
            ?>
        <br/>
        <h4><b>Password</b></h4>
        We will attempt to update your current session after your successful password change. If, however, you do experience difficulties, please try signing out and signing back in before contacting a staff member to help resolve the problem.<br/>
        Password validation is not required, but is recommended to use.<br/><br/>
        <div class="row">      
            <div class="col-sm-6 col-sm-offset-0">
                <form method="post" id="passwordForm" action="pages/ResetPass.php">
                    <input type="password" class="input-sm form-control" name="passwordCurr" id="passwordCurr" placeholder="Current Password" autocomplete="off" required><br/>
                    <input type="password" class="input-sm form-control" name="password1" id="password1" placeholder="New Password" autocomplete="off" required>
                    <div class="row">
                    <div class="col-sm-6">
                        <span id="8char" class="glyphicon glyphicon-remove" style="color:#FF0004;"></span> 8 characters long<br>
                        <span id="ucase" class="glyphicon glyphicon-remove" style="color:#FF0004;"></span> One uppercase letter
                    </div>
                    <div class="col-sm-6">
                        <span id="lcase" class="glyphicon glyphicon-remove" style="color:#FF0004;"></span> One lowercase letter<br>
                        <span id="num" class="glyphicon glyphicon-remove" style="color:#FF0004;"></span> One number
                    </div>
                    </div>
                    <input type="password" class="input-sm form-control" name="password2" id="password2" placeholder="Confirm new password" autocomplete="off" required>
                    <div class="row">
                    <div class="col-sm-12">
                        <span id="pwmatch" class="glyphicon glyphicon-remove" style="color:#FF0004;"></span> Passwords match
                    </div>
                    </div>
                    <input type="submit" class="col-xs-12 btn btn-primary btn-load btn-sm" data-loading-text="Changing password..." value="Change password">
                </form>
            </div><!--/col-sm-6-->
        </div><!--/row-->
        <br/>
            <?php
                if(isset($_GET['success']) && $_GET['success'] == 2 && $_GET['a'] == "email"){
                    echo '<p><span style="color:green">Password has been updated.</span></p>';  
                } elseif(isset($_GET['error']) && $_GET['error'] == 4 && $_GET['a'] == "email"){
                    echo '<p><span style="color:red">Your current password does not match.</span></p>';
                } elseif(isset($_GET['error']) && $_GET['error'] == 5 && $_GET['a'] == "email"){
                    echo '<p><span style="color:red">New passwords do not match.</span></p>';
                }
            ?>
        <br/>
        <?php
        } else {
        ?>
        <div id='profilepic'><img alt='profile' height='150' width='150' src="<?php $pic = new user(); $pic->FindPic($_SESSION['UserID'], 1); ?>"/></div>
            <?php 
            echo "<h1 style='color:white;'>" . $_SESSION['Username'] . "</h1>";
            $p = new Profile();
            $p->showFullProfile($_SESSION['Username']);
        }
        ?>
    </div><!--sidebar-->
</div><!--/row-->