<!DOCTYPE html>

<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
        <meta charset="UTF-8">
        <title>Webchat - Home</title>
        <script src="js/jquery211.js"></script>
        <link rel="stylesheet" href="css/bootstrap.css">
        <link rel="stylesheet" href="css/bootstrap-theme.css">
        <script src="js/bootstrap.js"></script>
        <script src="js/functions.js"></script>
        <link rel="stylesheet" href="css/homeStyle.css">
        <script type="text/javascript">
            $(document).ready(function(){
                $("#privMsg, #ChatMessages").animate({ scrollTop: "+=5000000" }, "slow");
            });
        </script>
        <?php
        if($_GET['page'] == "country" || $_GET['page'] == "social"){
            echo '<script src="http://code.highcharts.com/highcharts.js"></script';
            echo '<script src="http://code.highcharts.com/modules/exporting.js"></script>';
            echo '<script src="js/charts.js" type="text/javascript"></script>';
        }
        ?>
        
        <?php
            session_start();
            if(!isset($_SESSION['UserID']) && empty($_SESSION['UserID'])) {
                header("Location: index.php");
            }
        ?>
    </head>
    <body>
        <div id="hiddenOnline"></div>
        <div class="navbar navbar-inverse navbar-fixed-top">
            <div class="container">
                
                <button class="navbar-toggle" data-toggle="collapse" data-target="#navHeaderCollapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                
                <div class="collapse navbar-collapse" id="navHeaderCollapse">
                    <ul class="nav navbar-nav navbar-left">
                        <li><a href="Home.php">Home</a></li>
                        <li><a href="Home.php?page=profile">Profile</a></li>
                        <li><a href="Home.php?page=private">Messages</a></li>
                        <li class="dropdown">
                            
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Statistics<b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <li><a href="Home.php?page=country">Country</a></li>
                                <li><a href="Home.php?page=social">Social login</a></li>
                            </ul>
                            
                        </li>
                        <?php
                            include 'pages/class.php';
                            $id = new user();
                            $id->setUserID($_SESSION['UserID']);
                            if($id->CheckAdmin()){
                                echo "<li><a href='Home.php?page=admincp'>AdminCP</a></li>";
                            }
                        ?>
                    </ul>
                    
                    <div class="col-sm-3 col-md-3">
                        <form class="navbar-form" role="search">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Search users" name="q">
                            <div class="input-group-btn">
                                <button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
                            </div>
                        </div>
                        </form>
                    </div>
                    
                    <ul class="nav navbar-nav navbar-right">
                        
                        <?php
                            if(isset($_SESSION['Username'])) {
                                echo '<li><a href="#" id="UserProfile">Logged in as '. $_SESSION['Username'] .'</a></li>';
                                if(isset($_SESSION) && $_SESSION['Type'] == 2) {
                                    echo '<li><a href="#Logout" id="LogoutUser">Logout</a></li>';
                                } else {
                                    echo '<li><a href="#Logout" id="LogoutUser">Logout</a></li>';
                                }
                            } 
                        ?> 
                    </ul>
                </div>                
            </div>
        </div>
        
        
        <div class="container" id="ContMove">
            
            <div class="row">
                
                <?php
                    if(isset($_GET['page']) && $_GET['page'] == "profile"){
                        include 'pages/profile.php';
                    } elseif(isset($_GET['page']) && $_GET['page'] == "private"){
                        include 'pages/pmsg.php';
                    } elseif(isset($_GET['page']) && $_GET['page'] == "country" || $_GET['page'] == "social"){
                        include 'pages/stats.php';
                    } elseif(isset($_GET['q'])){
                        include 'pages/searchUsers.php'; 
                    } elseif(isset($_GET['page']) && $_GET['page'] == "admincp"){
                        include 'pages/admincp.php';
                        //echo "admincp";
                    } else {

                    ?>
                
                
                <div class="col-xs-10">
                    <div id="ChatBig">
                        <?php
                            if(isset($_GET['success']) && $_GET['success'] == 1){
                        ?>
                        <p>
                            <span style="color:green">Password sucessfully changed</span>
                        </p>                 
                        <?php
                            }
                        ?>
                        <?php
                            if(isset($_GET['error']) && $_GET['error'] == 1){
                        ?>
                        <p>
                            <span style="color:red">Wrong password</span>
                        </p>                 
                        <?php
                            }
                        ?>
                        <div id="ChatMessages">
                        </div>
                        <textarea id="ChatText" name="Message" placeholder="Enter message..."></textarea>

                    </div>
                </div>
                <div class="col-xs-2">
                    
                    <div id="OnlineList">
                        <span style="font-weight: bold;">Users online</span>
                        <div id="ListOnlineUsers">

                        </div>  
                    </div>
                    
                </div>
                
            </div>
            
        </div>
        
        <?php
        }
        ?>
        
    </body>
</html>
