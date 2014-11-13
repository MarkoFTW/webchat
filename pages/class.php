<?php
function BBCodes($text) {
    $bb_codes = array(
        "/\[u\](.*?)\[\/u\]/is" => "<u>$1</u>",
        "/\[i\](.*?)\[\/i\]/is" => "<i>$1</i>",
        "/\[d\](.*?)\[\/d\]/is" => "<del>$1</del>",
        "/\[url=(.*?)\](.*?)\[\/url\]/is" => "<a href='$1'>$2</a>",
        "/\[b\](.*?)\[\/b\]/is" => "<b>$1</b>",
        "/\[img](.*?)\[\/img\]/is" => "<img src='$1' height='100' width='100' draggable='false'/>"
        //ahref
    );
    $text = preg_replace(array_keys($bb_codes), array_values($bb_codes), $text);
    return $text;
}

function smileys($msg){
    include 'conn.php';
    $emoteQuery = $stmt->prepare("SELECT * FROM emoticons");
    $emoteQuery->execute();
    while ($emote = $emoteQuery->fetch()) {
        $msg = str_replace($emote['Emote'],"<img src=./img/smileys/".$emote['Picture']." alt='".$emote['Emote']."' width='30' heigh='30'>",$msg);
    }
    return $msg;
}

function censorReplace($text) {
    include 'conn.php';
    $censorQuery = $stmt->prepare("SELECT * FROM censor");
    $censorQuery->execute();
    while ($censor = $censorQuery->fetch()) {
        $text = str_replace($censor['Word'],$censor['Replacement'],$text);
    }
    return $text;
}

function checkFBexist($id) {
    include 'conn.php';
    $check_fb = $stmt->prepare("SELECT * FROM users WHERE Email = :my_id AND Type = :type");
    $check_fb->execute(array(
        'my_id' => $id,
        'type' => "2"
    ));
    while($getID = $check_fb->fetch()){
        if($getID['Email'] == $id){
            return true;
        } else {
            return false;
        }
    }
}
        
class user{
    private $UserID,$Username,$Email,$Password,$Password1,$OldPassword,$Profile,$IP,$Country,$Type;
    
    public function getUserID(){
        return $this->UserID;
    }
    public function setUserID($UserID){
        $this->UserID = $UserID;
    }
    
    public function getUsername(){
        return $this->Username;
    }
    public function setUsername($Username){
        $this->Username = $Username;
    }

    public function getEmail(){
        return $this->Email;
    }
    public function setEmail($Email){
        $this->Email = $Email;
    }

    public function getIP(){
        return $this->IP;
    }
    public function setIP($IP){
        $this->IP = $IP;
    }
    
    public function getType(){
        return $this->Type;
    }
    public function setType($Type){
        $this->Type = $Type;
    }
    
    public function getCountry(){
        return $this->Country;
    }
    public function setCountry($Country){
        $this->Country = $Country;
    }
    
    public function getPassword(){
        return $this->Password;
    }
    public function setPassword($Password){
        $this->Password = $Password;
    }

    public function getPassword1(){
        return $this->Password1;
    }
    public function setPassword1($Password1){
        $this->Password1 = $Password1;
    }
    
    public function getOldPassword(){
        return $this->OldPassword;
    }
    public function setOldPassword($OldPassword){
        $this->OldPassword = $OldPassword;
    }
      
    public function getProfile(){
        return $this->Profile;
    }
    public function setProfile($Profile){
        $this->Profile = $Profile;
    }
    
    public function InsertUser(){
        if($this->getPassword() == $this->getPassword1()) {
            try {
                $this->FindCountry($this->getIP());
                include "conn.php";
                $req = $stmt->prepare("INSERT INTO users(Username,Email,Password,Access,IP_ADDR,Country,Type,Created) VALUES (:Username,:Email,:Password,:Access,:ip,:country,:type,NOW())");
                $req->execute(array(
                    'Username' => $this->getUsername(),
                    'Email' => $this->getEmail(),
                    'Password' => $this->getPassword(),
                    'Access' => "1",
                    'ip' => $this->getIP(),
                    'country' => $this->getCountry(),
                    'type' => "1"
                    ));
                header("Location: ../index.php?success=1");
            }  catch (PDOException $e) {
                echo $e->getMessage();
            }
        } else { header("Location: ../index.php?error=2"); }
    }
    
