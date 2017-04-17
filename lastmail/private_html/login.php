<?php
  include_once 'userfunctions.php';


if(isset($_SESSION['userid'])&& isset($_SESSION['password'])){

  $userinfo = getUserInfo($_SESSION['userid']);

  //If not old or invalid session.
  if(isset($userinfo['userid'])){

    showDashboard();
  }else{
    session_destroy();
  }


}


if(isset($_POST['email'])&&isset($_POST['password']))
  {
      if($securimage->check($_POST['captcha_code']) == false){
          $errors['login'] = array("Invalid captcha!");
          showLoginForm();
      }else{
          $logintest = logIn(trim($_POST['email']), $_POST['password']);

          if(isset($logintest['error'])){
              //echo 'Error:'.$logintest['error'];
              $errors['login'] = array($logintest['error']);
              showLoginForm();
          }else{
              showDashboard();
          }
      }


}else{
    showLoginForm();
  }





?>
