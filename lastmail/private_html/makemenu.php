<?php
$menuitems = array();

if(isset($_SESSION['userid'])){
  $userinfo = getUserInfo($_SESSION['userid']);
  if(isset($userinfo['userid'])){

    $isloggedin = true;
  }else{
    $isloggedin = false;
  }
}else{
  $isloggedin = false;
}

if($isloggedin){

   $menuitems['Messages'] = array('openmail','messages.php');
   $menuitems['Settings'] = array('cogs','settings.php');
   $menuitems['Sign Out'] = array('exit','signout.php');
}else{
   $menuitems['Log In'] = array('key','login.php');
   $menuitems[ 'Sign Up'] = array('heart','signup.php');
}


?>

  <!--Menu-->
             <div class='menubar'>
                <nav class='navbar navbar-default' role='navigation'>
                <div class='container-fluid'>
               <div class='navbar-header'>
               <a class='logo' href='index.php' >LastMail</a>
			<label for="openclosemenu" class="menulabel">
			  <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#menuitemscontainer">
                  <span class="sr-only">Toggle navigation</span>
                  <span class="icon icon-longlist"></span>
                </button>
				
			</label>
                </div>
				<input type="checkbox" name="openclosemenu" id="openclosemenu" />
               <div class='collapse navbar-collapse pull-right' id='menuitemscontainer'>
                 <ul class='nav'>

<?php
  foreach($menuitems as $name => $arr){
  echo "<li><a href='{$arr[1]}' ><i class='icon icon-{$arr[0]}'></i> $name</a></li>\n";
  }

?>


                 </ul>
               </div>

               </div>
                <hr/>
               </nav>

             </div>