    public function InsertUserFB(){
        try {
            $this->FindCountry($this->getIP());
            include "conn.php";
            $req = $stmt->prepare("INSERT INTO users(Username,Email,Access,IP_ADDR,Country,Type,Created) VALUES (:Username,:Email,:Access,:ip,:country,:type,NOW())");
            $req->execute(array(
                'Username' => $this->getUsername(),
                'Email' => $this->getEmail(),
                'Access' => "1",
                'ip' => $this->getIP(),
                'country' => $this->getCountry(),
                'type' => "2"
				));
        }  catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function UserLogin(){
        include "conn.php";
        $req = $stmt->prepare("SELECT * FROM users WHERE Email=:Email AND Password=:Password");
        $req->execute(array(
            'Email' => $this->getEmail(),
            'Password' => $this->getPassword()
            ));
        if ($req->rowcount() == 0) {
            header("Location: ../index.php?error=1");
            return false;
        } else {
            while ($data = $req->fetch()) {
                
                $this->setUserID($data['UserID']);
                $this->setUsername($data['Username']);
                $this->setPassword($data['Password']);
                $this->setEmail($data['Email']);
                $this->setType("1");
                
                header("Location: ../Home.php");
                return true;
            }
        }
    }
    
    public function UserLoginFB(){
        include "conn.php";
        $req = $stmt->prepare("SELECT * FROM users WHERE Email=:id AND Type = :type");
        $req->execute(array(
            'id' => $this->getEmail(),
            'type' => "2"
            ));
        if ($req->rowcount() == 0) {
            header("Location: ../index.php?error=1");
            return false;
        } else {
            while ($data = $req->fetch()) {
                
                $this->setUserID($data['UserID']);
                $this->setUsername($data['Username']);
                $this->setEmail($data['Email']);
                $this->setType("2");
                
                header("Location: Home.php");
                return true;
            }
        }
    }
    
    public function ChangePass(){
        include 'conn.php';
        $ChangePW = $stmt->prepare("SELECT * FROM users WHERE UserID = :UserID");
        $ChangePW->execute(array('UserID' => $this->getUserID()));
        $PWInfo = $ChangePW->fetch();
        if($this->getOldPassword() == $PWInfo['Password']){
            $newpw = $stmt->prepare("UPDATE users SET Password = :NewPassword WHERE UserID = :UserID");
            $newpw->execute(array(
                'UserID' => $this->getUserID(),
                'NewPassword' => $this->getPassword()
            ));
            header("Location: ../Home.php?success=1");
        } else {
            header("Location: ../Home.php?error=1");
        }
    }
    
    public function CheckAdmin(){
        include 'conn.php';
        $CheckAdmin = $stmt->prepare("SELECT * FROM users WHERE UserID = :UserID");
        $CheckAdmin->execute(array('UserID' => $this->getUserID()));
        $AdminUsers = $CheckAdmin->fetch();
        if($AdminUsers['Access'] == 999){
            return true;
        } else {
            return false;
        }
    }

    public function FindEmail(){
        include 'conn.php';
        $findEmail = $stmt->prepare("SELECT * FROM users WHERE Email = :mail");
        $findEmail->execute(array('mail' => $this->getEmail()));
        $rows = $findEmail->rowCount();
        if($rows == 0){
            return true;
        } else {
            return false;
        }
    }
    
    public function FindUsername(){
        include 'conn.php';
        $findUsername = $stmt->prepare("SELECT * FROM users WHERE Username = :user");
        $findUsername->execute(array('user' => $this->getUsername()));
        $rows = $findUsername->rowCount();
        if($rows == 0){
            return true;
        } else {
            return false;
        }
    }
    
    public function viewProfile(){
        include 'conn.php';
        $viewProfile = $stmt->prepare("SELECT * FROM users WHERE Username = :user");
        $viewProfile->execute(array('user' => $this->getProfile()));
        $rows = $viewProfile->rowCount();
        if ($rows == 1){
            while($view1 = $viewProfile->fetch()){
                echo "<div id=profiles><div id='profInfo'>Viewing profile from ".$view1['Username']."<br/>";
                echo "Email: ". $view1['Email'] ."<br/>";
                echo "From: ". $view1['Country'] ."<br/>";
                echo "<form action='Home.php' method='get'>";
                echo "<input type='hidden' name='page' value='private'>";
                echo "<input type='hidden' name='do' value='new'>";
                echo "<input type='hidden' name='user' value='".$view1['UserID']."'>";
                echo "<input type='submit' value='Send message'/>";
                echo "</form></div>";
                $this->ProfilePic($view1['UserID']);
            }
        } else { echo "No user found."; }
    }
    
    public function delUser(){
        include 'conn.php';
        $viewProfile = $stmt->prepare("SELECT * FROM users WHERE Username = :user");
        $viewProfile->execute(array('user' => $this->getProfile()));
        $rows = $viewProfile->rowCount();
        if ($rows == 1){
            while($view1 = $viewProfile->fetch()){
                echo "<div id='delUser'><form action='Home.php' method='get'>";
                echo "<input type='hidden' name='page' value='profile'>";
                echo "<input type='hidden' name='remove' value='user'>";
                echo "<input type='hidden' name='user' value='".$view1['UserID']."'>";
                echo '<input type="submit" value="Delete user" onclick="return confirm(\'Are you sure?\');" >';
                echo "</form></div></div>";
            }
        } else { /*echo "No user found.";*/ }
    }
    
    public function removeUser(){
        include 'conn.php';
        $rem = $stmt->prepare("SELECT * FROM users WHERE UserID = :uid");
        $rem->execute(array('uid' => $this->getProfile()));
        $rows = $rem->rowCount();
        if ($rows == 1){
            $del = $stmt->prepare("DELETE FROM users WHERE UserID = :uid");
            $del->execute(array('uid' => $this->getProfile()));
            echo "User with ID ".$this->getProfile()." succesfully removed.";
        } else {
            echo "No user found.";
        }
    }
    
    public function FindCountry($ip){
        $url = 'http://viewdns.info/whois/?domain='.$ip;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.001 (windows; U; NT4.0; en-US; rv:1.0) Gecko/25250101');
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
        $db = curl_exec($ch);
        preg_match('/country:        ([a-zA-Z0-9 ]*)/',$db,$matchme);
        $this->setCountry($matchme[1]);
    }
    public function ProfilePic($picid){
        $ext = array("jpg", "png", "jpeg", "gif");
        $tmp = "";           
        foreach($ext as $a){
            $profileimg = "./img/users/".$picid."/profile.".$a;
            if(file_exists($profileimg)){
                $tmp = $a;
                break;
            }
        }
        $img = "./img/users/".$picid."/profile.".$tmp;
        if (file_exists($img)){
            echo "<div id='profilepic'><img alt='profile' height='150' width='150' src='./img/users/".$picid."/profile.".$tmp."'/></div>";
        } else {
            echo "<div id='profilepic'><img alt='profile' height='150' width='150' src='http://www.madisonfund.org/wp-content/uploads/2011/06/Empty-Face.jpg'/></div>";
        }
    }
    public function FindPic($picid, $ver){
        $ext = array("jpg", "png", "jpeg", "gif");
        $tmp = "";           
        foreach($ext as $a){
            if($ver == "1") {
                $profileimg = "./img/users/".$picid."/profile.".$a;
            } else {
                $profileimg = "../img/users/".$picid."/profile.".$a;
            }
            if(file_exists($profileimg)){
                $tmp = $a;
                break;
            }
        }
        if($ver == "1") {
            $img = "./img/users/".$picid."/profile.".$tmp;
        } else {
            $img = "../img/users/".$picid."/profile.".$tmp;
        }
        if (file_exists($img)){
            echo "./img/users/".$picid."/profile.".$tmp;
        } else {
            echo "http://www.madisonfund.org/wp-content/uploads/2011/06/Empty-Face.jpg";
        }
    }
}

class mail{
    private $Email,$Message,$Subject,$Headers,$UserID,$Username;
    
