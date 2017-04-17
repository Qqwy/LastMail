<?php
include_once 'connect.php';
require "securimage/securimage.php";

$userinfo;
$errors;
$securimage = new Securimage();

//Encryption/Decryption of mail plaintext, as this should be hidden.
class Cipher
{

    private $securekey;
    private $iv_size;

    function __construct($textkey)
    {
        $this->iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC);
        $this->securekey = hash('sha256', $textkey, TRUE);
    }

    function encrypt($input)
    {
        $iv = mcrypt_create_iv($this->iv_size);
        return base64_encode($iv . mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $this->securekey, $input, MCRYPT_MODE_CBC, $iv));
    }

    function decrypt($input)
    {
        $input = base64_decode($input);
        $iv = substr($input, 0, $this->iv_size);
        $cipher = substr($input, $this->iv_size);
        return trim(mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $this->securekey, $cipher, MCRYPT_MODE_CBC, $iv));
    }

}






function getAllLiveUsers(){

	$users =  SQL_select("SELECT * FROM `lastmail_users` WHERE `userstatus`<'2'");

	if(!$users){
		return array();
	}else{
		return $users;
	}
}

function getAllDeceasedUsers(){

	$users =  SQL_select("SELECT * FROM `lastmail_users` WHERE `userstatus`>='2'");

	if(!$users){
		return array();
	}else{
		return $users;
	}
}


function setUserPassedAway($userid){
	global $mysqli;


	$userid =  $mysqli->real_escape_string($userid);

	SQL_Query("UPDATE `lastmail_users` SET `userstatus`='2' WHERE `userid`='$userid'");
}

function activateUserAccount($ukey){
	global $mysqli;

	$ukey =  $mysqli->real_escape_string($ukey);

	SQL_Query("UPDATE `lastmail_users` SET `userstatus`='1' WHERE `ukey`='$ukey'");
}

//Updates user last_activity in the table.
//called when image seen, link clicked or site interaction happened.
function updateUserActivity($ukey){
	global $mysqli;

	$timestamp = time();

	$ukey =  $mysqli->real_escape_string($ukey);

	SQL_Query("UPDATE `lastmail_users` SET `last_activity`='$timestamp' WHERE `ukey`='$ukey'");
}


function updateUserCheckTime($userid, $now){
	global $mysqli;


	$userid =  $mysqli->real_escape_string($userid);

	SQL_Query("UPDATE `lastmail_users` SET `last_check_time`='$now' WHERE `userid`='$userid'");
}


//Time settings change
function updateTimeSettings($userid, $checkfrequency, $sendafter){
	global $mysqli;


	$userid =  $mysqli->real_escape_string($userid);
	$checkfrequency =  $mysqli->real_escape_string($checkfrequency);
	$sendafter =  $mysqli->real_escape_string($sendafter);

	SQL_Query("UPDATE `lastmail_users` SET `check_frequency`='$checkfrequency',`send_after`='$sendafter' WHERE `userid`='$userid'");
}

function hashPassword($email, $password){
	global $SQL_SALT;
	$hashed_pass = hash('whirlpool', $email.$password.$SQL_SALT);
	
	return $hashed_pass;

}

//Log user in, if correct user details provided. Creates user session.
function logIn($email, $password){
	global $mysqli, $SQL_SALT;

	$email =  $mysqli->real_escape_string($email);
	$password =  $mysqli->real_escape_string($password);

	$hashed_pass = hashPassword($email, $password);

	$userinfo =  SQL_select_one("SELECT * FROM `lastmail_users` WHERE `email`='$email' AND `password`='$hashed_pass'");
	if(!$userinfo){
		return array('error'=>'Password or mail address incorrect.');
	}else{
		//Set user session
		$_SESSION['userid']=$userinfo['userid'];

		//Update user last_activity
		updateUserActivity($userinfo['ukey']);

		return $userinfo;
	}
}

//Add user to the database, if parameters are correct
function signUp($email, $password, $password_repeat){
	global $mysqli, $SQL_SALT;

	if($password !=$password_repeat){
		return array('error'=>'Passwords do not match.');
	}

	$email =  $mysqli->real_escape_string($email);
	$password =  $mysqli->real_escape_string($password);

	$ukey = md5(time());

	$hashed_pass = hashPassword($email, $password);

	if(!userExists($email)){

		SQL_Query("INSERT INTO `lastmail_users` (`email`, `password`, `ukey`) VALUES ('$email', '$hashed_pass', '$ukey')");

		//Set session to log user in properly;
		$_SESSION['userid']=$mysqli->insert_id;

		//Set user last_activity so it isn't 0
		updateUserActivity($ukey);

		return array('Account created successfully!');

	}else{
		return array('error'=>'User with this address already exists.');
	}
}

