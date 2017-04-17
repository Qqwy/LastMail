<?php
	include_once "userfunctions.php";

	forceUserLoggedIn();
	$userinfo = getUserInfo($_SESSION['userid']);
	if($userinfo['userstatus']==0){
		header('Location: signupactivate.php');
	}

	$pagename = "Write Message";
	include 'templates/header.php';


	$formvalues=array();
	$errors['message']=array();
	
	
	
	
	function makeExtraDelaySelect(){
		$result = "";
		for($i=0;$i<60;$i++){
			if($i==0){
				$days ="<i style=\"color:#999\">No Delay</i>";
			}else if($i==1){
				$days = "1 Day";
			}else{
				$days = "$i Days";
			}
			$result .="<option data-content='$days' value='$i'>$days</option>";
		}
		
		echo $result;
	}
	


	//Submit and/or update the message to the database.
	if(isset($_POST['save'])&&isset($_POST['subject'])&&isset($_POST['to'])&&isset($_POST['sendername'])&&isset($_POST['extradelay'])){

		if(isset($_GET['mid'])){
		
			updateOrInsertMail($_GET['mid'], $_SESSION['userid'], $_POST['to'], $_POST['subject'], $_POST['message'], $_POST['sendername'], $_POST['extradelay'], $userinfo['password'], $userinfo['password']);
			
		}else{
		
			insertNewMail($_SESSION['userid'], $_POST['to'], $_POST['subject'], htmlentities($_POST['message'], ENT_HTML5),$_POST['sendername'], $_POST['extradelay'], $userinfo['password']);
			
		}
		$errors['message'][] = array('message'=>'Message Saved Successfully.', 'type'=>'success');

		$formvalues['subject'] = stripslashes($_POST['subject']);
		$formvalues['to'] = stripslashes($_POST['to']);
		$formvalues['message'] = stripslashes($_POST['message']);
		$formvalues['sendername'] = stripslashes($_POST['sendername']);
		$formvalues['extradelay'] =  $_POST['extradelay'];

	}else{

		//If a mail ID is set and this is an existing mail of this user
		if(isset($_GET['mid'])){
			if(mailExists($_GET['mid'], $_SESSION['userid'])){
				//Load values from database in field.
				$maildata = getSingleMail($_GET['mid'], $_SESSION['userid'], $userinfo['password']);

				$formvalues['subject'] = stripslashes($maildata['subject']);
				$formvalues['to'] = $maildata['to'];
				$formvalues['message'] = stripslashes(html_entity_decode($maildata['message']));
				$formvalues['sendername'] = stripslashes($maildata['name']);
				$formvalues['extradelay'] =  $maildata['extradelay'];
				
			}else{ 
				$errors['message'][] = array('message'=>'This message doesn\'t exist, or you don\'t have permission to edit it.', 'type'=>'critical');
			}
			
		}else{

			$formvalues['subject'] = '';
			$formvalues['to'] = '';
			$formvalues['message'] = '';
			$formvalues['extradelay'] =  '0';
			
		}
		
		if(!isset($formvalues['sendername']) || $formvalues['sendername']==''){
			$userinfo = getUserInfo($_SESSION['userid']);
			$emailparts = explode('@' ,$userinfo['email']);
			$formvalues['sendername'] = ucfirst($emailparts[0]);
		}

	}