    public function getEmail(){
        return $this->Email;
    }
    public function setEmail($Email){
        $this->Email = $Email;
    }
    
    public function getMessage(){
        return $this->Message;
    }
    public function setMessage($Message){
        $this->Message = $Message;
    }   
        
    public function getSubject(){
        return $this->Subject;
    }
    public function setSubject($Subject){
        $this->Subject = $Subject;
    }
    
    public function getHeaders(){
        return $this->Headers;
    }
    public function setHeaders($Headers){
        $this->Headers = $Headers;
    }
    
    public function getUserID(){
        return $this->UserID;
    }
    public function setUserID($UserID){
        $this->UserID = $UserID;
    }
    
    public function getUsername(){
        return $this->Username;
    }
    public function setUsername($Username){
        $this->Username = $Username;
    }
    
    public function sendEmail(){
        mail($this->getEmail(), $this->getSubject(), $this->getMessage(), $this->getHeaders());
        echo "Sending mail to ". $this->getEmail() ." with subject ". $this->getSubject() .", message ". $this->getMessage() .", headers: ". $this->getHeaders() . ".";
        header("Location: ../index.php?success=2");
    }
}

class msgs{
    private $UserID,$RecptID,$Message,$Hash;
    
    public function getUserID(){
        return $this->UserID;
    }
    public function setUserID($UserID){
        $this->UserID = $UserID;
    }
    
