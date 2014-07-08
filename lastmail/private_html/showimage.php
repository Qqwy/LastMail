<?php

include_once 'connect.php';
include_once 'userfunctions.php';

//Display an image from PHP

setcookie('doesitwork','awesome');
$imgdata = file_get_contents('image5.jpg');

header('Content-type: image/jpg');
echo $imgdata;
echo 'test';



?>