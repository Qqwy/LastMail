<?php
	$pagename = "Messages";

	include "header.php";
?>
<form id='loginform' class='formlike-window form-small' method='post'>
	<h2><span class="icon icon-key"></span>Login</h2>

	<?php

	global $errors;
		if(isset($errors['login'])){
			foreach($errors['login'] as $error){
				echo '<p class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'.$error.'</p>';
			}
		}
	?>


	<fieldset >
		<input type="email" name="email" id="email" />
		<label for="email">Email</label>
	</fieldset>
	<fieldset>
		<input type="password" name="password" id="password" />
		<label for="password">Password</label>
	</fieldset>
    <fieldset>
            <img id="captcha" src="/securimage/securimage_show.php" alt="CAPTCHA Image" />
            <input type="text" name="captcha_code" size="10" maxlength="6" />
            <a href="#" onclick="document.getElementById('captcha').src = '/securimage/securimage_show.php?' + Math.random(); return false">[ Different Image ]</a>
    </fieldset>
	<fieldset>
		<button type='submit' name='Login' value='Login' class='btn btn-default btn-block btn-lg'>Login</button>
	</fieldset>
</form>



<?php
	include "footer.php";
?>
