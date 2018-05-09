<?php $view->extend('BtcTripSearchBundle::layout.html.php') ?>

<?php // $view['slots']->set('bodyClass', 'checkout') ?>

<?php $view['slots']->start('stylesheets') ?>

		<link type="text/css" rel="stylesheet" href="<?php echo $view['assets']->getUrl('bundles/btctrip/styles/about_us.css') ?>"/>


<?php $view['slots']->stop() ?>

<?php $view['slots']->start('mainContent') ?>

<div class="span12 container-white">
	<div id="wrapper" >
		
	
	
	<div id="main" role="main">
        <div id="main-content-header">
          <div class="container">
            <div class="row">
              <div class="span10 offset1">
                <h1 class="title">
                  About us
                  <small>The People behind BtcTrip. Our Locations.</small>
                </h1>
              </div>
            </div>
          </div>
        </div>
        <div id="main-content">
          <div class="container" id="team">
            <div class="row">
              <div class="span10 offset1">
                <div class="page-header page-header-with-icon">
                  <i class="fa-icon-group"></i>
                  <h2>
                    Our team
                  </h2>
                </div>
                <div class="profile-boxes">
                  <div class="row">
                    <div class="span3 offset1 profile-box ">
                      <div class="row">
                        <div class="span2 title">
                          <h5 class="name">Martin Fernandez</h5>
                          <h4 class="position">Founder &amp; CEO</h4>
                        </div>
                        <div class="span2"> 
                        <img alt="Martin" width="140" height="140" src="/bundles/btctrip/images/about_us/martin.jpg">
                        </div>
                          <div class="span2">
                            <a class="btn btn-medium-light btn-sm btn-circle" href="http://www.linkedin.com/in/martinfernandez666" target='_blank'>
                              <i class="fa-icon-linkedin"></i>
                            </a>
                          </div>
                      </div>
                    </div>
                    <div class="span3 profile-box">
                      <div class="row">
                         <div class="span2 title">
                          <h5 class="name">Yamil Alis</h5>
                          <h4 class="position">Founder &amp; CTO</h4>
                         </div>
                         <div class="span2">
                            <img alt="Yamil" width="140" height="140" src="/bundles/btctrip/images/about_us/yamil.jpg"> 
                         </div>
                         <div class="span2">
                            <a class="btn btn-medium-light btn-sm btn-circle" href="http://www.linkedin.com/in/yamilalis" target='_blank'>
                      	      <i class="fa-icon-linkedin"></i>
                            </a>
                         </div>
                      </div>
                    </div>
                    <div class="span3 profile-box">
                      <div class="row">
                        <div class="span2 title">
                          <h5 class="name">Daniel Rosenblatt</h5>
                          <h4 class="position">CFO</h4>
                        </div>
                        <div class="span2">
                            <img alt="Yamil" width="140" height="140" src="/bundles/btctrip/images/about_us/daniel.jpg"> 
	                    </div>
                          <div class="span2">
                            <a class="btn btn-medium-light btn-sm btn-circle" href="http://www.linkedin.com/in/rosenblattdaniel" target='_blank'>
                              <i class="fa-icon-linkedin"></i>
                            </a>
                          </div>
                      </div>
                    </div>
                    
                    
              </div>
                  <div class="row ">
                    
                    <div class="span3 offset2 profile-box ">
                      <div class="row">
                        <div class="span2 title">
                          <h5 class="name">Nicolas Cary</h5>
                          <h4 class="position">Advisor</h4>
                        </div>
                        <div class="span2">
                            <img alt="Charlie" width="140" height="140" src="/bundles/btctrip/images/about_us/nic.jpg">     
                         </div>
                        <div class="span2">
                            <a class="btn btn-medium-light btn-sm btn-circle" href="http://www.linkedin.com/in/ncary" target='_blank'>
                              <i class="fa-icon-linkedin"></i>
                            </a>
                          </div>
                      </div>
                    </div>
                    <div class="span3 offset1 profile-box">
                      <div class="row">
                        <div class="span2 title">
                          <h5 class="name">James Haft</h5>
                          <h4 class="position">Advisor</h4>
                        </div>
                        <div class="span2">
                            <img alt="James" width="140" height="140" src="/bundles/btctrip/images/about_us/james.jpg">    
                        </div>
                          <div class="span2">
                            <a class="btn btn-medium-light btn-sm btn-circle" href="http://www.linkedin.com/in/jameshaft" target="_blank">
                              <i class="fa-icon-linkedin"></i>
                            </a>
                          </div>
                      </div>
                    </div>
                  </div>
                  
                </div>
            </div>
            <div class="space"></div>
            <div class="row" id="locations">
              <div class="span10">
                <div class="page-header page-header-with-icon">
                  <i class="fa-icon-globe"></i>
                  <h2>
                    OUR LOCATIONS
                  </h2>
                </div>
                <div class="icono-boxes icono-boxes-lg">
                  <div class="row">
                    <div class="span5 icono-box">
                      <div class="icon icono-wrap icon-circle icono-lg contrast-bg">
                        <i class="fa-icon-map-marker text-white"></i>
                      </div>
                      <div class="content">
                        <h5 class="title">BTCTrip Buenos Aires</h5>
                        <h6>NXTP Labs</h6>
                        <p>Malabia 1720 2nd, Palermo Soho<br> 
						Ciudad Aut&oacute;noma de Buenos Aires,<br>
                        ARGENTINA</p><br>
                        <iframe width="290" height="200" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/maps?f=q&amp;source=s_q&amp;hl=es&amp;geocode=&amp;q=Malabia+1720,+Buenos+Aires,+Argentina&amp;aq=0&amp;oq=Malabia+1720,&amp;sll=37.0625,-95.677068&amp;sspn=56.506174,114.169922&amp;ie=UTF8&amp;hq=&amp;hnear=Malabia+1720,+Palermo,+Buenos+Aires,+Argentina&amp;t=h&amp;z=18&amp;ll=-34.59001,-58.425874&amp;output=embed&amp;iwloc=near"></iframe><br>
                      </div>
                    </div>
                  <div class="span5 icono-box">
                    <div class="icon icono-wrap icon-circle icono-lg contrast-bg">
                        <i class="fa-icon-map-marker text-white"></i>
                    </div>
                      <div class="content">
                        <h5 class="title">BTCTrip New York</h5>
                        <h6>PACIFIC ALLIANCE</h6>
                        <p>130 East 59th Street<br>
						New York, NY 10022<br>
                        USA</p><br>
                        <iframe width="290" height="200" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/maps?f=q&amp;source=s_q&amp;hl=es&amp;geocode=&amp;q=30+East+59th+Street,+Nueva+York+10022,+Estados+Unidos&amp;aq=0&amp;oq=30+East+59th+Street+New+York,+NY+10022&amp;sll=-34.59001,-58.425874&amp;sspn=0.007269,0.013937&amp;ie=UTF8&amp;hq=&amp;hnear=30+E+59th+St,+New+York,+10022&amp;t=h&amp;z=12&amp;ll=40.763627,-73.971538&amp;output=embed&amp;iwloc=near"></iframe><br>
                      </div>
                    </div>
                 </div>
                </div>
              </div>
            </div>
            <div class="row"></div>
          </div>
        </div>

      </div>
	
	
	  </div>
	</div>
</div>


<?php $view['slots']->stop() ?>
