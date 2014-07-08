<?php
	include_once 'userfunctions.php';

	//Domain settings
	$ROOT_URL = "https://last-mail.org/";
	$ROOT_URL_UNSAFE = "http://last-mail.org/"; //Used for showing the picture, inline pictures in mail can only be done over normal http
	


  $SENDERADDR = '"Azrael of LastMail" <azrael@last-mail.org>';

  function sendHTMLMail($to="", $subject = "(No Subject)", $pmessage = "(No Message)"){
    global $SENDERADDR;


    if($to==""){
      return false;
    }


    $message = '<html><head><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><title>' . $subject . '</title></head><body>';
    $message .= $pmessage;
    $message .='</html></body>';

    $headers  = "From: " . $SENDERADDR . "\r\n";
    $headers .= "Reply-To: ". $SENDERADDR . "\r\n";
    $headers .= "Return-Path: " . $SENDERADDR . "\r\n";
    $headers .= "Bcc: " . $to. "\r\n";
    $headers .= 'X-Mailer: PHP/' . phpversion(). "\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=utf-8\r\n";

    $ok = mail($to, $subject, $message, $headers);
    //echo ($ok?'success!':'failure ');
    //echo 'msg:'.$message.' and headers: '.$headers;
  }


class mail {

    public static function prepareAttachment($path) {
        $rn = "\r\n";

        if (file_exists($path)) {
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $ftype = finfo_file($finfo, $path);
            $file = fopen($path, "r");
            $attachment = fread($file, filesize($path));
            $attachment = chunk_split(base64_encode($attachment));
            fclose($file);

            $msg = 'Content-Type: \'' . $ftype . '\'; name="' . basename($path) . '"' . $rn;
            $msg .= "Content-Transfer-Encoding: base64" . $rn;
            $msg .= 'Content-ID: <' . basename($path) . '>' . $rn;
//            $msg .= 'X-Attachment-Id: ebf7a33f5a2ffca7_0.1' . $rn;
            $msg .= $rn . $attachment . $rn . $rn;
            return $msg;
        } else {
            return false;
        }
    }

    public static function sendMail($to='', $subject, $content, $path = '', $cc = '', $bcc = '', $fromaddr='',$_headers = false) {
      global $SENDERADDR;
		if($fromaddr==''){
			$fromaddr = $SENDERADDR;
		}

        $rn = "\r\n";
        $boundary = md5(rand());
        $boundary_content = md5(rand());

// Headers
        $headers = 'From: ' . $fromaddr  . $rn;
        $headers .= "Reply-To: ". $SENDERADDR . $rn;
        $headers .= "Return-Path: " . $SENDERADDR . $rn;


        $headers .= 'Mime-Version: 1.0' . $rn;
        $headers .= 'Content-Type: multipart/related;boundary=' . $boundary . $rn;

        //adresses cc and ci
        if ($cc != '') {
            $headers .= 'Cc: ' . $cc . $rn;
        }
        if ($bcc != '') {
            $headers .= 'Bcc: ' . $bcc . $rn;
        }
        $headers .= $rn;

// Message Body
        $msg = $rn . '--' . $boundary . $rn;
        $msg.= "Content-Type: multipart/alternative;" . $rn;
        $msg.= " boundary=\"$boundary_content\"" . $rn;

//Body Mode text
        $msg.= $rn . "--" . $boundary_content . $rn;
        $msg .= 'Content-Type: text/plain; charset=utf-8' . $rn;
		
		//Remove inline style tag content.
		$textcontent = trim(strip_tags(preg_replace('/<style\b[^>]*>(.*?)<\/style>/i', '', $content))); //     /<script\b[^>]*>(.*?)<\/script>/i;
		$textcontent = preg_replace( '/\t/' , '' , $textcontent);
		
        $msg .= trim(strip_tags($textcontent)) . $rn;

//Body Mode Html
        $msg.= $rn . "--" . $boundary_content . $rn;
        $msg .= 'Content-Type:text/html;charset=utf-8' . $rn;
        $msg .= 'Content-Transfer-Encoding: quoted-printable' . $rn;
        if ($_headers) {
            //$msg .= $rn . '<img src=3D"cid:template-H.PNG" />' . $rn;
        }
        //equal sign are email special characters. =3D is the = sign
        $msg .= $rn . str_replace("=", "=3D", $content) . $rn;
        if ($_headers) {
            //$msg .= $rn . '<img src=3D"cid:template-F.PNG" />' . $rn;
        }
        $msg .= $rn . '--' . $boundary_content . '--' . $rn;

//if attachement
        if ($path != '' && file_exists($path)) {
            $conAttached = self::prepareAttachment($path);
            if ($conAttached !== false) {
                $msg .= $rn . '--' . $boundary . $rn;
                $msg .= $conAttached;
            }
        }

//other attachement : here used on HTML body for picture headers/footers
        if ($_headers) {
/*            $imgHead = dirname(__FILE__) . '/../../../../modules/notification/ressources/img/template-H.PNG';
            $conAttached = self::prepareAttachment($imgHead);
            if ($conAttached !== false) {
                $msg .= $rn . '--' . $boundary . $rn;
                $msg .= $conAttached;
            }
            $imgFoot = dirname(__FILE__) . '/../../../../modules/notification/ressources/img/template-F.PNG';
            $conAttached = self::prepareAttachment($imgFoot);
            if ($conAttached !== false) {
                $msg .= $rn . '--' . $boundary . $rn;
                $msg .= $conAttached;
            }*/
        }

// Fin
        $msg .= $rn . '--' . $boundary . '--' . $rn;

       // $msg = wordwrap($msg, 70, $rn);//Lnes should never be longer than 70 chars!

// Function mail()
        mail($to, $subject, $msg, $headers);

      //echo $msg;
      //echo "\n--------\n";
      //echo $headers;
    }

}


