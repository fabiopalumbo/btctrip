<?php $view->extend('BtcTripMainBundle::layout.html.php') ?>

<?php $view['slots']->set('bodyClass', '') ?>

<?php $view['slots']->start('stylesheets') ?>

<link type="text/css" rel="stylesheet" href="<?php echo $view['assets']->getUrl('bundles/btctrip/styles/home.css') ?>"/>
<link type="text/css" rel="stylesheet" href="<?php echo $view['assets']->getUrl('/bundles/btctrip/styles/ajax-coin-slider-styles.css') ?>"/>
<link type="text/css" rel="stylesheet" href="<?php echo $view['assets']->getUrl('/bundles/btctriphotels/css/hotels-big.css') ?>"/>

<!-- TODO - Estilo para el autocomplete  - Cambiarlo parecido al de despegar  -->
<link type="text/css" rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css"/>



<!-- Sirve para validar formularios -->
<script type="text/javascript" src="<?php echo $view['assets']->getUrl('/bundles/btctripmain/js/jquery.validate.js') ?>"></script>
<?php $view['slots']->stop() ?>


<?php $view['slots']->start('mainContent') ?>
<div class="span4 searchbg">
    <div class="searchform" >
		<?php echo $view->render('BtcTripHotelsBundle:CoreHotels:formHotel.html.php', array()) ?>
	</div>
</div>

<div class="span8">		
    <div id="resultHotels_html" class="l10px"></div>
</div>

<?php $view['slots']->stop() ?>

