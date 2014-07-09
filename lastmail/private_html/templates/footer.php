				</div>
			</div>
		</div>
		<div class='footer'>
			<div class='container'>
				<p>LastMail is made and maintained with much love and care by <a href='http://wmcode.nl' target='_blank'>W-M</a>.<br/> Also, a huge thanks to <a href='index.php#thanksto'>these people.</a><br/><br/>
				<a href="https://github.com/Qqwy/LastMail" target="_blank">GitHub</a> · <a href="https://last-mail.org" >Homepage</a> · <a href="https://twitter.com/W_Mcode" target="_blank">Twitter</a>
				</p>	
			</div>
		</div>

		<script type='text/javascript'>
		//Make sure that .jsenabled class is set when JS exists.
	
			$('body').removeClass('jsdisabled');
		
		
		
		
		 $($('input').each(animateFormLabels));
		 $('input').on('blur', animateFormLabels);
		 $('input').on('keydown', animateFormLabels);

		 $('div.tokenfield').on('tokenfield:initialize', animateTokenField);

		 $('div.tokenfield').on('tokenfield:createdtoken', animateTokenField);
		 $('div.tokenfield').on('tokenfield:editedtoken', animateTokenField);
		 $('div.tokenfield').on('tokenfield:removedtoken', animateTokenField);



		 $('div.tokenfield').on('blur', animateTokenField);
		 $('div.tokenfield').on('focus', animateTokenField);



		function animateFormLabels(){
				  console.log('current input value:'+$(this).val());

				  if($(this).hasClass('token-input')){
					//console.log($($(this).parent().children()).tokenfield('getTokensList'));
					extraflag = $($(this).parent().children()).tokenfield('getTokensList') != "";
				  }else{
					extraflag = false;
				  }

				  if( $(this).val() != "" || extraflag){
					$('label[for='+$(this).attr('id')+']').addClass('stay');
				  } else {
					$('label[for='+$(this).attr('id')+']').removeClass('stay');
				  }
		}

		function animateTokenField(){



				  var labelselector = 'label[for='+$(this).children("input.token-input").attr('id')+']';

				//console.log("tokens:"+$(this).tokenfield('getTokensList'));
				  if( ($(this).tokenfield('getTokensList') != "" || $(this).children("input.token-input").val()!=""  )){


					$(labelselector).addClass('stay');
				  } else {
					$(labelselector).removeClass('stay');
				  }

		}

		$(document).ready(function(){
		  $('select').selectpicker();

		});

		$('label').tooltip({placement:"bottom"})


		</script>


   </body>
</html>