function sendActivateAccountMail($user){ 
	global $ROOT_URL;
	
	$message = file_get_contents('mailtemplates/activateaccount.html');
	
	$message = str_replace('{{ACTIVATE_LINK}}', $ROOT_URL . "signupactivate.php?ukey=" . $user['ukey'], $message);
	$message = str_replace('{{LASTMAIL_URL}}', $ROOT_URL , $message);
	
	
	//print_r($message);
	
	mail::sendMail($user['email'], 'Activate your LastMail account', $message,'','', '');
	
	return $message;
}


function sendActivityCheckMail($user, $fromsamedir=false){
	global $ROOT_URL, $ROOT_URL_UNSAFE;

	$message = file_get_contents(($fromsamedir?'':'../').'mailtemplates/activitycheck.html');

	$message = str_replace('{{UPDATER_IMAGE}}',$ROOT_URL_UNSAFE . 'updaterimage.php?ukey='. $user['ukey'] , $message);

//  mail('qqwy@gmx.com', 'test test', 'I would like to know if this mail arrives successfully.' );
//  sendHTMLMail("qqwy@gmx.com", "This is a test mail to test the mail of LastMail", $message);

	
	mail::sendMail($user['email'], 'How are you doing lately?', $message,'','', '');
	//print_r($message);

}

function sendLastMails($user){
	global $day, $now;
	$mails = getUserUnsentMails($user['userid']);



	foreach($mails as $mail){
		//echo 'Mailid:'.$mail['mailid']."\r\n";

		
		//Only send if this mail if the extra delay has been passed.
		if($user['last_activity']+($user['send_after']*$day+$mail['extradelay']*$day)<$now){
			global $ROOT_URL;
			//echo 'sending LastMail of:'.$user['email']."\r\n";
			//echo 'to:'.$mail['to']."\r\n";

			$mheader = file_get_contents('../mailtemplates/lastmail-header.html');
			
			if($mail['name']!=''){
				$sendername = $mail['name'];
			}else{
				$emailparts = explode('@' ,$user['email']);
				$sendername = ucfirst($emailparts[0]);
			}
			
			
				$mailaddr = $sendername . ', using LastMail <' .$user['email'] .'>';
			

			$mheader = str_replace('{{EMAIL_ADDRESS}}', $mailaddr, $mheader);
			$mheader = str_replace('{{OWNER_NAME}}', $mail['name'], $mheader);
			$mheader = str_replace('{{SUBJECT}}', $mail['subject'] , $mheader);
			$mheader = str_replace('{{SEND_AFTER}}', $user['send_after'] , $mheader);
			$mheader = str_replace('{{LASTMAIL_URL}}', $ROOT_URL , $mheader);


			$mfooter = file_get_contents('../mailtemplates/lastmail-footer.html');
			
			$message = $mheader.stripslashes($mail['message']).$mfooter;
			
			$subject = $mail['subject'].'(by ' . $sendername . ' using LastMail)';
			
			//echo($message);
			//echo($mail['to']);
			
			setMailAsSent($mail['mailid']);
			
			mail::sendMail('', stripslashes($mail['subject'].'  [Last Mail of '.$mail['name'] .']'), stripslashes(html_entity_decode($message)),'','', $mail['to']);
			
			//Afterwards, delete mail from database
			deleteMail($mail['mailid'], $mail['userid']);
		}
  
  }
}



?>