?>




	<form class='formlike-window messageform' method="post">
		<h2>Message</h2>
		<?php
			showErrorMessages('message');
		?>
		<fieldset >
			<input type="text" name="to" id="to" value="<?php echo $formvalues['to'] ?>"   />
			<label for="to" data-toggle="tooltip" title="One or multiple e-mail addresses of people you want to send this message to.">Recipient(s)</label>
		</fieldset>
		<div>
			<fieldset class='inlinefieldset ifs-right' style="display:inline-block;width:70%;padding-left:0;">
				<input type="text" name="sendername" id="sendername" value="<?php echo $formvalues['sendername'] ?>" />
				<label for="sendername" data-toggle="tooltip" title="How you wish to be known to the recipients of this message.">Sender Name</label>
			</fieldset class='inlinefieldset ifs-left' >
			<fieldset style="display:inline-block;width:27%;padding-right:0;">
				<select name="extradelay" id="extradelay" data-style="btn-select" >
					<?php makeExtraDelaySelect(); ?>
				</select>
				<label for="extradelay" data-toggle="tooltip" title="Extra days to wait before sending this message after you've passed on.">Extra Delay</label>
			</fieldset>
		</div>

		<fieldset >
			<input type="text" name="subject" id="subject" value="<?php echo $formvalues['subject'] ?>"  />
			<label for="subject" data-toggle="tooltip" title="The subject of this message.">Subject</label>
		</fieldset>

		<fieldset>
			<textarea class="summernote" name='message'><?php echo $formvalues['message'] ?></textarea>
		</fieldset>

		<fieldset>
			<button type='submit' name='save' value='Save' class='btn btn-default btn-lg'><i class='icon icon-disk'></i>Save Message</button>
		</fieldset>

	</form>



  <script type="text/javascript">
		$(document).ready(function() {
		  $('.summernote').summernote({
			height: 200,
			tabsize: 2,
			codemirror: {
				theme: 'monokai',
				htmlMode:true,
				lineNumbers:true
			},

			toolbar: [
					['style', [ 'fontname', 'bold', 'italic', 'underline', 'clear']],
					['font', ['strikethrough', 'style']],
					['fontsize', ['fontsize']],
					['color', ['color']],
					['para', ['ul', 'ol', 'paragraph']],
					['height', ['height']],
					['insert', ['link', 'hr']],
					['misc', ['undo', 'redo', 'fullscreen', 'codeview']]

			]
		  });
		});

	  //Tokenfield for the email field
		$('#to')

		.on('tokenfield:createtoken', function (e) {
			var tokenfieldid = this;
			var data = e.attrs.value.split('|');

			//Change "John Doe <j.doe@somewhere.com>" to "j.doe@somewhere.com";
			e.attrs.value = e.attrs.value.replace(/[a-zA-Z1-9 ]*<(.*)>/,'$1');

			//If nothing replaced, they might be multiple mail addresses after eachother. Try creating new tokens when separated by spaces.
			var multiple = e.attrs.value.split(' ');
			if(multiple.length>1){
				multiple.forEach(function(email, index, arr){
					console.log(e);
					$(tokenfieldid).tokenfield('createToken', email);
				});


				e.preventDefault();
			}
			e.attrs.label = e.attrs.value;
		})

		.on('tokenfield:createdtoken', function (e) {
			//More sophisticated mail regexp; http://www.codeproject.com/Articles/22777/Email-Address-Validation-Using-Regular-Expression
			var re = /^(([\w-]+\.)+[\w-]+|([a-zA-Z]{1}|[\w-]{2,}))@((([0-1]?[0-9]{1,2}|25[0-5]|2[0-4][0-9])\.([0-1]?[0-9]{1,2}|25[0-5]|2[0-4][0-9])\.([0-1]?[0-9]{1,2}|25[0-5]|2[0-4][0-9])\.([0-1]?[0-9]{1,2}|25[0-5]|2[0-4][0-9])){1}|([a-zA-Z]+[\w-]+\.)+[a-zA-Z]{2,4})$/;
			var valid = re.test(e.attrs.value);
			if (!valid) {
				$(e.relatedTarget).addClass('invalid');
			}
		})

		.on('tokenfield:edittoken', function (e) {
			if (e.attrs.label !== e.attrs.value) {
				var label = e.attrs.label.split(' (');
				e.attrs.value = label[0] + '|' + e.attrs.value;
			}
		})
		
		.tokenfield();
		
		
  </script>

<?php

        include 'templates/footer.php';
?>