    public function getRecptID(){
        return $this->RecptID;
    }
    public function setRecptID($RecptID){
        $this->RecptID = $RecptID;
    }
    
    public function getMessage(){
        return $this->Message;
    }
    public function setMessage($Message){
        $this->Message = $Message;
    }
    
    public function getHash(){
        return $this->Hash;
    }
    public function setHash($Hash){
        $this->Hash = $Hash;
    }
    
    public function CheckValidConvo($new){
        include 'conn.php';
        $CheckValidConvo = $stmt->prepare("SELECT hash FROM private_msg_groups WHERE user_one = :my_id AND user_two = :user OR user_one = :user AND user_two = :my_id");
        $CheckValidConvo->execute(array(
            'my_id' => $this->getUserID(),
            'user' => $this->getRecptID()
        ));
        $rowCheck = $CheckValidConvo->rowCount();
        $getHash = $CheckValidConvo->fetch();
        if($rowCheck == 0){
            if($new == "yes") {
                $this->CreateConvo();
                echo "Creating new conversation.";
                header("Location: Home.php?page=private&do=show&hash=" . $this->getHash());
            }
        } else {
            $this->setHash($getHash['hash']);
            header("Location: Home.php?page=private&do=show&hash=" . $getHash['hash']);
        }
    }
    
    public function CreateConvo(){
        include 'conn.php';
        $this->setHash(rand());
        $CreateConvo = $stmt->prepare("INSERT INTO private_msg_groups(user_one,user_two,hash) VALUES(:user_one,:user_two,:hash)");
        $CreateConvo->execute(array(
            'user_one' => $this->getUserID(),
            'user_two' => $this->getRecptID(),
            'hash' => $this->getHash()
        ));
    }
    
    public function InsertConvoMsg(){
        include 'conn.php';
        $InsertConvoMsg = $stmt->prepare("INSERT INTO private_msg(group_hash,from_id,message,msg_time) VALUES(:group_hash,:from_id,:message,NOW())");
        $InsertConvoMsg->execute(array(
            'group_hash' => $this->getHash(),
            'from_id' => $this->getUserID(),
            'message' => $this->getMessage(),
        ));
    }
    
    public function ShowAllConvos(){
        include 'conn.php';
        $ShowAllConvos = $stmt->prepare("SELECT hash, user_one, user_two FROM private_msg_groups WHERE user_one = :my_id OR user_two = :my_id");
        $ShowAllConvos->execute(array('my_id' => $this->getUserID()));
        $rows = $ShowAllConvos->rowCount();
        if($rows != 0){
            echo "Select conversation: <br/>";
        } else {
            echo "No conversations.";
        }
        while($get_id = $ShowAllConvos->fetch()){
            if($get_id['user_one'] == $this->getUserID()) {
                $select_id = $get_id['user_two'];
            } else { $select_id = $get_id['user_one']; }          
            $get_user = $stmt->prepare("SELECT Username FROM users WHERE UserID = :uid");
            $get_user->execute(array('uid' => $select_id));
            while($getname = $get_user->fetch()){
                echo "<a href='Home.php?page=private&do=show&hash=" . $get_id['hash'] . "'  class='pmsg'>" . $getname['Username'] . "</a><br/>";
            }           
        }     
    }
    
