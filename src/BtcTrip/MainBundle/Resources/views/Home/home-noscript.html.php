<?php $view->extend('BtcTripMainBundle::layout.html.php') ?>

<?php

$dosDias = 172800;
$sFlightsAnticipationDays = date('Y-m-d', strtotime("now") + $dosDias);

$sHotelsAnticipationDays = date('Y-m-d', strtotime("now"));

?>
<?php $view['slots']->set('bodyClass', '') ?>

<?php $view['slots']->start('stylesheets') ?>

<!-- // scripts // -->
  <script src="<?php echo $view['assets']->getUrl('bundles/btctrip/javascript/jquery-1.11.3.min.js') ?>"></script>
  <script src="<?php echo $view['assets']->getUrl('bundles/btctrip/javascript/idangerous.swiper.js') ?>"></script>
  <script src="<?php echo $view['assets']->getUrl('bundles/btctrip/javascript/slideInit.js') ?>"></script>
  <script src="<?php echo $view['assets']->getUrl('bundles/btctrip/javascript/owl.carousel.min.js') ?>"></script>
  <script src="<?php echo $view['assets']->getUrl('bundles/btctrip/javascript/bxSlider.js') ?>"></script>
  <script src="<?php echo $view['assets']->getUrl('bundles/btctrip/javascript/jqeury.appear.js') ?>"></script>  
  <script src="<?php echo $view['assets']->getUrl('bundles/btctrip/javascript/custom.select.js') ?>"></script>
  <script src="<?php echo $view['assets']->getUrl('bundles/btctrip/javascript/jquery-ui.min.js') ?>"></script>
  <script type="text/javascript" src="<?php echo $view['assets']->getUrl('bundles/btctrip/javascript/twitterfeed.js') ?>"></script>
  <script src="<?php echo $view['assets']->getUrl('bundles/btctrip/javascript/script2.js') ?>"></script>
<!-- \\ scripts \\ --> 
 




<?php $view['slots']->stop() ?>


<?php $view['slots']->start('mainContent') ?>

