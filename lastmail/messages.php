<?php


	include_once 'userfunctions.php';

	
	forceUserLoggedIn();
	$userinfo = getUserInfo($_SESSION['userid']);
	if($userinfo['userstatus']==0){
		header('Location: signupactivate.php');
	}

	$pagename = "Messages";

	include 'templates/header.php';

?>

<div class='container formlike-window'>

  <h2><span class="icon icon-openmail"></span>Messages</h2>
  <div class='row'>

  <?php

  $usermails = getUserMails($_SESSION['userid'], $userinfo['password']);

		if(sizeof($usermails)>0){


		echo "<table class=' mailslist tablesaw tablesaw-stack' data-mode='stack' ><thead><tr><th class='largefield' >Recipient(s)</th><th class='largefield' >Sender</th><th class='largefield' >Subject</th><th class='editdeletefield' >Edit</th><th class='editdeletefield' >Delete</th></tr></thead><tbody>";

			foreach($usermails as $mail){

			if(strlen($mail['to'])>40){
				$mailto = substr($mail['to'], 0, 37).'...';
			}else{
				$mailto = $mail['to'];
			}

			if(strlen($mail['subject'])>40){
				$mailsubj = substr($mail['subject'], 0, 37).'...';
			}else{
				$mailsubj = $mail['subject'];
			}
			// $mail['to'] = str_replace(',', ",", $mail['to']);

			echo("<tr><td><span href='' class='showtooltip' data-toggle='tooltip'  data-placement='bottom' title='{$mail['to']}'>$mailto</span></td><td><span>{$mail['name']}</span></td><td><span href='' class='showtooltip' data-toggle='tooltip' data-placement='bottom' title='{$mail['subject']}'>$mailsubj</span></td><td><a href='message.php?mid={$mail['mailid']}'><i class='glyphicon glyphicon-pencil'></i></a></td><td><a href='deletemail.php?mid={$mail['mailid']}'><i class='glyphicon glyphicon-remove'></i></a></td></tr>\n");
		}

		echo "</tbody></table>";

	}else{
		echo '<p>There are no messages yet.</p>';
	}
  ?>


  </div>

  <div class='row'>
    <a href='message.php'><button class='btn btn-lg btn-default'><i class='icon icon-quill'></i>New Message</button></a>
  </div>

</div>


  <script type='text/javascript'>
    $('.showtooltip').tooltip();

  </script>

<?php

      include 'templates/footer.php';

  ?>
