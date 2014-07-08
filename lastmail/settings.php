<?php
  include_once 'userfunctions.php';





	forceUserLoggedIn();
	$userinfo = getUserInfo($_SESSION['userid']);
	if($userinfo['userstatus']==0){
		header('Location: signupactivate.php');
	}

	
	
	//SETTINGS SPECIFIC FUNCTIONS
	$activitytimearr = array(1,7,14,30,60);
  
	  function valToTimeInterval($val){
		global $activitytimearr;
		return $activitytimearr[($val)];
	  }
	  function timeIntervalToVal($time){
		global $activitytimearr;
		$val =  array_search($time, $activitytimearr);
		if($val<0){$val= 0;};
		return $val;
	  }
	  
	  function makeTimeSelect($currentval, $hidefirst=false){ 
		global $activitytimearr;
		echo $currentval;
		$result = "";
		foreach($activitytimearr as $val=>$time){
		if($hidefirst && $val!=0||!$hidefirst && $val<count($activitytimearr)-1){
				if($time==1){
					$days = 'Day';
				}else{ 
					$days = 'Days';
				}
				$result .="<option value='$val' " . ($val==timeIntervalToVal($currentval)?"selected":"") . " >$time $days</option>\n";
			}
		}
		echo $result;
	  }
	  

	/* FORM HANDLING */
	
	//Time change
	if(isset($_POST['Save'])&&isset($_POST['checkinterval'])&&isset($_POST['sendafter'])){
		$checkfrequency = valToTimeInterval($_POST['checkinterval']);
		$sendafter = valToTimeInterval($_POST['sendafter']);
	
		if($sendafter<=$checkfrequency){
			$errors['timesettings'][] = array('type'=>'error','message'=>"Settings not saved. The inactive time $sendafter needs to be longer than the check interval $checkfrequency!");
		}else{ 
			updateTimeSettings($_SESSION['userid'],$checkfrequency,$sendafter);
			getUserInfo($_SESSION['userid']);//Get newly, changed info
			
			$errors['timesettings'][] = array('type'=>'success','message'=>'Time Settings changed Successfully.');
		}
	}
	
	
	//Password change
	if(isset($_POST['SaveNewPass'])&&isset($_POST['newpass'])&&isset($_POST['newpass_confirm'])&&isset($_POST['oldpass'])){
	
		$hashed_oldpass = hashPassword($userinfo['email'], $_POST['oldpass']);
		if($_POST['newpass']!=$_POST['newpass_confirm']){
			$errors['passwordchange'][] = array('type'=>'error', 'message'=>'Error: The new passwords do not match.');
		}else if($hashed_oldpass!=$userinfo['password']){
			$errors['passwordchange'][] = array('type'=>'error', 'message'=>'Error: The current password you entered was not correct.');
			
		}else{
			//TODO: Change email storing to new pass.
			//And then change password in database.
			$hashed_newpass = hashPassword($userinfo['email'], $_POST['newpass']);
			changeMailEncoding($userinfo['userid'], $hashed_oldpass, $hashed_newpass);
			changePassword($userinfo['userid'], $hashed_newpass);
			
			$errors['passwordchange'][] = array('type'=>'success', 'message'=>'Password changed successfully.');
		}
	}
	
	
	
  
  $pagename = "Settings";

  include 'templates/header.php';

  ?>

	<div class='formlike-window form-small' >
		<form method="post">
		<h2><span class='icon icon-cogs'></span>Settings</h2>
		<h4>Time Settings:</h4>
		<?php
			showErrorMessages('timesettings');
		?>

		<fieldset>
			<select id="checkinterval" name="checkinterval" data-style="btn-select" >
				<?php
					makeTimeSelect($userinfo['check_frequency']);
				?>

			</select><label for="checkinterval" data-toggle="tooltip" title="Amount of days between the mails LastMail will send you to check if you're still active.">Time between checks</label>
		</fieldset>
		<fieldset>
			
			<select id="sendafter" name="sendafter" data-style="btn-select" >
			  
				<?php
					makeTimeSelect($userinfo['send_after'], true);
				?>

			</select><label for="sendafter" data-toggle="tooltip" title="If this many days have passed since the last time LastMail heard anything from you, it will send your messages.">Send out messages after an inactive period of</label>
			
		</fieldset>
		<button type='submit' name='Save' value='Save' class='btn btn-default btn-block btn-lg'><i class='icon icon-disk'></i>Save Time Settings</button>

		</form>

		<hr style="margin:50px 0; border-bottom:1px solid rgba(0,0,0,0.2);" />
		
		<form method="post">
		<h4>Change Password</h4>
		<?php
			showErrorMessages('passwordchange');
		?>
			<fieldset>
				<input type="password" name="newpass" id="newpass" ></input> <label for="newpass">New Password</label>
			</fieldset>
			<fieldset>
				<input type="password" name="newpass_confirm" id="newpass_confirm" ></input> <label for="newpass_confirm">New Password (repeat)</label>
			</fieldset>
			<fieldset>
				<input type="password" name="oldpass" id="oldpass" ></input> <label for="oldpass">Current Password</label>
			</fieldset>
		
		<button type='submit' name='SaveNewPass' value='SaveNewPass' class='btn btn-default btn-block btn-lg'><i class='icon icon-disk'></i>Save New Password</button>
		</form>
	</div>




<script type="text/javascript">

	//Disable all options lower than x2 the selected one
	$('select#checkinterval').change(disableSmallTime);
	$(disableSmallTime);
	
	
	function disableSmallTime(){
		//alert($('select#checkinterval option:selected').val());
		var currentval = $("select#sendafter option:selected").val();
		var safeval = -1;
		$('select#sendafter option').each(function(){
			
			if($(this).val()<=$('select#checkinterval option:selected').val()+1){
				//alert($(this).val());
				$(this).attr("disabled", "disabled");
				
				
			}else{
				//Select first value that is possible
				if(safeval <0){
					safeval = $(this).val();
				}
				$(this).prop("disabled", false);
			}
		});
		if(safeval>currentval){
			$("select#sendafter option:selected").prop("selected", false);
			$("select#sendafter option[value="+safeval+"]").prop("selected", true);
		}
		
		
		  $('select#sendafter').selectpicker("refresh");

	}

</script>

























<?php

  include 'templates/footer.php';



?>