    public function DisplayConvo() {
        include 'conn.php';
        $DisplayConvo = $stmt->prepare("SELECT * FROM private_msg WHERE group_hash = :hash");
        $DisplayConvo->execute(array('hash' => $this->getHash()));
        while($get_msg = $DisplayConvo->fetch()){
            $get_name = $stmt->prepare("SELECT Username FROM users WHERE UserID = :uid");
            $get_name->execute(array('uid' => $get_msg['from_id']));
            $user_get = $get_name->fetch();
            if($this->checkHash($get_msg['group_hash'])){
                
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
                
                $novidatumura = explode(" ", $get_msg['msg_time']);
                $datum = str_replace('-', '.', $novidatumura[0]);
                $ura = date('H:i',strtotime($novidatumura[1]));
            
                $datumexpl = explode(".", $datum);
                //datetime format
                echo "<p><a class='pmsg' href='Home.php?page=profile&view=".$user_get['Username']."'>". $user_get['Username'] ." </a><span style='font-size: 10px;'>". $datumexpl[2] . " " . $mesec[$datumexpl[1]] . " " . $datumexpl[0] . " @ " . $ura ."</span><br/>". censorReplace(BBCodes(smileys(htmlspecialchars($get_msg['message'])))) ."<br/></p>";
            }else{ echo "Access denied for this conversation."; }
        }
    }
	
    public function findHash($hash) {
        include 'conn.php';
        
        $check_hash = $stmt->prepare("SELECT * FROM private_msg_groups WHERE hash = :hash");
        $check_hash->execute(array('hash' => $hash));
        $getrows = $check_hash->rowCount();
        
        if($getrows == 1){
            return true;
        } else {
            return false;
        }
    }
    
    public function checkHash($hash){
        include 'conn.php';
        if($this->findHash($hash)){
            $check_hash = $stmt->prepare("SELECT * FROM private_msg_groups WHERE hash = :hash AND user_one = :my_id OR user_two = :my_id");
            $check_hash->execute(array(
                'hash' => $hash,
                'my_id' => $this->getUserID(),
            ));
            $rows = $check_hash->rowCount();
            if($rows == 0){
                return false;
            } else {
                return true;
            }
        } else {
            return false;
        }
    }
}


class chat{
    private $ChatID, $MsgUserID, $Message;
    
    public function getChatID(){
        return $this->ChatID;
    }
    public function setChatID($ChatID){
        $this->ChatID = $ChatID;
    }
    public function getMsgUserID(){
        return $this->MsgUserID;
    }
    public function setMsgUserID($MsgUserID){
        $this->MsgUserID = $MsgUserID;
    }
    public function getMessage(){
        return $this->Message;
    }
    public function setMessage($Message){
        $this->Message = $Message;
    } 
    public function InsertChatMessage(){
        include "conn.php";
        $req = $stmt->prepare("INSERT INTO chats(MsgUserID,Message,Time) VALUES(:MsgUserID,:Message,NOW())");
        $req->execute(array(
            'MsgUserID' => $this->getMsgUserID(),
            'Message' => $this->getMessage()
            ));
    }
    
    public function DisplayMessage(){
        include "conn.php";
        $ChatReq = $stmt->prepare("(SELECT * from chats ORDER BY ChatID DESC LIMIT 50) ORDER BY ChatID ASC");
        $ChatReq->execute();
        while ($ChatData = $ChatReq->fetch()) {
            $DisplayMessages = $stmt->prepare("SELECT * FROM users WHERE UserID=:UserID");
            $DisplayMessages->execute(array('UserID' => $ChatData['MsgUserID']));
            $DataUser = $DisplayMessages->fetch();
            
            $novidatumura = explode(" ", $ChatData['Time']);
            $datum = str_replace('-', '.', $novidatumura[0]);
            $ura = date('H:i',strtotime($novidatumura[1]));
            
            ?>
            <span class="Time"><?php echo $ura . " "; ?></span><span class="UserNameS"><?php echo $DataUser['Username']; ?></span><span class="says"> says:</span><br/>
            <span class="ChatMessagesS"><?php echo censorReplace(BBCodes(smileys(htmlspecialchars($ChatData['Message'])))); ?></span><br/>
            <?php
        }
    }
    
    public function DisplayUsers(){
        include "conn.php";
        $OnlineReq = $stmt->prepare("SELECT * from online ORDER BY OnlineID DESC");
        $OnlineReq->execute();
        while ($OnlineData = $OnlineReq->fetch()) {
            $DisplayUsers = $stmt->prepare("SELECT * FROM users WHERE UserID=:UserID");
            $DisplayUsers->execute(array('UserID' => $OnlineData['OnlineID']));
            $DataUsers = $DisplayUsers->fetch();
            ?>
            <a class="onList" href="Home.php?page=profile&view=<?php echo $DataUsers['Username']; ?>"><?php echo $DataUsers['Username']; ?></a><br/>    
            <?php
        }
    }
}
?>