<?php
	include_once 'userfunctions.php';
	include_once 'mailfunctions.php';
	
	
	forceUserLoggedIn();
	
	//redirect user once account was activated before
	if(getUserInfo($_SESSION['userid']['userstatus']>0)){
		showDashboard();
	}
	
	
	//Resend mail if asked for it.
	if(isset($_POST['resend'])){
		$userinfo = getUserInfo($_SESSION['userid']);
		$mailmessage = sendActivateAccountMail($userinfo);
		$errors['signupactivate'][] = array('type' => 'info', 'message'=>'A new Activation Mail has been sent to <b>'.$userinfo['email'].'</b>');
		//$errors['signupactivate'][] =  array('type' =>'error', 'message'=>'Ukey: '.$mailmessage);
	}
	
	//Log in user if correct link in mail.
	if(isset($_GET['ukey'])){
		if(userExistsFromUkey($_GET['ukey'])){
			activateUserAccount($_GET['ukey']);
			$errors['signupactivate'][] = array('type'=>'success', 'message'=>'User Account successfully activated.');
			$showsuccess = true;
			
			//Send first activity check email right away
			$userdata = getUserInfoFromUkey($_GET['ukey']);
			sendActivityCheckMail($userdata, true);
			
		}else{
			$errors['signupactivate'][] = array('type'=>'error', 'message'=>'A user with that identifier does not exist.');
		}
	}
	$userinfo = getUserInfo($_SESSION['userid']);
	
	
	if(isset($showsuccess)&&$showsuccess=true){
		$pagename = "Account Activated";
	}else{
		$pagename = "Sign Up Successful";
	}
	include "templates/header.php";
?>

	<form id='resendmail' class='formlike-window form-small' method='post'>
		<?php
			showErrorMessages('signupactivate');
		
		if(isset($showsuccess)&&$showsuccess=true){
		?>
			<p>Your account has been successfully activated.</p>
			
			<a class="btn btn-default" href="messages.php">Go to Messages</a>
		
		<?php
			}else{
		?>
			<p>Thank you for registering.</p>
			<p>To be sure that your mail address is correct, we require you to activate your account by email.</p>
			<p>You should receive an activation email at <b><?php echo $userinfo['email'] ?></b> shortly.<p>
			<br/>
			<br/>
			<p><b>Not received the mail?</b></p><button name="resend" value="resend" type="submit" class="btn btn-lg btn-default">Resend Activation Email</button>
		<?php
			}
		?>
	</form>
	
<?php
	include 'templates/footer.php';
?>
