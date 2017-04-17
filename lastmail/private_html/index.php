<?php
$indexpage = true;
include "userfunctions.php";

if(isset($_SESSION['userid'])){
  $userinfo = getUserInfo($_SESSION['userid']);

  //If old or invalid session.
  if(!isset($userinfo['userid'])){
    session_destroy();
  }
}

include "templates/header.php";

?>
   <body class='indexpage' >
     <div class='site-wrapper'>
       <div class='topsection'>
         <div class='top-bg'></div>
         <div class='top-fg'>
           <div class='top-container container'>



           <?php include "makemenu.php";
           ?>


             <!-- Top Info -->
             <div class='top-info'>

               <div class='logobig centered'></div>
               <h1>The world's first passive post-mortem message system.</h1>
               <!--<p>The world's first passive post-mortem message delivery system.</p>-->
               <a class=' btn-default btn signupbutton' href='signup.php'>Sign Up Now</a>
             </div>
               <a class='icon icon-arrow-down learnmorebutton' href='#dlead'></a>

           </div>
          </div>
       </div>
       <div class='content-container'>
         <div class='pagesection'>
            <div class='container'>
                <h1 id='dlead'>Death, something we all have in common.</h1>
                <p class='lead'>LastMail lets you send a good-bye to your friends and contacts, and pass on your (digital) belongings.</p>

            <div class='row'>
              <div class='col-sm-4'>
                <span class='bigicon icon-quill'></span>
                <p class='slead' >Write Messages.</p>
                <p class='linfo'>LastMail lets you use full HTML styling, and messages can be addressed to multiple people.</p>
              </div>
              <div class='col-sm-4'>
                <span class=' bigicon icon-refresh'></span>
                <p class='slead'>Live your Life.</p>
                <p class='linfo'>Every few days, LastMail will send you a mail. Reading this mail is enough to tell LastMail that you're still alive.</p>
              </div>
              <div class='col-sm-4'>
                <span class='bigicon icon-lockedheart'></span>
                <p class='slead'>Pass on Peacefully.</p>
                <p class='linfo'>After a long time of inactivity, LastMail will send your messages. Until that time, they are secretly and safely stored.</p>
              </div>
              <a class='icon icon-arrow-down learnmorebutton' href='#features'></a>
            </div>


            </div>
         </div>
         <div class='pagesection'>
             <div class='container'>
                  <h1 id='features' >Features</h1>
                  <div class='featureslist'>
                     <div class='col-sm-6' >
                        <span class='medicon icon-cogs'></span>
                        <p><b>Automatic:</b>Create a will without depending on physical letters that can get lost or opened prematurely.</p>
                    </div>
                     <div class='col-sm-6' >
                        <span class='medicon icon-coffee'></span>
                        <p><b>Passive activity checking:</b> Reading the mails is enough to let LastMail know you're alive.</p>
                    </div>
                     <div class='col-sm-6' >
                         <span class='medicon icon-infinity'></span>
                         <p><b>Unlimited:</b> Create an unlimited amount of messages, each addressed to an unlimited amount of people.</p>
                     </div>
                     <div class='col-sm-6' >
                         <span class='medicon icon-chronometer'></span>
                         <p><b>Custom Delay:</b> You can add a custom delay per message, so you can for instance send someone a new message each day for a week.</p>
                     </div>
                     <div class='col-sm-6' >
                         <span class='medicon icon-bitcoin'></span>
                         <p><b>Properly handle Cryptocurrencies:</b> LastMail was made with Bitcoin and alternatives in mind.</p></div>
                     <div class='col-sm-6' >
                         <span class='medicon icon-safe'></span>
                         <p><b>Safe, Secure, Anonymous:</b> We do not track, we use HTTPS and your messages are stored encrypted.</p>
                     </div>



              </div>

             </div>
             </div>
             <div class='pagesection'>
              <div class='container'>
                     <div class='col-md-12' >
                         <span class='icon bigicon icon-heart'></span>
                         <h2>LastMail is Free</h2>


                         <p class='linfo' >Free, as in Speech. And I would like to keep it that way.<br/>
                         There are no advertisements or other hidden revenue streams. If you like LastMail, consider donating some money:</p>
                         <div class='row donaterow'>
                         <div class='col-sm-6'>
                                       <script src="coinwidget/coin.js"></script>
                                        <script>
                                        CoinWidgetCom.go({
                                          wallet_address: "1E5sWvnH6G38Zr5LcGJRwU1LQGxXFexZBu"
                                          , currency: "bitcoin"
                                          , counter: "count"
                                          , alignment: "bc"
                                          , qrcode: true
                                          , auto_show: false
                                          , lbl_button: "Donate to LastMail"
                                          , lbl_address: "Lastmail Donation Address"
                                          , lbl_count: "people donated so far"
                                          , lbl_amount: "BTC"
                                        });
                                        </script>
                          </div>
                          <div class='col-sm-6'>

                                    <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top" id='paypalform'>
                                          <input type="hidden" name="cmd" value="_s-xclick">
                                          <input type="hidden" name="hosted_button_id" value="64LAXESCLTNSC">
                                          <input type="image" src="images/donate vector finished.png" border="0" name="submit" alt="PayPal – The safer, easier way to pay online.">
                                          <img alt="" border="0" src="https://www.paypalobjects.com/nl_NL/i/scr/pixel.gif" width="1" height="1">
                                    </form>
                        </div>

                         </div>
                         <hr/>

                         <h3>Open Source</h3>
                                                     <p><a class='cclink' href='http://creativecommons.org/licenses/by-nc-sa/4.0/' target='_blank' ><span class='ccicon cc-cc'></span><span class='ccicon cc-by'></span><span class='ccicon cc-nc'></span></a></p>

                         <p>LastMail and its source code are released under the <a href='http://creativecommons.org/licenses/by-nc-sa/4.0/' target='_blank' >CC-BY-NC-SA</a> License.</p>
						 
						 <p><b><i class="glyphicon glyphicon-share-alt"></i> Check & Download the code on <a href="https://github.com/Qqwy/LastMail" target="_blank">GitHub</a></b></p>

                           <p>This means that you can host a copy of LastMail for your own use as long as:
  <ul class='ccul'>
    <li>You give <i>Appropriate Credit</i> to <a href='http://wmcode.nl' target='_blank'>W-M</a>, the creator of LastMail, and link back to the main site.</li>
    <li>You do not use the material for <i>Commercial Purposes</i>.</li>
    <li>You need to share your versions under the <i>same license</i>.</li>
  </ul>
                         </p>



                     </div>
      <div class='col-md-12'>
      <hr>

                      <h3 id='thanksto'>Thanks to</h3>
                      <p>This site makes use of several amazing things made by other people:</p>
                      <ul>
                        <li>Libraries &amp; Code:
                          <ul>
                              <li><a href="http://getbootstrap.com/" target='_blank' >Bootstrap</a> ,  framework for developing responsive websites.</li>
                              <li><a href="http://jquery.com/" target='_blank' >jQuery</a> ,  JavaScript library to make the work of developers easier.</li>
                              <li><a href="http://hackerwins.github.io/summernote/" target='_blank' >SummerNote</a> ,  Super Slick WYSIWYG editor.</li>
                              <li><a href="http://sliptree.github.io/bootstrap-tokenfield/" target='_blank' >Tokenfield</a> ,  for nice mail address adding.</li>

                          </ul>
                        </li>
                        <li>Fonts &amp; Icons:
                          <ul>
                              <li><a href="http://fontawesome.io/" target='_blank' >FontAwesome</a> ,  Mostly the Editor Icons.</li>
                              <li><a href="http://brankic1979.com/icons/" target='_blank' >Brankic1979</a> ,  for some very slick Icons used throughout the site.</li>
                              <li><a href="http://icomoon.io/" target='_blank' >IcoMoon</a> ,  To put the icon sets together consisely.</li>
                              <li><a href="http://sliptree.github.io/bootstrap-tokenfield/" target='_blank' >Tokenfield</a> ,  for nice mail address adding.</li>

                          </ul>
                        </li>
                        <li>Photos:
                          <ul>
                              <li><a href="https://www.flickr.com/photos/24018267@N00/9014116309/in/photostream/" target='_blank' >Forget me Not</a> by <b>Mark Seton</b>. Licensed under the <a target="_blank" href="https://creativecommons.org/licenses/by-nc/2.0/">CC-BY-NC</a> license.</li>
                              <li><a href="https://www.flickr.com/photos/24018267@N00/9014116309/in/photostream/" target='_blank' >Forget me Not Disk</a> by <b>Jodi</b>. Licensed under the <a target="_blank" href="https://creativecommons.org/licenses/by-nc-sa/2.0/">CC-BY-NC-SA</a> license.</li>
                              <li><a href="http://subtlepatterns.com/" target='_blank' >SubtlePatterns</a> ,  for the lovely backgrounds.</li>

                          </ul>
                        </li>
                      </ul>


                     </div>
              </div>

			  

     <script type="text/javascript">

     function resizeHeader() {
            maxH = $(window).height() *1;
            if(maxH<600){
              maxH = 600;
            }
            $('.top-container').css('height', maxH + 'px');
        }
        $(window).ready(function(){resizeHeader()});
        $(window).resize(function(){resizeHeader()});


    $('a').smoothScroll();
     </script>


<?php
include 'templates/footer.php';
?>





