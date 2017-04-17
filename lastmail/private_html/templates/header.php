<!DOCTYPE html>
<html lang="en">
	<head>

		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no"">

		<!--Favicon -->
		<link rel="shortcut icon" href="images/favicon.ico">
		<link rel="icon" sizes="16x16 32x32 64x64" href="images/favicon.ico">
		<link rel="icon" type="image/png" sizes="196x196" href="images/favicon-196.png">
		<link rel="icon" type="image/png" sizes="160x160" href="images/favicon-160.png">
		<link rel="icon" type="image/png" sizes="96x96" href="images/favicon-96.png">
		<link rel="icon" type="image/png" sizes="64x64" href="images/favicon-64.png">
		<link rel="icon" type="image/png" sizes="32x32" href="images/favicon-32.png">
		<link rel="icon" type="image/png" sizes="16x16" href="images/favicon-16.png">
		<link rel="apple-touch-icon" sizes="152x152" href="images/favicon-152.png">
		<link rel="apple-touch-icon" sizes="144x144" href="images/favicon-144.png">
		<link rel="apple-touch-icon" sizes="120x120" href="images/favicon-120.png">
		<link rel="apple-touch-icon" sizes="114x114" href="images/favicon-114.png">
		<link rel="apple-touch-icon" sizes="76x76" href="images/favicon-76.png">
		<link rel="apple-touch-icon" sizes="72x72" href="images/favicon-72.png">
		<link rel="apple-touch-icon" href="images/favicon-57.png">
		<meta name="msapplication-TileColor" content="#FFFFFF">
		<meta name="msapplication-TileImage" content="images/favicon-144.png">
		<meta name="msapplication-config" content="/browserconfig.xml">

		<!--Bootstrap-->
		<link rel='stylesheet' href="bootstrap/css/bootstrap.min.css" />
		<link rel="stylesheet" href="scripts/font-awesome/css/font-awesome.min.css" />


		<!--IcoMoon -->
		<!--<link rel="stylesheet" href="http://i.icomoon.io/public/temp/b0d278bd98/UntitledProject1/style.css">-->


		<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
			<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
		<![endif]-->

		<!--Bootstrap and jQuery -->
		<script type='text/javascript' src="scripts/jquery.min.js" ></script>
		<script type='text/javascript' src="bootstrap/js/bootstrap.min.js" ></script>




		<!-- include codemirror (codemirror.css, codemirror.js, xml.js, formatting.js)-->
		<link rel="stylesheet" type="text/css" href="scripts/codemirror.css" />
		<link rel="stylesheet" href="scripts/codemirror-theme-blackboard.min.css">
		<link rel="stylesheet" href="scripts/codemirror-theme-monokai.min.css">
		<script type="text/javascript" src="scripts/codemirror.js"></script>
		<script src="scripts/codemirror-mode-xml.js"></script>
		<script src="scripts/codemirror-formatting.js"></script>

		<!-- include summernote -->
		<link rel="stylesheet" href="scripts/summernote.css">
		<script type="text/javascript" src="scripts/summernote.min.js"></script>


		<!--Include Tokenfield -->
		<link rel="stylesheet" href="scripts/bootstrap-tokenfield.min.css">
		<script type="text/javascript" src="scripts/bootstrap-tokenfield.min.js"></script>


		<!--Stack tables -->
		<link rel="stylesheet" href="scripts/tablesaw.css">
		<script type="text/javascript" src="scripts/tablesaw.stackonly.js"></script>

		<!--jQuery UI & Custom Dropdowns -->
		<link rel="stylesheet" href="scripts/bootstrap-select.min.css" type="text/css" media="screen" />
		<script src="scripts/bootstrap-select.min.js"></script>
		
		<!-- Smooth scrolling -->
		<script src="scripts/jquery.smooth-scroll.min.js"></script>
		

		<!-- Main style -->
		<link rel='stylesheet' href="style.css" />






		<title>Last Mail<?php echo (isset($pagename)?" | " . $pagename:"") ?></title>

		<meta property="og:image" content="images/forgetmenotlogo5.png" />
		<meta property="og:title" content="Last Mail | The world's first passive post-mortem message system." />
		<meta property="og:url" content="https://last-mail.org" />
		<meta property="og:locale" content="en_US" />
		
		<meta property="og:site_name" content="LastMail" />

		<meta property="og:description" content="LastMail lets you send a good-bye to your friends and contacts, and pass on your (digital) belongings after you pass on." />
		<meta name="description" content="LastMail lets you send a good-bye to your friends and contacts, and pass on your (digital) belongings after you pass on." />
		
	<meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:site" content="@W_MCode">
    <meta name="twitter:creator" content="@W_MCode">
    <meta name="twitter:title" content="Last Mail | The world's first passive post-mortem message system.">
    <meta name="twitter:description" content="LastMail lets you send a good-bye to your friends and contacts, and pass on your (digital) belongings after you pass on.">
    <meta name="twitter:image:src" content="http://last-mail.org/lastmailscreen.jpg">

	</head>
	<?php if(!isset($indexpage)){ ?>
	<body class='dashboard-page jsdisabled'>
	<div class='site-wrapper'>
	<div class='topsection'>


	<div class='top-container container'>


	<?php include "makemenu.php";
	?>


	</div>
	</div>
	<div class='content-container'>
	<div class='container'>
<?php 
	} 
?>
