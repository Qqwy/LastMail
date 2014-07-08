<?php
  include_once 'userfunctions.php';





	forceUserLoggedIn();
	$userinfo = getUserInfo($_SESSION['userid']);
	if($userinfo['userstatus']==0){
		header('Location: signupactivate.php');
	}

	$pagename = "Delete Mail";

	include 'templates/header.php';

	
	
	//Start page
	
	
	if(!isset($_GET['mid'])){
		$ispropermail = false;
	}else{ 
		$ispropermail = checkMailId($_GET['mid'], $userinfo['userid']);
	}
	
	if(!$ispropermail){
		$errors['deletemail'][] = array("type"=>"error", "message"=>"Error. A mail with this ID does not exist for your account.");
	}
	
	//Delete mail, if button was clicked.
	if(isset($_POST['deletemail'])){
		deleteMail($_GET['mid'], $userinfo['userid']);
		$maildeleted = true;
		$errors['deletemail'][] = array("type"=>"success", "message"=>"The mail has been deleted successfully.");
	}
	
?>


<div class="formlike-window form-small">
<?php
	showErrorMessages('deletemail');
	
	if(isset($maildeleted)&&$maildeleted==true){
	?>
	
	<a href='messages.php' class="btn btn-lg btn-default" ><i class="glyphicon glyphicon-arrow-left"></i>  Back to Messages </a>
	
	<?php
	}else if($ispropermail){
?>
	<form method="post">
	<h2>Are you sure you want to delete this mail?</h2>
	
	<button type="submit" class="btn btn-lg btn-danger"  value="deletemail" name="deletemail" ><i class='glyphicon glyphicon-remove' style="top:3px;"></i> Yes, Delete.</button>
	
	</form>
	
	
<?php
	}
?>



</div>





<?php
	include 'templates/footer.php';
?>