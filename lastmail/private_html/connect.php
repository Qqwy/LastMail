<?php
session_start();
//session_regenerate_id();
include_once 'config.php'; 


$mysqli;
$mysqli = new mysqli($SQL_HOSTNAME, $SQL_USER, $SQL_PASSWORD, $SQL_DATABASE);
if ($mysqli->connect_errno) {
   echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}


function SQL_Query($query){
  global $mysqli;
  if(!$mysqli->query($query)){
    echo 'Query failed: ('. $mysqli->errno . ") " . $mysqli->error . '  Query: '. $query;
  }
}
function SQL_select($query){
  global $mysqli;
  $res = $mysqli->query($query);
  if(!$res){
    echo 'Select Query failed: ('. $mysqli->errno . ") " . $mysqli->error . '  Query: '. $query;
    die;
  }else{
    $arr = array();

    while($row = $res->fetch_assoc()){
        $arr[] = $row;

    }



    $res->free();


    return $arr;
  }
}


//Only first result is wanted
function SQL_select_one($query){
  $val = SQL_select($query);

  if(isset($val[0])){
    return $val[0];
  }else{
    return array();
  }
}



//Tables:
//lastmail_users
    //userid: User ID, Int, auto-increment primary
    //email: E-mail address String
    //Password: hashed password of user String
    //last_activity: timestamp of last moment the user was online/logged in, or read a mail containing an image. Timestmap/int
    //check_frequency: Time, in days, between checks. Default: once weekly. (i.e. 7) Int
    //send_after: Time, in days, that needs to be passed after last_activity to send the mails connected to this user. Int
    //haspassed: Boolean, true if the user has passed away


SQL_Query("CREATE TABLE IF NOT EXISTS `lastmail_users` (
  `userid` int(11) NOT NULL AUTO_INCREMENT COMMENT 'User ID, Int, auto-increment primary',
  `email` tinytext COMMENT 'E-mail address',
  `password` text COMMENT 'hashed password of user',
  `last_activity` int(11) NOT NULL DEFAULT '0' COMMENT 'timestamp of last moment the user was online/logged in, or read a mail containing an image. ',
  `last_check_time` INT( 11 ) NOT NULL DEFAULT '0' COMMENT 'Last time an activity check mail was sent.',
  `check_frequency` smallint(6) NOT NULL DEFAULT '7' COMMENT 'Time, in days, between checks. Default: once weekly. (i.e. 7)',
  `send_after` smallint(6) NOT NULL DEFAULT '30' COMMENT 'Time, in days, that needs to be passed after last_activity to send the mails connected to this user.',
  `userstatus` int(11) NOT NULL DEFAULT '0' COMMENT ' 0=account not activated, 1=normal account, 2=has passed, lastMail was sent',
  `ukey` text NOT NULL COMMENT 'User-specific key to update activity',
  PRIMARY KEY (`userid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;");

//lastmail_mails

    //mailid: primary auto-increment identifier.
    //userid: ID of user this mail belongs to.
    //To: One or multiple comma-separated email-addresses to send the mail to.
    //CC: One or multiple comma-separated email-addresses to send the mail to that are not the main recipient.
    //BCC: One or multiple comma-separated email-addresses to send the mail to that should not know each other addresses.
    //Message: A (html-escaped) message containing whatever the person wants to say.
    //Name: The (optional) name the person wishes to take in/for the mail.
SQL_Query("CREATE TABLE IF NOT EXISTS `lastmail_mails` (
  `mailid` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL,
  `to` text,
  `subject` text,
  `message` mediumtext,
  `name` tinytext,
  `extradelay` int(11) NOT NULL COMMENT 'Days to wait after inactivity before sending this mail.',
  `wassent` tinyint(1) NOT NULL COMMENT '1 if the mail has been sent.',
  PRIMARY KEY (`mailid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;")



?>
