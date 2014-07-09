<?php
  include_once '../private_html/userfunctions.php';
  include_once'../private_html/mailfunctions.php';

$br = "\r\n";
  echo "Sending out Activity mails and Last Mails now...".$br;
  /*

  This should be run once daily.
  It tests what users are still alive, sends mails to check activity, and  sends mails if they are inactive for too long.
  */

  $day = 86400; //day in seconds, to use for timestamp comparison.
  //$day = 60;
  $now = time()+60; //One minute in the future, to have some leeway for activities that would be nearly finished at time of checking.

  $users =getAllLiveUsers();
	echo "Total amount of users to test: ".count($users).$br;

  foreach($users as $user){
    //echo 'next user:'.$user['email']."\r\n";
    //User has passed away, send last mails.
    if($user['last_activity']+($user['send_after']*$day)<$now){
      //echo 'User passed away:'."\r\n";
     // echo 'time:'.$user['last_check_time']+($user['send_after']*$day)."\r\n";
      //echo 'now:'.$now."\r\n";
      

      setUserPassedAway($user['userid']);


    }else{

      //Check user activity
      if($user['last_check_time']+($user['check_frequency']*$day)<$now){
        //echo 'User gets activity mail:'."\r\n";

        //echo 'time:'.($user['last_check_time']+($user['check_frequency']*$day))."\r\n";
        //echo 'now:'.$now."\r\n";


        //Send activity check mail
        sendActivityCheckMail($user);

        //Update activity column in row.
        updateUserCheckTime($user['userid'], $now);

      }else{
        //echo 'user up to date.'."\r\n";
      }

    }



  }
  $deceasedusers =getAllDeceasedUsers();

  echo "Total amount of users that have passed away: ".count($deceasedusers).$br;
  foreach($deceasedusers as $user){
	//Send all mails that can be sent now, i.e. delays.
	echo $user['email']."\r\n";
	sendLastMails($user);
  }







?>