<!-- main-cont -->
<div class="main-cont">
<div class="">
	<div class="mp-slider">
		<!-- // slider // -->
		<div class="mp-slider-row">
			<div class="swiper-container">
			    <div class="swiper-preloader-bg"></div>
			    <div id="preloader">
			    	<div id="spinner"></div>
			    </div>
			    
				<a href="#" class="arrow-left"></a>
				<a href="#" class="arrow-right"></a>
				<div class="swiper-pagination"></div>
  				<div class="swiper-wrapper">  				
                    <div class="swiper-slide"> 
						<div class="slide-section" style="background:url('bundles/btctrip/images/LUGARES01.png') center top no-repeat;">
							<div class="mp-slider-lbl">Great journey begins with a small step</div>
							<div class="mp-slider-lbl-a">Make Your Life Better and Bright!  You must trip with Us!</div>
							<div class="mp-slider-btn"><a href="#" class="btn-a">Learn more</a></div>
						</div>
					</div>
                    <div class="swiper-slide"> 
						<div class="slide-section  slide-b" style="background:url('bundles/btctrip/images/LUGARES02.png') center top no-repeat;">
							<div class="mp-slider-lbl">Great journey begins with a small step</div>
							<div class="mp-slider-lbl-a">Make Your Life Better and Bright!  You must trip with Us!</div>
							<div class="mp-slider-btn"><a href="#" class="btn-a">Learn more</a></div>
						</div>      
      				</div>
      				<div class="swiper-slide"> 
						<div class="slide-section slide-b" style="background:url('bundles/btctrip/images/LUGARES03.png') center top no-repeat;">
							<div class="mp-slider-lbl">Relax with us. we love our clients</div>
							<div class="mp-slider-lbl-a">Make Your Life Better and Bright!  You must trip with Us!</div>
							<div class="mp-slider-btn"><a href="#" class="btn-a">Learn more</a></div>
						</div>      
      				</div>
      				<div class="swiper-slide"> 
						<div class="slide-section slide-b" style="background:url('bundles/btctrip/images/LUGARES04.png') center top no-repeat;">
							<div class="mp-slider-lbl">Planning trip with your friends</div>
							<div class="mp-slider-lbl-a">Make Your Life Better and Bright!  You must trip with Us!</div>
							<div class="mp-slider-btn"><a href="#" class="btn-a">Learn more</a></div>
						</div>      
      				  
      				</div>
 				
  				</div>
			</div>
		</div>
		<!-- \\ slider \\ -->
	</div>	
	
	<div class="wrapper-a-holder">
	<div class="wrapper-a">
	
		<!-- // search // -->
		<div class="page-search search-type-a">
			<nav class="page-search-tabs">
                <div class="search-tab nth active">Tickets</div>			
				<div class="search-tab">Hotels</div>
				<div class="search-tab">Tours</div>
				
				<div class="clear"></div>	
			</nav>		
			<div class="page-search-content">
			<!-- // tab content tickets // -->
				<div class="search-tab-content tickets-tab">
					<div class="page-search-p">
						<!-- // -->
						<div class="srch-tab-line">
							<div class="srch-tab-left">
								<label>From</label>
								<div class="input-a"><input type="text" value="" placeholder="Austria, vienna"></div>	
							</div>
							<div class="srch-tab-right">
								<label>to</label>
								<div class="input-a"><input type="text" value="" placeholder="--"></div>	
							</div>
							<div class="clear"></div>
						</div>
						<!-- \\ -->	
						<!-- // -->
						<div class="srch-tab-line">
							<div class="srch-tab-left">
								<label>Departure</label>
								<div class="input-a"><input type="text" value="" class="date-inpt" placeholder="mm/dd/yy"> <span class="date-icon"></span></div>	
							</div>
							<div class="srch-tab-right">
								<label>arrivals</label>
								<div class="input-a"><input type="text" value="" class="date-inpt" placeholder="mm/dd/yy"> <span class="date-icon"></span></div>	
							</div>
							<div class="clear"></div>
						</div>
						<!-- \\ -->	

						<!-- // -->
						<div class="srch-tab-line no-margin-bottom">
							<div class="srch-tab-left transformed">
								<label>Peoples</label>
								<div class="select-wrapper">
								<select class="custom-select">
									<option>--</option>
									<option>1</option>
									<option>2</option>
									<option>3</option>
									<option>4</option>
								</select>
								</div>	
							</div>
							<div class="srch-tab-right transformed">
								<label>Class</label>
								<div class="select-wrapper">
								<select class="custom-select">
									<option>--</option>
									<option>1</option>
									<option>2</option>
									<option>3</option>
									<option>4</option>
								</select>
								</div>	
							</div>
							<div class="clear"></div>
						</div>
						<!-- \\ -->	
						<!-- // advanced // -->
						<div class="search-asvanced">
						<!-- // -->
						<div class="srch-tab-line no-margin-bottom">
							<div class="srch-tab-left">
								<label>Price</label>
								<div class="select-wrapper">
								<select class="custom-select">
									<option>--</option>
									<option>1</option>
									<option>2</option>
									<option>3</option>
									<option>4</option>
								</select>
								</div>	
							</div>
							<div class="srch-tab-right">
								<label>Air company</label>
								<div class="select-wrapper">
								<select class="custom-select">
									<option>--</option>
									<option>1</option>
									<option>2</option>
									<option>3</option>
									<option>4</option>
								</select>
								</div>	
							</div>
							<div class="clear"></div>
						</div>
						<!-- \\ -->			
						</div>
						<!-- \\ advanced \\ -->
					</div>
					<footer class="search-footer">
						<a href="#" class="srch-btn">Search</a>	
						<span class="srch-lbl">Advanced Search options</span>
						<div class="clear"></div>
					</footer>
				</div>
				<!-- // tab content // -->			
			
			
				
			</div>
		</div>
		<!-- \\ search \\ -->
		
		<!-- // offer // -->
		<div class="special-offer-a">
			<div class="special-offer-img">
				<a href="#"><img alt="" src="<?php echo $view['assets']->getUrl('bundles/btctrip/images/special-offer2.png') ?>" /></a>
			</div>
			<footer class="special-offer-foot">
				<div class="special-offer-foot-l">
					<b>Special: Day of the Dead</b>
					<span>Location: Mexico</span>
				</div>
				<div class="special-offer-foot-r">
					<b>152$</b>
					<span>avg/night</span>
				</div>
				<div class="clear"></div>
			</footer>
		</div>
		<!-- \\ offer \\ -->
		
		<!-- // offer // -->
		<div class="special-offer-b">
			<div class="weather-block">
				<div class="weather-block-padding">
					<!-- // -->
					<div class="weather-i">
						<div class="weather-a">Today</div>
						<div class="weather-b"><img alt="" src="<?php echo $view['assets']->getUrl('bundles/btctrip/images/weather-icon-02.png') ?>" /></div>
						<div class="weather-c">15 M/S</div>
					</div>
					<!-- \\ -->
					<!-- // -->
					<div class="weather-i">
						<div class="weather-a">tuesday</div>
						<div class="weather-b"><img alt="" src="<?php echo $view['assets']->getUrl('bundles/btctrip/images/weather-icon-01.png') ?>" /></div>
						<div class="weather-c">5 M/S</div>
					</div>
					<!-- \\ -->
					<!-- // -->
					<div class="weather-i">
						<div class="weather-a">Wednesday</div>
						<div class="weather-b"><img alt="" src="<?php echo $view['assets']->getUrl('bundles/btctrip/images/weather-icon-02.png') ?>" /></div>
						<div class="weather-c">3 M/S</div>
					</div>
					<!-- \\ -->
					<div class="weather-devider"></div>
					<footer class="weather-footer">
						<a href="#">
							<span class="weather-foot-link">Find our special offers for</span>
							<span class="weather-foot-link-a">ARGENTINA</span>
						</a>
					</footer>					
				</div>	
			</div>
		</div>
		<!-- \\ offer \\ -->
		<div class="clear"></div>	
	</div>
	</div>
     <!-- // testimonials // -->
    
    <div class="testimonials">
    
      <div class="testimonials-lbl fly-in">what our clients say</div>
      <div class="testimonials-lbl-a fly-in"></div>  
      
      <div class="testimonials-holder fly-in">
      	<div id="testimonials-slider">
      	<!-- // -->
      	<div class="testimonials-i">
        	<div class="testimonials-a"><img alt="" src="<?php echo $view['assets']->getUrl('bundles/btctrip/images/charlie-shrem.png') ?>" /></div>
        	<div class="testimonials-b">"BtcTrip is Amazing!" Charlie Shrem</div>
        	<div class="testimonials-c">
          	<nav>
            	<ul>
              	<li><a href="#"><img alt="" src="<?php echo $view['assets']->getUrl('bundles/btctrip/images/ts-star.png') ?>" /></a></li>
              	<li><a href="#"><img alt="" src="<?php echo $view['assets']->getUrl('bundles/btctrip/images/ts-star.png') ?>" /></a></li>
              	<li><a href="#"><img alt="" src="<?php echo $view['assets']->getUrl('bundles/btctrip/images/ts-star.png') ?>" /></a></li>
              	<li><a href="#"><img alt="" src="<?php echo $view['assets']->getUrl('bundles/btctrip/images/ts-star.png') ?>" /></a></li>
              	<li><a href="#"><img alt="" src="<?php echo $view['assets']->getUrl('bundles/btctrip/images/ts-star.png') ?>" /></a></li>
            	</ul>
          	</nav>
        	</div>
        	<div class="testimonials-d">CEO of Bitinstant</div>
      	</div>
      	<!-- // -->
      	<div class="testimonials-i">
        	<div class="testimonials-a"><img alt="" src="<?php echo $view['assets']->getUrl('bundles/btctrip/images/erik-voorhees.png') ?>" /></div>
        	<div class="testimonials-b">"Thanks for the great service!" Erik Voorhees</div>
        	<div class="testimonials-c">
          	<nav>
            	<ul>
              	<li><a href="#"><img alt="" src="<?php echo $view['assets']->getUrl('bundles/btctrip/images/ts-star.png') ?>" /></a></li>
              	<li><a href="#"><img alt="" src="<?php echo $view['assets']->getUrl('bundles/btctrip/images/ts-star.png') ?>" /></a></li>
              	<li><a href="#"><img alt="" src="<?php echo $view['assets']->getUrl('bundles/btctrip/images/ts-star.png') ?>" /></a></li>
              	<li><a href="#"><img alt="" src="<?php echo $view['assets']->getUrl('bundles/btctrip/images/ts-star.png') ?>" /></a></li>
              	<li><a href="#"><img alt="" src="<?php echo $view['assets']->getUrl('bundles/btctrip/images/ts-star.png') ?>" /></a></li>
            	</ul>
          	</nav>
        	</div>
        	<div class="testimonials-d">SatoshiDice Founder - CEO of Coinapult</div>
      	</div>      	
      	<!-- // -->
      	<div class="testimonials-i">
        	<div class="testimonials-a"><img alt="" src="<?php echo $view['assets']->getUrl('bundles/btctrip/images/jon-matonis.png') ?>" /></div>
        	<div class="testimonials-b">"I'm liking this service more and more" Jon Matonis </div>
        	<div class="testimonials-c">
          	<nav>
            	<ul>
              	<li><a href="#"><img alt="" src="<?php echo $view['assets']->getUrl('bundles/btctrip/images/ts-star.png') ?>" /></a></li>
              	<li><a href="#"><img alt="" src="<?php echo $view['assets']->getUrl('bundles/btctrip/images/ts-star.png') ?>" /></a></li>
              	<li><a href="#"><img alt="" src="<?php echo $view['assets']->getUrl('bundles/btctrip/images/ts-star.png') ?>" /></a></li>
              	<li><a href="#"><img alt="" src="<?php echo $view['assets']->getUrl('bundles/btctrip/images/ts-star.png') ?>" /></a></li>
              	<li><a href="#"><img alt="" src="<?php echo $view['assets']->getUrl('bundles/btctrip/images/ts-star.png') ?>" /></a></li>
            	</ul>
          	</nav>
        	</div>
        	<div class="testimonials-d">Executive Director at Bitcoin Foundation</div>
      	</div>
      	<!-- // -->
      	<!-- // -->
      	<div class="testimonials-i">
        	<div class="testimonials-a"><img alt="" src="<?php echo $view['assets']->getUrl('bundles/btctrip/images/nicolas-carry.png') ?>" /></div>
        	<div class="testimonials-b">"Amazing customer service always rules the day" Nicolas Cary</div>
        	<div class="testimonials-c">
          	<nav>
            	<ul>
              	<li><a href="#"><img alt="" src="<?php echo $view['assets']->getUrl('bundles/btctrip/images/ts-star.png') ?>" /></a></li>
              	<li><a href="#"><img alt="" src="<?php echo $view['assets']->getUrl('bundles/btctrip/images/ts-star.png') ?>" /></a></li>
              	<li><a href="#"><img alt="" src="<?php echo $view['assets']->getUrl('bundles/btctrip/images/ts-star.png') ?>" /></a></li>
              	<li><a href="#"><img alt="" src="<?php echo $view['assets']->getUrl('bundles/btctrip/images/ts-star.png') ?>" /></a></li>
              	<li><a href="#"><img alt="" src="<?php echo $view['assets']->getUrl('bundles/btctrip/images/ts-star.png') ?>" /></a></li>
            	</ul>
          	</nav>
        	</div>
        	<div class="testimonials-d">CEO of Blockchain.info</div>
      	</div>      	
      	<!-- // -->
      	<!-- // -->
      	<div class="testimonials-i">
        	<div class="testimonials-a"><img alt="" src="<?php echo $view['assets']->getUrl('bundles/btctrip/images/roger-ver2.png') ?>" /></div>
        	<div class="testimonials-b">"I love the service that they are providing to the Bitcoin community." Roger Ver</div>
        	<div class="testimonials-c">
          	<nav>
            	<ul>
              	<li><a href="#"><img alt="" src="<?php echo $view['assets']->getUrl('bundles/btctrip/images/ts-star.png') ?>" /></a></li>
              	<li><a href="#"><img alt="" src="<?php echo $view['assets']->getUrl('bundles/btctrip/images/ts-star.png') ?>" /></a></li>
              	<li><a href="#"><img alt="" src="<?php echo $view['assets']->getUrl('bundles/btctrip/images/ts-star.png') ?>" /></a></li>
              	<li><a href="#"><img alt="" src="<?php echo $view['assets']->getUrl('bundles/btctrip/images/ts-star.png') ?>" /></a></li>
              	<li><a href="#"><img alt="" src="<?php echo $view['assets']->getUrl('bundles/btctrip/images/ts-star.png') ?>" /></a></li>
            	</ul>
          	</nav>
        	</div>
        	<div class="testimonials-d">Bitcoin Investor</div>
      	</div>      	
      	<!-- // -->
      	<!-- // -->
      	<div class="testimonials-i">
        	<div class="testimonials-a"><img alt="" src="<?php echo $view['assets']->getUrl('bundles/btctrip/images/tuur-demeester.png') ?>" /></div>
        	<div class="testimonials-b">"BTCTrip is quick, effortless, and allows me to use the best money in the world" Tuur Demeester</div>
        	<div class="testimonials-c">
          	<nav>
            	<ul>
              	<li><a href="#"><img alt="" src="<?php echo $view['assets']->getUrl('bundles/btctrip/images/ts-star.png') ?>" /></a></li>
              	<li><a href="#"><img alt="" src="<?php echo $view['assets']->getUrl('bundles/btctrip/images/ts-star.png') ?>" /></a></li>
              	<li><a href="#"><img alt="" src="<?php echo $view['assets']->getUrl('bundles/btctrip/images/ts-star.png') ?>" /></a></li>
              	<li><a href="#"><img alt="" src="<?php echo $view['assets']->getUrl('bundles/btctrip/images/ts-star.png') ?>" /></a></li>
              	<li><a href="#"><img alt="" src="<?php echo $view['assets']->getUrl('bundles/btctrip/images/ts-star.png') ?>" /></a></li>
            	</ul>
          	</nav>
        	</div>
        	<div class="testimonials-d">BTCTRIP customer</div>
      	</div>      	
      	<!-- // -->
      	<!-- // -->
      	<div class="testimonials-i">
        	<div class="testimonials-a"><img alt="" src="<?php echo $view['assets']->getUrl('bundles/btctrip/images/amir-taaki.png') ?>" /></div>
        	<div class="testimonials-b">"I think BtcTrip is amazing." Amir Taaki</div>
        	<div class="testimonials-c">
          	<nav>
            	<ul>
              	<li><a href="#"><img alt="" src="<?php echo $view['assets']->getUrl('bundles/btctrip/images/ts-star.png') ?>" /></a></li>
              	<li><a href="#"><img alt="" src="<?php echo $view['assets']->getUrl('bundles/btctrip/images/ts-star.png') ?>" /></a></li>
              	<li><a href="#"><img alt="" src="<?php echo $view['assets']->getUrl('bundles/btctrip/images/ts-star.png') ?>" /></a></li>
              	<li><a href="#"><img alt="" src="<?php echo $view['assets']->getUrl('bundles/btctrip/images/ts-star.png') ?>" /></a></li>
              	<li><a href="#"><img alt="" src="<?php echo $view['assets']->getUrl('bundles/btctrip/images/ts-star.png') ?>" /></a></li>
            	</ul>
          	</nav>
        	</div>
        	<div class="testimonials-d">Bitcoin developer</div>
      	</div>      	
      	<!-- // -->      	
      	</div>
      </div>
      
    </div>   		
	<div class="mp-offesr">
		<div class="wrapper-padding-a">
			<div class="offer-slider">
				<header class="fly-in page-lbl">
					<div class="offer-slider-lbl">Offers</div>
					<p>Special Discount in Business Class paying with BITCOINS.</p>
				</header>
				
				<div class="fly-in offer-slider-c">
					<div id="offers" class="owl-slider">
					<!-- // -->
						<div class="offer-slider-i">
							<a class="offer-slider-img" href="#">
								<img alt="" src="<?php echo $view['assets']->getUrl('bundles/btctrip/images/slide-01a.png') ?>" />
								<span class="offer-slider-overlay">
									<span class="offer-slider-btn">view details</span>
								</span>
							</a>
							<div class="offer-slider-txt">
								<div class="offer-slider-link"><a href="#">Teshima Art Museum</a></div>
								<div class="offer-slider-l">
									<div class="offer-slider-location">Location: Japan </div>
									<nav class="stars">
										<ul>
											<li><a href="#"><img alt="" src="<?php echo $view['assets']->getUrl('bundles/btctrip/images/star-b.png') ?>"/></a></li>
											<li><a href="#"><img alt="" src="<?php echo $view['assets']->getUrl('bundles/btctrip/images/star-b.png') ?>"/></a></li>
											<li><a href="#"><img alt="" src="<?php echo $view['assets']->getUrl('bundles/btctrip/images/star-b.png') ?>"/></a></li>
											<li><a href="#"><img alt="" src="<?php echo $view['assets']->getUrl('bundles/btctrip/images/star-b.png') ?>"/></a></li>
											<li><a href="#"><img alt="" src="<?php echo $view['assets']->getUrl('bundles/btctrip/images/star-a.png') ?>"/></a></li>
										</ul>
										<div class="clear"></div>
									</nav>
								</div>
								<div class="offer-slider-r">
									<b>756$</b>
									<span>avg/night</span>
								</div>
								<div class="offer-slider-devider"></div>								
								<div class="clear"></div>
							</div>
						</div>
					<!-- \\ -->
					<!-- // -->
						<div class="offer-slider-i">
							<a class="offer-slider-img" href="#">
								<img alt="" src="<?php echo $view['assets']->getUrl('bundles/btctrip/images/slide-01b.png') ?>" />
								<span class="offer-slider-overlay">
									<span class="offer-slider-btn">view details</span>
								</span>
							</a>
							<div class="offer-slider-txt">
								<div class="offer-slider-link"><a href="#">Rio de Janeiro</a></div>
								<div class="offer-slider-l">
									<div class="offer-slider-location">location: Brazil</div>
									<nav class="stars">
										<ul>
											<li><a href="#"><img alt="" src="<?php echo $view['assets']->getUrl('bundles/btctrip/images/star-b.png') ?>"/></a></li>
											<li><a href="#"><img alt="" src="<?php echo $view['assets']->getUrl('bundles/btctrip/images/star-b.png') ?>"/></a></li>
											<li><a href="#"><img alt="" src="<?php echo $view['assets']->getUrl('bundles/btctrip/images/star-b.png') ?>"/></a></li>
											<li><a href="#"><img alt="" src="<?php echo $view['assets']->getUrl('bundles/btctrip/images/star-b.png') ?>"/></a></li>
											<li><a href="#"><img alt="" src="<?php echo $view['assets']->getUrl('bundles/btctrip/images/star-a.png') ?>"/></a></li>
										</ul>
										<div class="clear"></div>
									</nav>
								</div>
								<div class="offer-slider-r">
									<b>900$</b>
									<span>avg/night</span>
								</div>
								<div class="offer-slider-devider"></div>								
								<div class="clear"></div>
							</div>
						</div>
					<!-- \\ -->
					<!-- // -->
						<div class="offer-slider-i">
							<a class="offer-slider-img" href="#">
								<img alt="" src="<?php echo $view['assets']->getUrl('bundles/btctrip/images/slide-01c.png') ?>" />
								<span class="offer-slider-overlay">
									<span class="offer-slider-btn">view details</span>
								</span>
							</a>
							<div class="offer-slider-txt">
								<div class="offer-slider-link"><a href="#">Fashion Week</a></div>
								<div class="offer-slider-l">
									<div class="offer-slider-location">location: USA</div>
									<nav class="stars">
										<ul>
											<li><a href="#"><img alt="" src="<?php echo $view['assets']->getUrl('bundles/btctrip/images/star-b.png') ?>"/></a></li>
											<li><a href="#"><img alt="" src="<?php echo $view['assets']->getUrl('bundles/btctrip/images/star-b.png') ?>"/></a></li>
											<li><a href="#"><img alt="" src="<?php echo $view['assets']->getUrl('bundles/btctrip/images/star-b.png') ?>"/></a></li>
											<li><a href="#"><img alt="" src="<?php echo $view['assets']->getUrl('bundles/btctrip/images/star-b.png') ?>"/></a></li>
											<li><a href="#"><img alt="" src="<?php echo $view['assets']->getUrl('bundles/btctrip/images/star-a.png') ?>"/></a></li>
										</ul>
										<div class="clear"></div>
									</nav>
								</div>
								<div class="offer-slider-r">
									<b>900$</b>
									<span>avg/night</span>
								</div>
								<div class="offer-slider-devider"></div>								
								<div class="clear"></div>
							</div>
						</div>
                        <!-- // -->
						<div class="offer-slider-i">
							<a class="offer-slider-img" href="#">
								<img alt="" src="<?php echo $view['assets']->getUrl('bundles/btctrip/images/slide-01d.png') ?>" />
								<span class="offer-slider-overlay">
									<span class="offer-slider-btn">view details</span>
								</span>
							</a>
							<div class="offer-slider-txt">
								<div class="offer-slider-link"><a href="#">Wanderlust Yoga Festival</a></div>
								<div class="offer-slider-l">
									<div class="offer-slider-location">location: USA</div>
									<nav class="stars">
										<ul>
											<li><a href="#"><img alt="" src="<?php echo $view['assets']->getUrl('bundles/btctrip/images/star-b.png') ?>"/></a></li>
											<li><a href="#"><img alt="" src="<?php echo $view['assets']->getUrl('bundles/btctrip/images/star-b.png') ?>"/></a></li>
											<li><a href="#"><img alt="" src="<?php echo $view['assets']->getUrl('bundles/btctrip/images/star-b.png') ?>"/></a></li>
											<li><a href="#"><img alt="" src="<?php echo $view['assets']->getUrl('bundles/btctrip/images/star-b.png') ?>"/></a></li>
											<li><a href="#"><img alt="" src="<?php echo $view['assets']->getUrl('bundles/btctrip/images/star-a.png') ?>"/></a></li>
										</ul>
										<div class="clear"></div>
									</nav>
								</div>
								<div class="offer-slider-r">
									<b>900$</b>
									<span>avg/night</span>
								</div>
								<div class="offer-slider-devider"></div>								
								<div class="clear"></div>
							</div>
						</div>
                         <!-- // -->
						<div class="offer-slider-i">
							<a class="offer-slider-img" href="#">
								<img alt="" src="<?php echo $view['assets']->getUrl('bundles/btctrip/images/slide-01e.png') ?>" />
								<span class="offer-slider-overlay">
									<span class="offer-slider-btn">view details</span>
								</span>
							</a>
							<div class="offer-slider-txt">
								<div class="offer-slider-link"><a href="#">Burning Man</a></div>
								<div class="offer-slider-l">
									<div class="offer-slider-location">location: USA</div>
									<nav class="stars">
										<ul>
											<li><a href="#"><img alt="" src="<?php echo $view['assets']->getUrl('bundles/btctrip/images/star-b.png') ?>"/></a></li>
											<li><a href="#"><img alt="" src="<?php echo $view['assets']->getUrl('bundles/btctrip/images/star-b.png') ?>"/></a></li>
											<li><a href="#"><img alt="" src="<?php echo $view['assets']->getUrl('bundles/btctrip/images/star-b.png') ?>"/></a></li>
											<li><a href="#"><img alt="" src="<?php echo $view['assets']->getUrl('bundles/btctrip/images/star-b.png') ?>"/></a></li>
											<li><a href="#"><img alt="" src="<?php echo $view['assets']->getUrl('bundles/btctrip/images/star-a.png') ?>"/></a></li>
										</ul>
										<div class="clear"></div>
									</nav>
								</div>
								<div class="offer-slider-r">
									<b>900$</b>
									<span>avg/night</span>
								</div>
								<div class="offer-slider-devider"></div>								
								<div class="clear"></div>
							</div>
						</div>						
                        <!-- // -->
						<div class="offer-slider-i">
							<a class="offer-slider-img" href="#">
								<img alt="" src="<?php echo $view['assets']->getUrl('bundles/btctrip/images/slide-01f.png') ?>" />
								<span class="offer-slider-overlay">
									<span class="offer-slider-btn">view details</span>
								</span>
							</a>
							<div class="offer-slider-txt">
								<div class="offer-slider-link"><a href="#">The Great Wall</a></div>
								<div class="offer-slider-l">
									<div class="offer-slider-location">location: China</div>
									<nav class="stars">
										<ul>
											<li><a href="#"><img alt="" src="<?php echo $view['assets']->getUrl('bundles/btctrip/images/star-b.png') ?>"/></a></li>
											<li><a href="#"><img alt="" src="<?php echo $view['assets']->getUrl('bundles/btctrip/images/star-b.png') ?>"/></a></li>
											<li><a href="#"><img alt="" src="<?php echo $view['assets']->getUrl('bundles/btctrip/images/star-b.png') ?>"/></a></li>
											<li><a href="#"><img alt="" src="<?php echo $view['assets']->getUrl('bundles/btctrip/images/star-b.png') ?>"/></a></li>
											<li><a href="#"><img alt="" src="<?php echo $view['assets']->getUrl('bundles/btctrip/images/star-a.png') ?>"/></a></li>
										</ul>
										<div class="clear"></div>
									</nav>
								</div>
								<div class="offer-slider-r">
									<b>900$</b>
									<span>avg/night</span>
								</div>
								<div class="offer-slider-devider"></div>								
								<div class="clear"></div>
							</div>
						</div>						
					<!-- // -->
					
					<!-- \\ -->
					</div>
				</div>
			</div>

			
					</div>
				</div>
			</div>
		</div>
	</div>

		<div class="mp-b">
			<div class="wrapper-padding">
				<div class="fly-in mp-b-left">
					<div class="mp-b-lbl">choose hotel by region</div>
					<!-- // regions // -->
						<div class="regions">
							<div class="regions-holder">
								<map id="imgmap201410281607" name="imgmap201410281607">
								<!--img alt="" usemap="#imgmap201410281607" width="347" height="177" src="img/world.png" id="imgmap201410281607">
									<area id="africa" shape="poly" alt="africa" title="" coords="183,153,173,129,176,115,170,107,163,97,145,98,138,85,141,75,149,63,161,58,169,57,173,56,172,61,182,65,185,62,199,65,204,77,211,89,212,92,222,92,221,96,210,110,207,117,221,125,217,141,203,138,192,152" href="" />
									<area id="asia" shape="poly" alt="asia" title="" coords="256,96,259,93,260,83,269,76,277,86,281,96,278,102,289,116,304,111,309,99,295,87,306,70,312,58,311,47,316,39,308,33,306,27,319,29,329,40,331,28,340,20,336,15,311,14,289,11,282,10,280,12,258,10,250,4,236,8,227,12,218,11,223,16,225,23,220,37,222,43,217,45,221,49,221,56,201,58,199,63,202,70,208,79,214,89,225,86,233,77,236,72,247,79" href="" />
									<area id="europe" shape="poly" alt="europe" title="" coords="191,56,177,55,170,46,157,56,149,54,157,38,171,31,168,20,183,11,197,14,220,16,220,32,218,42,213,47,219,55" href="" />
									<area id="austalia" shape="poly" alt="australia" title="" coords="302,155,315,150,322,153,327,162,335,161,342,154,342,108,328,103,321,110,326,119,313,128,297,138,296,151" href="" />
									<area id="north-america" shape="poly" alt="north_america" title="" coords="58,94,55,84,52,79,52,75,42,68,56,67,61,75,66,72,65,61,82,49,90,46,100,42,102,36,102,29,99,21,111,15,115,28,131,18,140,17,156,2,154,0,96,1,90,3,88,9,74,11,66,8,53,8,50,12,35,13,28,10,5,15,0,18,1,32,13,28,22,31,21,42,14,53,18,68,25,76,31,84,40,89" href="" />
									<area id="south-america" shape="poly" alt="south_america" title="" coords="62,102,68,89,81,92,99,101,99,106,105,109,118,113,117,122,113,126,110,140,103,143,97,156,88,165,75,169,71,137,70,131,56,121,54,113,56,106" href="" /-->
								</map>						
								<div class="asia"></div>
								<div class="africa"></div>
								<div class="austalia"></div>
								<div class="europe"></div>
								<div class="north-america"></div>
								<div class="south-america"></div>
							</div>
						</div>
					<!-- // regions // -->
					<nav class="regions-nav">
						<ul>
							<li><a class="europe" href="#">Europe</a></li>
							<li><a class="asia" href="#">Asia</a></li>
							<li><a class="north-america" href="#">North america</a></li>
							<li><a class="south-america" href="#">south america</a></li>
							<li><a class="africa" href="#">africa</a></li>
							<li><a class="austalia" href="#">australia</a></li>		
						</ul>
					</nav>
				</div>
				<div class="fly-in mp-b-right">
					<div class="mp-b-lbl">reasons to book with us</div>
					<div class="reasons-item-a">
						<div class="reasons-lbl">Why?</div>
						<div class="reasons-txt">No intermediaries, we deal directly with hotels & transporters </div>
					</div>
					<div class="reasons-item-b">
						<div class="reasons-lbl">Best </div>
						<div class="reasons-txt">Outstanding customer service and customer satisfaction </div>
					</div>
					<div class="clear"></div>
					<div class="reasons-item-c">
						<div class="reasons-lbl">Difference</div>
						<div class="reasons-txt">Experience </div>
					</div>
					<div class="reasons-item-d">
						<div class="reasons-lbl"> Where?</div>
						<div class="reasons-txt">Choice of best accommodation available </div>
					</div>
					<div class="clear"></div>
				</div>
				<div class="clear"></div>
			</div>
		</div>
	
	</div>

</div>


<?php $view['slots']->stop() ?>

<?php $view['slots']->start('secondContent') ?>



<?php $view['slots']->stop()?>

<?php $view['slots']->start('javascripts')?>


<?php $view['slots']->stop() ?>


