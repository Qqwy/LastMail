<?php
	include_once 'userfunctions.php';
	include_once 'mailfunctions.php';

  
if(isset($_SESSION['userid'])){
  $userinfo = getUserInfo($_SESSION['userid']);

  //If not old or invalid session.
  if(isset($userinfo['userid'])){
    session_destroy();
    showDashboard();
  }else{
    session_destroy();
  }
}

if(isset($_POST['email'])&&isset($_POST['password'])&&isset($_POST['password-repeat']))
  {
      if($securimage->check($_POST['captcha_code']) == false){
          $errors['signup'] = array("Invalid captcha!");
          showSignupForm();
      }else{

        $signuptest = signUp(trim($_POST['email']), $_POST['password'], $_POST['password-repeat']);

        if(isset($signuptest['error'])){
            //echo 'Error:'.$logintest['error'];
            $errors['signup']=array($signuptest['error']);
            showSignupForm();
        }else{
            $userinfo = getUserInfo($_SESSION['userid']);

            sendActivateAccountMail($userinfo);
            showDashboard();
        }
      }

}else{
    showSignupForm();
  }





?>