<?php $view['slots']->start('secondContent') ?>
	
		<div class="row sectionsTitles">
			<div class="span8 underscore"><span class="testimonial"><img src="/bundles/btctrip/images/testimonialshead.png"></span></div>
			<div class="span4 underscore"><span class="testimonial"><img src="/bundles/btctrip/images/specialhead.png" class="l20px"></span></div>
		</div>
		<div class="row press">
			<div id="left span8">
				<div class="star span2" onmouseover="this.className='starinvert span2'; showstuff('testim1'); document.getElementById('name1').style.color='#ffffff';" onmouseout="this.className='star span2'; hidestuff('testim1'); document.getElementById('name1').style.color='#4f4f4f'">
					<div class="name" id="name1">Charlie Shrem</div><div class="testbox testimonial-bg" id="testim1">
					<img class="testimonial-avatar" src="/bundles/btctrip/images/testim/charlie-shrem.jpg"/><div class="testcopy"><br><i>"BtcTrip is Amazing!"</i><br>CEO of Bitinstant</div>
					</div>
				</div>
				<div class="star span2" onmouseover="this.className='starinvert span2'; showstuff('testim2'); document.getElementById('name2').style.color='#ffffff';" onmouseout="this.className='star span2'; hidestuff('testim2'); document.getElementById('name2').style.color='#4f4f4f'">
					<div class="name" id="name2">Jon Matonis</div><div class="testbox testimonial-bg" id="testim2">
						<img class="testimonial-avatar" src="/bundles/btctrip/images/testim/jon-matonis.jpg"/>
						<div  class="testcopy"><i>"I'm liking this service <br/> more and more"</i><br/>Executive Director at Bitcoin Foundation</div>
					</div>
				</div>
				<div class="star span2" onmouseover="this.className='starinvert span2'; showstuff('testim3'); document.getElementById('name3').style.color='#ffffff';" onmouseout="this.className='star span2'; hidestuff('testim3'); document.getElementById('name3').style.color='#4f4f4f'">
					<div class="name" id="name3">Erik Voorhees</div><div class="testbox testimonial-bg" id="testim3">
						<img class="testimonial-avatar" src="/bundles/btctrip/images/testim/erik-voorhees.jpg"/>
						<div  class="testcopy"><i>"Thanks for the great service!"</i><br/>SatoshiDice Founder<br/>CEO of Coinapult</div>
					</div>
				</div>
				<div class="star span2" onmouseover="this.className='starinvert span2'; showstuff('testim4'); document.getElementById('name4').style.color='#ffffff';" onmouseout="this.className='star span2'; hidestuff('testim4'); document.getElementById('name4').style.color='#4f4f4f'">
					<div class="name" id="name4">Nicolas Cary</div><div class="testbox testimonial-bg" id="testim4">
						<img class="testimonial-avatar" src="/bundles/btctrip/images/testim/nicolas-carry.jpg"/>
						<div  class="testcopy"><i>"Amazing customer service always rules the day."</i> CEO of Blockchain.info</div>
					</div>
				</div>
			</div>
			<div class="" style="width: 640px;">
				<div class="star span2" onmouseover="this.className='starinvert span2'; showstuff('testim6'); document.getElementById('name6').style.color='#ffffff';" onmouseout="this.className='star span2'; hidestuff('testim6'); document.getElementById('name6').style.color='#4f4f4f'">
					<div class="name" id="name6">Tuur Demeester</div><div class="testbox testimonial-bg" id="testim6">
						<img class="testimonial-avatar" src="/bundles/btctrip/images/testim/tuur-demeester.jpg"/>
						<div  class="testcopy"><i>"BTCTrip is quick, effortless, and allows me to use the best money in the world"</i> </br> </div>
					</div>
				</div>
				<div class="star span2" onmouseover="this.className='starinvert span2'; showstuff('testim7'); document.getElementById('name7').style.color='#ffffff';" onmouseout="this.className='star span2'; hidestuff('testim7'); document.getElementById('name7').style.color='#4f4f4f'">
					<div class="name" id="name7">Amir Taaki</div><div class="testbox testimonial-bg" id="testim7">
						<img class="testimonial-avatar" src="/bundles/btctrip/images/testim/amir-taaki.jpg"/>
						<div  class="testcopy"><i>"I think BtcTrip is amazing."</i><br/><br/>Bitcoin developer</div>
					</div>
				</div>
				<div class="star span2" onmouseover="this.className='starinvert span2'; showstuff('testim8'); document.getElementById('name8').style.color='#ffffff';" onmouseout="this.className='star span2'; hidestuff('testim8'); document.getElementById('name8').style.color='#4f4f4f'">
					<div class="name" id="name8">Satoshi</div><div class="testbox testimonial-bg" id="testim8">
						<img class="testimonial-avatar" src="/bundles/btctrip/images/testim/satoshi-avatar.jpg"/>
						<div  class="testcopy"><i>"After coding Bitcoin, I fly with BtcTrip."</i><br/>Satoshi Nakamoto, Cryptocurrency prophet</div>
					</div>
				</div>
				<div class="star span2" onmouseover="this.className='starinvert span2'; showstuff('testim9'); document.getElementById('name9').style.color='#ffffff';" onmouseout="this.className='star span2'; hidestuff('testim9'); document.getElementById('name9').style.color='#4f4f4f'">
					<div class="name" id="name9">Vitalik Buterin</div><div class="testbox testimonial-bg" id="testim9">
						<img class="testimonial-avatar" src="/bundles/btctrip/images/testim/vitalik-buterin.jpg"/>
						<div  class="testcopy"><i>"We've really enjoyed Btctrip so far."</i><br/>Head Write at Bitcoin Magazine<br/></div>						
					</div>
				</div>
			</div>

			<div class="" style="width: 640px;">
				<div class="star span2" onmouseover="this.className='starinvert span2'; showstuff('testim6-2'); document.getElementById('name6-2').style.color='#ffffff';" onmouseout="this.className='star span2'; hidestuff('testim6-2'); document.getElementById('name6-2').style.color='#4f4f4f'">
					<div class="name" id="name6-2">Lasse B. Olesen</div><div class="testbox testimonial-bg" id="testim6-2">
						<img class="testimonial-avatar" src="/bundles/btctrip/images/testim/lasse-olesen.jpg"/>
						<div  class="testcopy"><i>"I bought a flight ticket cheaper than I found it anywhere else!"</i><br/>BitcoinNordic Founder</div>
					</div>
				</div>
				<div class="star span2" onmouseover="this.className='starinvert span2'; showstuff('testim7-2'); document.getElementById('name7-2').style.color='#ffffff';" onmouseout="this.className='star span2'; hidestuff('testim7-2'); document.getElementById('name7-2').style.color='#4f4f4f'">
					<div class="name" id="name7-2">@MundoBitcoin</div><div class="testbox testimonial-bg" id="testim7-2">
						<img class="testimonial-avatar" src="/bundles/btctrip/images/testim/avatar.png"/>
						<div  class="testcopy"><i>"Now I can run away incognito when the shit hits the fan!"</i><br/>MundoBitcoin.org</div>
					</div>
				</div>	
				<div class="star span2" onmouseover="this.className='starinvert span2'; showstuff('testim8-2'); document.getElementById('name8-2').style.color='#ffffff';" onmouseout="this.className='star span2'; hidestuff('testim8-2'); document.getElementById('name8-2').style.color='#4f4f4f'">
					<div class="name" id="name8-2">Thalia & Chris</div><div class="testbox testimonial-bg" id="testim8-2">
						<img class="testimonial-avatar" src="/bundles/btctrip/images/testim/avatar.png"/>
						<div  class="testcopy"><i>"You guys are seriously awesome!!"</i><br/>Great panamanian bitcoin travelers</div>
					</div>
				</div>
				<div class="star span2" onmouseover="this.className='starinvert span2'; showstuff('testim9-2'); document.getElementById('name9-2').style.color='#ffffff';" onmouseout="this.className='star span2'; hidestuff('testim9-2'); document.getElementById('name9-2').style.color='#4f4f4f'">
					<div class="name" id="name9-2">Richard Caetano</div><div class="testbox testimonial-bg" id="testim9-2">
						<img class="testimonial-avatar" src="/bundles/btctrip/images/testim/avatar.png"/>
						<div  class="testcopy"><i>"Booked my first flight on BtcTrip. I like where the system is going."</i><br/>Developer of btcReport</div>
					</div>
				</div>		
			</div>
			
			<a href="mailto:business@btctrip.com" >
				<div id="right" class="featuredby higher" title="Insanely Cheap Business Class Tickets. Found it cheaper somewhere? We can beat any offer!">
					<div> </div>
				</div>
			</a>
		</div>
		<div class="underscore testimonial-section" ><span class="testimonial"><img src="/bundles/btctrip/images/presshead.png" ></span></div>
		<div class="repress" >
			<div class="span2 pressbgd nyt" style="margin-left: 0px;">
				<a href="http://intransit.blogs.nytimes.com/2014/02/07/rewards-program-tries-bitcoin/?_php=true&_type=blogs&rref=travel&module=Ribbon&version=context&region=Header&action=click&contentCollection=Travel&pgtype=Blogs&_r=0" target="_blank"><img src="/bundles/btctrip/images/btcnytimes.jpg"></a>
			</div>
			<div class="span2 pressbgd" >
				<a href="http://bitcoinexaminer.org/btctrip-has-a-new-business-account-and-plans-to-launch-three-new-services/" target="_blank"><img src="/bundles/btctrip/images/btcexaminer.jpg"></a>
			</div>
			<div class="span2 pressbgd">
				<a href="http://www.bitcoinbulletin.com/2013/08/23/the-top-5-bitcoin-shops/" target="_blank"><img src="/bundles/btctrip/images/btcbulletin.jpg"></a>
			</div>
			<div class="span2 pressbgd">
				<a href="http://bitcoinmagazine.com/6446/btctrip-travel-the-world-with-global-currency/" target="_blank"><img src="/bundles/btctrip/images/btcmagazine.jpg"></a>
			</div>
			<div class="span2 pressbgd">
				<a href="http://www.coinsiderthis.com/2013/08/23/coinsider-this-show-4-problems-possibilities-and-poker/" target="_blank"><img src="/bundles/btctrip/images/btccoinsider.jpg"></a>
			</div>
		</div>


	<div class="preloadimages">
		<img src="/bundles/btctrip/images/starbg.png">
		<img src="/bundles/btctrip/images/starbginvert.png">
	</div>

<?php $view['slots']->stop() ?>