//Checks if a user using this mail address exists already
function userExists($email){
  return (getUserID($email)&&true);
}
function getUserID($email){
	global $mysqli;

	$email =  $mysqli->real_escape_string($email);

	$userinfo =  SQL_select_one("SELECT `userid` FROM `lastmail_users` WHERE `email`='$email'");
	if(!isset($userinfo)){
		return false;
	}else{
		return $userinfo;
	}
}


//Get one user row from database with this userid.
function getUserInfo($userid){
	global $mysqli;

	$userid = $mysqli->real_escape_string($userid);
	$userinfo =  SQL_select_one("SELECT * FROM `lastmail_users` WHERE `userid`='$userid'");
	if(sizeof($userinfo)<=0){
		return false;
	}else{
		return $userinfo;
	}
}

//Get one user row from database with this userid.
function getUserInfoFromUkey($ukey){
	global $mysqli;

	$ukey = $mysqli->real_escape_string($ukey);
	$userinfo =  SQL_select_one("SELECT * FROM `lastmail_users` WHERE `ukey`='$ukey'");
	if(sizeof($userinfo)<=0){
		return false;
	}else{
		return $userinfo;
	}
}


function userExistsFromUkey($ukey){
	global $mysqli;

	$ukey =  $mysqli->real_escape_string($ukey);

	$userinfo =  SQL_select_one("SELECT `email` FROM `lastmail_users` WHERE `ukey`='$ukey'");
	if(sizeof($userinfo)<=0){
		return false;
	}else{
		return $userinfo['email'];
	}
}

//Get the list of all user mails that are set
function getUserMails($userid, $hashed_pass){
	global $mysqli;

	$userid = $mysqli->real_escape_string($userid);

	$mailsarr =  SQL_select("SELECT * FROM `lastmail_mails` WHERE `userid`='$userid'");
	if(!isset($mailsarr)){
		return array();
	}else{
	
	
		//TODO: decrypt info of each mail.
		foreach($mailsarr as &$mailarr){
			$mailarr = decryptMail($mailarr, $hashed_pass);
		}
	
		return $mailsarr;
	}
}

//Get the list of user mails that are not yet sent by the system
function getUserUnsentMails($userid, $hashed_pass){
	global $mysqli;

	$userid = $mysqli->real_escape_string($userid);

	$mailsarr =  SQL_select("SELECT * FROM `lastmail_mails` WHERE `userid`='$userid' AND `wassent`='0'");
	if(!isset($mailsarr)){
		return array();
	}else{
		
		foreach($mailsarr as &$mailarr){
			$mailarr = decryptMail($mailarr, $hashed_pass);
		}
		return $mailsarr;
	}
}

function setMailAsSent($mailid){
	global $mysqli;

	echo 'setting to wassent:'.$mailid."\r\n";
	$mailid =  $mysqli->real_escape_string($mailid);

	SQL_Query("UPDATE `lastmail_mails` SET `wassent`='1' WHERE `mailid`='$mailid'");
}


//Get the list of user mails that are set
function getSingleMail($mailid, $userid, $hashed_pass){
	global $mysqli;
	
	//TODO: decrypt message with password

	$mailid =  $mysqli->real_escape_string($mailid);
	$userid = $mysqli->real_escape_string($userid);

	$mailarr =  SQL_select_one("SELECT * FROM `lastmail_mails`  WHERE `mailid`='$mailid' AND `userid`='$userid'");
	if(!isset($mailarr)){
		return array();
	}else{
	
		$mailarr = decryptMail($mailarr, $hashed_pass);

	
		return $mailarr;
	}
}

function decryptMail($mailinfo, $hashed_pass){
	global $SQL_SALT;

		$c = new Cipher($hashed_pass.':'.$SQL_SALT);
		$mailinfo['message'] = $c->decrypt($mailinfo['message']);
		$mailinfo['subject'] = $c->decrypt($mailinfo['subject']);
		$mailinfo['name'] = $c->decrypt($mailinfo['name']);
		$mailinfo['to'] = $c->decrypt($mailinfo['to']); 
		
		return $mailinfo;
}


function checkMailId($mailid, $userid){
	global $mysqli;

	$mailid =  $mysqli->real_escape_string($mailid);
	$userid =  $mysqli->real_escape_string($userid);

	$mailinfo =  SQL_select_one("SELECT `userid` FROM `lastmail_mails` WHERE `mailid`='$mailid' AND `userid`='$userid'");
	if(!isset($mailinfo)){
		return false;
	}else{
		return $mailinfo;
	}

}

function mailExists($mailid, $userid){
	return (checkMailID($mailid, $userid)&&true);
}

