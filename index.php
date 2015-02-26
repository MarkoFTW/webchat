<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Webchat</title>
        <script src="js/jquery211.js" type="text/javascript"></script>
        <link href="css/style.css" type="text/css" rel="stylesheet"/>
        <?php
            session_start();
            if(isset($_SESSION['UserID'])) {
                header("Location: Home.php");
            }
            include_once "fb/autoload.php"; 
            include 'pages/class.php';
        ?>
        <script type="text/javascript">
            $(document).ready(function(){

                $("#SignUpDiv").hide();
                $("#resetDiv").hide();
                $("#AccNotUsed, #createAcc").click(function(){
                    $("#SignUpDiv").fadeIn();
                    $("#LoginDiv").fadeOut();
                    $("#resetDiv").fadeOut();
                });
                $("#AccUsed, #loginAcc").click(function(){
                    $("#LoginDiv").fadeIn();
                    $("#SignUpDiv").fadeOut();
                    $("#resetDiv").fadeOut();
                });
                $("#ForgotPW, #ForgotPW1").click(function(){
                    $("#resetDiv").fadeIn();
                    $("#SignUpDiv").fadeOut();
                    $("#LoginDiv").fadeOut();
                });


            });
        </script>
    </head>
    <body>
        <?php
            use Facebook\FacebookSession;
            use Facebook\FacebookRedirectLoginHelper;
            use Facebook\FacebookRequest;
            use Facebook\FacebookResponse;
            use Facebook\FacebookSDKException;
            use Facebook\FacebookRequestException;
            use Facebook\FacebookAuthorizationException;
            use Facebook\GraphObject;
            use Facebook\GraphUser;
            use Facebook\GraphLocation;
            use Facebook\GraphSessionInfo;  
            use Facebook\FacebookHttpable;
            use Facebook\FacebookCurl;
            use Facebook\FacebookCurlHttpClient;

            $id = '1426129404321538';
            $secret = 'c282f609eeaecc35914427b8c2920769';

            FacebookSession::setDefaultApplication($id, $secret);

            $helper = new FacebookRedirectLoginHelper('http://devps1.marefx.com/webchat/index.php');
            try{
                $session = $helper->getSessionFromRedirect();
            }catch(Exception $e){
                echo $e->getMessage();
            }

            if(isset($_SESSION['token'])){
                $session = new FacebookSession($_SESSION['token']);
                try{
                    $session->Validate($id, $secret);
                }catch(FacebookAuthorizationException $e){
                    $session = '';
                }
            }

            if(isset($session)){
                try {
                    $_SESSION['token'] = $session->getToken();
                    echo "Login Successful<br>";
                    $request = new FacebookRequest($session, 'GET', '/me');
                    $response = $request->execute();
                    $graphObject = $response->getGraphObject(GraphUser::className());
                    
                    if(checkFBexist($graphObject->getProperty('id'))){
                        $ins = new user();
                        $ins->setEmail($graphObject->getProperty('id'));
                        $ins->UserLoginFB();
                        
                        $_SESSION['UserID'] = $ins->getUserID();
                        $_SESSION['Username'] = $ins->getUsername();
                        $_SESSION['Email'] = $ins->getEmail();
                        $_SESSION['Type'] = $ins->getType();
                        
                        echo "exists";
                    } else {
                        $ins = new user();
                        $ins->setUsername($graphObject->getName());
                        $ins->setEmail($graphObject->getProperty('id'));
                        $ins->setIP($_SERVER['REMOTE_ADDR']);
                        $ins->InsertUserFB();
                        $ins->UserLoginFB();
                        
                        $_SESSION['UserID'] = $ins->getUserID();
                        $_SESSION['Username'] = $ins->getUsername();
                        $_SESSION['Email'] = $ins->getEmail();
                        $_SESSION['Type'] = $ins->getType();
                        
                        echo "new";
                    }
                    /*echo "ID: " . $graphObject->getProperty('id');
                    echo "<br/>Name: " . $graphObject->getName();
                    echo "<br/>Gender: " . $graphObject->getProperty('gender');
                    echo "<br/>Link: " . $graphObject->getProperty('link');
                    echo "<br/>Locale: " . $graphObject->getProperty('locale');*/
                    
                    //echo '<pre>' . print_r( $graphObject, 1 ) . '</pre>';
                    
                    echo "<a href = " . $helper->getLogoutUrl( $session , 'http://devps1.marefx.com/webchat/fb/logout.php' ) . ">Logout</a>";
                    
                }catch(FacebookRequestException $e) {
                    echo "Exception occured, code: " . $e->getCode();
                    echo " with message: " . $e->getMessage();
                }  
            }else{
                
        ?>
        <div id="LoginDiv">
            <h1>LOGIN</h1>
            <form method="post" action="pages/UserLogin.php" class="login">               
                <p>
                  <label>Email:</label>
                  <input type="text" name="UserMailLogin" placeholder="user@example.com">
                </p>

                <p>
                  <label>Password:</label>
                  <input type="password" name="UserPasswordLogin" value="">
                </p>

                <p class="login-submit">
                  <button type="submit" class="login-button">Login</button>
                </p>
                <p class="CreatingLogin">
                  <button type="button" id="AccNotUsed"><span>Create new account</span></button>
                  <button type="button" id="ForgotPW"><span>Forgotten password?</span></button>
                  <?php echo "<a href = '" . str_replace("&","&amp;",$helper->getLoginUrl()) . "'><img style='position:relative; top: 4px;' width='55' alt='fblogin' src='img/fblogin.png'/></a>"; ?>
                  <!--<button type="button" id =FBLogin><span><img src="http://d2fnoh68uhxcn9.cloudfront.net/ND/img/fb-login-button.png" alt="fblogin" width="20" height="20"/></span></button>-->
                </p>
                <?php
                    if(isset($_GET['error']) && $_GET['error'] == 1){
                        echo '<p><span style="color:red">Login error, email or password does not match</span></p>';
                    }elseif(isset($_GET['error']) && $_GET['error'] == 2){
                        echo '<p><span style="color:red">Error creating account, passwords do not match</span><p>';
                    }elseif(isset($_GET['error']) && $_GET['error'] == 3){
                        echo '<p><span style="color:red">No matching accounts found</span></p>';
                    }elseif(isset($_GET['error']) && $_GET['error'] == 4){
                        echo '<p><span style="color:red">Empty fields</span></p>';
                    }elseif(isset($_GET['error']) && $_GET['error'] == 5){
                        echo '<p><span style="color:red">Email already in use!</span></p>';
                    }elseif(isset($_GET['error']) && $_GET['error'] == 6){
                        echo '<p><span style="color:red">Username already in use!</span></p>';
                    }elseif(isset($_GET['error']) && $_GET['error'] == 7){
                        echo '<p><span style="color:red">Invalid email</span></p>';
                    }elseif(isset($_GET['success']) && $_GET['success'] == 1){
                        echo '<p><span style="color:green">Registration successfull</span></p>';
                    }elseif(isset($_GET['success']) && $_GET['success'] == 2){
                        echo '<p><span style="color:green">Password reset successfull, please check your Inbox and Junk folder</span></p>';
                    }
                ?>
            </form>
        </div>
       
        <br/><br/><br/>
        
        <div id="SignUpDiv">
            <h1>REGISTER</h1>
            <form method="post" action="pages/InsertUser.php" class="login">
                <p>
                    <label>Username:</label>
                    <input type="text" name="Username" placeholder="John">
                </p>
                <p>
                    <label>Email:</label>
                    <input type="text" name="Email" placeholder="user@example.com">
                </p>
                <p>
                    <label>Password:</label>
                    <input type="password" name="Password" value="">
                </p>
                <p>
                    <label>Re-type:</label>
                    <input type="password" name="Password1" value="">
                </p>
                <p class="login-submit">
                    <button type="submit" class="login-button">Login</button>
                </p>
                <p class="CreatingLogin">
                    <button type="button" id="AccUsed"><span>Login with existing user</span></button>
                    <button type="button" id="ForgotPW1"><span>Forgotten password?</span></button>
                </p>
            </form>
        </div>
        
        <div id="resetDiv">
            <h1>RESET PASSWORD</h1>
            <form method="post" action="pages/ForgotPassword.php" class="login">
                <p>
                    <label>Username:</label>
                    <input type="text" name="myUser" placeholder="John">
                </p>
                <p>
                    <label>or Email:</label>
                    <input type="text" name="myEmail" placeholder="user@example.com">
                </p>
                <p class="login-submit">
                    <button type="submit" class="login-button">Reset</button>
                </p>
                <p class="CreatingLogin">
                  <button type="button" id="createAcc"><span>Create new account</span></button>
                  <button type="button" id="loginAcc"><span>Login with existing user</span></button>
                </p>
            </form>
        </div>       
        <?php } ?>
    </body>
</html>
