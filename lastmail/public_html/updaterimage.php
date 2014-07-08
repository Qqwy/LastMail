<?php
	$relloc = '../private_html/'; //Relative location to the other .php files, e.g. inside the safe directory.

  include_once($relloc.'userfunctions.php');


  $succeeded = false;
  //Secret user-identifier key.
  if(isset($_GET['ukey'])){
    $umail = userExistsFromUkey($_GET['ukey']);
    if($umail){
      updateUserActivity($_GET['ukey']);
      $succeeded=true;
    }
  }
  $user = getUserInfoFromUkey($_GET['ukey']);
  
  showLastActiveImage($succeeded, $umail, ($user['userstatus']>=2));

function showLastActiveImage($activitysaved, $umail='Unknown Address', $isdead = false){
	global $relloc;
  //Set the Content Type
  header('Content-type: image/png');

  // Create Image From Existing File

  $png_image = imagecreatefrompng($relloc.'images/activityimage.png');
  imagesavealpha($png_image, true);

  // Allocate A Color For The Text
  $black = imagecolorallocate($png_image, 0, 0, 0);

  // Set Path to Font File
  $font_path = $relloc.'fonts/gabriola.ttf';

  // Set Text to Be Printed On Image
  if($isdead){
	$text = "We presume this person to have died";
  }else{
		$text = date("l F j, Y, H:i:s");//"This is a sunset!";
	}
  if(!$activitysaved){
    //$text = 'Error, you are not in our database.';
  }

  // Print Text On Image
  if(!$isdead){
	imagettftext($png_image, 18, 0, 130, 85, $black, $font_path, 'saw you last active at');
  }
  imagettftext($png_image, 24, 0, 130, 110, $black, $font_path, $text);

  // Print User Account Address On Image, at top right

  $addrdimensions = imagettfbbox(24,0,$font_path, $umail);
  //right - text dimension X, top+text height
  imagettftext($png_image, 28, 0, 500-$addrdimensions[2], 15+$addrdimensions[1], $black, $font_path, $umail);
  //imagettftext($png_image, 28, 0, 300, 50, $black, $font_path, $umail);

  // Send Image to Browser
  imagepng($png_image);

  // Clear Memory
  imagedestroy($png_image);



}
?>