function insertNewMail($userid, $to, $subject, $message, $sendername,$extradelay, $hashed_pass){
    global $mysqli, $SQL_SALT;
	
	
	//TODO: encrypt message with password

    $userid =  $mysqli->real_escape_string($userid);
    $to =  $mysqli->real_escape_string($to);
    $subject =  $mysqli->real_escape_string($subject);
    $message =  $mysqli->real_escape_string($message);
	$sendername =  $mysqli->real_escape_string($sendername);
	$extradelay =  $mysqli->real_escape_string($extradelay);
	
	
	$c = new Cipher($hashed_pass.':'.$SQL_SALT);
	$message = $c->encrypt($message);
	$subject = $c->encrypt($subject);
	$sendername = $c->encrypt($sendername);
	$to = $c->encrypt($to); 

    SQL_Query("INSERT INTO `lastmail_mails` (`userid`, `to`, `subject`, `message`, `name`,`extradelay`) VALUES ('$userid', '$to', '$subject', '$message', '$sendername','$extradelay')");

    return $mysqli->insert_id;
}

function updateMail($mailid, $userid, $to, $subject, $message, $sendername,$extradelay, $hashed_pass){
    global $mysqli, $SQL_SALT;
	
	//TODO: encrypt message with password

    $mailid = $mysqli->real_escape_string($mailid);
    $userid =  $mysqli->real_escape_string($userid);
    $to =  $mysqli->real_escape_string($to);
    $subject =  $mysqli->real_escape_string($subject);
    $message =  $mysqli->real_escape_string($message);
	$sendername =  $mysqli->real_escape_string($sendername);
	$extradelay =  $mysqli->real_escape_string($extradelay);
	
	$c = new Cipher($hashed_pass.':'.$SQL_SALT);
	$message = $c->encrypt($message);
	$subject = $c->encrypt($subject);
	$sendername = $c->encrypt($sendername);
	$to = $c->encrypt($to); 

    SQL_Query("UPDATE `lastmail_mails` SET `to`='$to', `subject`='$subject', `message`='$message', `name`='$sendername', `extradelay`='$extradelay' WHERE `userid`='$userid' AND `mailid`='$mailid'");
    
	return true;
}

function updateOrInsertMail( $mailid, $userid, $to, $subject, $message, $sendername,$extradelay, $hashed_pass){
	if(mailExists($mailid, $userid)){
		updateMail($mailid, $userid, $to, $subject, $message,$sendername,$extradelay, $hashed_pass);
	}else{
		insertNewMail($userid, $to, $subject, $message,$sendername,$extradelay, $hashed_pass);
	}
}


function deleteMail($mailid, $userid){
	   global $mysqli;

    $mailid =  $mysqli->real_escape_string($mailid);
    $userid =  $mysqli->real_escape_string($userid);



    SQL_Query("DELETE FROM `lastmail_mails` WHERE `mailid`='$mailid' && `userid`='$userid'");

    return true;
}


//Save all mails again with new password when it is changed.
function changeMailEncoding($userid, $oldpass, $newpass){
	
	$mails = getUserMails($userid, $oldpass);
	foreach($mails as $mail){
		
		updateOrInsertMail( $mail['mailid'], $mail['userid'], $mail['to'], $mail['subject'], $mail['message'], $mail['name'],$mail['extradelay'], $newpass);
		
	}
	
}

function changePassword($userid, $newpass){
	global $mysqli;

    $userid =  $mysqli->real_escape_string($userid);
    $newpass =  $mysqli->real_escape_string($newpass);

	SQL_QUERY("UPDATE `lastmail_users` SET `password`='$newpass' WHERE `userid`='$userid'");
	
	return true;
}


//TEMPLATE FUNCTIONS
	function showDashboard(){
		header('Location: messages.php');
	}

	function showLoginForm(){
		include 'templates/loginform.php';
	}

	function gotoLoginPage(){
		header('Location: login.php');
	}

	function showSignupForm(){
		include 'templates/signupform.php';	
	}

	//Checks if user is logged in, if not, redirects to log in page.
	function forceUserLoggedIn(){
		global $userinfo;
		if(!isset($_SESSION['userid'])){
			session_destroy();
			gotoLoginPage();
			die();
		}

		if(isset($_SESSION['userid'])){
			$userinfo = getUserInfo($_SESSION['userid']);

			//If old or invalid session.
			if(!isset($userinfo['userid'])){
				gotoLoginPage();
			}

		}
	}
	
	
	/* Nice error messages */
	
	function showErrorMessages($category){
		global $errors;
		
		if(isset($errors[$category])){
			foreach($errors[$category] as $error){
				//Types are Bootstrap types: success, info, warning, and special types: error and critical.
				if($error['type']=='error'||$error['type']=='critical'){
					echo '<p class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'.	$error['message'].'</p>';
					if($error['type']=='critical'){
					
					
					
						die;
					}
				}else{
					echo '<p class="alert alert-'.$error['type'].' alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'.	$error['message'].'</p>';
				}
			
				

			}
		}
	}

?>
