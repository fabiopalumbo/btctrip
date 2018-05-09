{% extends "BtcTripHotelsBundle::base.html.twig" %}

 {% block stylesheets %}

<link type="text/css" rel="stylesheet" href="{{ asset('bundles/btctriphotels/css/bootstrap.css')}}"/>
<link type="text/css" rel="stylesheet" href="{{ asset('bundles/btctriphotels/css/main.css')}}"/>
<link type="text/css" rel="stylesheet" href="{{ asset('bundles/btctriphotels/css/socialmedia.css')}}"/>
<link type="text/css" rel="stylesheet" href="{{ asset('bundles/btctriphotels/css/home.css')}}"/>
<!--searchbox-css-->
<link type="text/css" rel="stylesheet" href="{{ asset('bundles/btctriphotels/css/fl-big.css')}}"/>
<!--searchbox-css END-->
<link type="text/css" rel="stylesheet" href="{{ asset('bundles/btctriphotels/css/ajax-coin-slider-styles.css')}}"/>
{% endblock stylesheets %}

{% block javascripts %}
<script type="text/javascript" src="{{ asset('bundles/btctriphotels/js/jquery-1.10.2.js')}}"> </script>
<script type="text/javascript" src="{{ asset('bundles/btctriphotels/js/base.js')}}"> </script>
<script type="text/javascript" src="{{ asset('bundles/btctriphotels/js/jquery-1.10.2.js')}}"> </script>
<script type="text/javascript" src="{{ asset('bundles/btctriphotels/js/ajax-coin-slider.js')}}"> </script>
<script type="text/javascript" src="{{ asset('bundles/btctriphotels/js/extjs.js')}}"></script>
<script src="{{ asset('bundles/btctriphotels/js/home.js')}}"></script>
<script type="text/javascript" src="{{ asset('bundles/btctriphotels/js/searchboxHelper.js')}}"></script>
<script type="text/javascript" src="{{ asset('bundles/btctriphotels/js/searchbox.fl.js')}}"></script>
<script charset="utf-8" type="text/javascript" src="{{ asset('bundles/btctriphotels/js/top-airlines-cities-ar.js')}}"></script>
<script type="text/javascript" src="{{ asset('bundles/btctriphotels/js/autocomplete.js')}}"></script>
<script type="text/javascript" src="{{ asset('bundles/btctriphotels/js/require-2.js')}}"></script>
{% endblock javascripts %}
	

<div class="row">
	<div class="span12">
	
		<div class="header" id="header">
		<!--header-html-->
			<div class="header-container">
				<div class="logo-and-contact-container">
					<div class="logo-container">
						<a href="/"><img src="/bundles/btctriphotels/images/logo.gif" class="logo"></a>
					</div>
				
					<div class="personal-info">
					</div>
				</div>
			
			</div>
			<!--header-html END-->
		</div>
	</div>
</div>


<div class="row social-breadcrumbs">
	<div class=" span4">
		
	</div>
	<div class="offset7 span1">
		<a href="http://www.facebook.com/pages/BtcTrip/204523923004550"  target="_blank"><img src="/bundles/btctriphotels/images/facebook.png" alt="Facebook" ></a>
		<a href="https://twitter.com/btctrip"  target="_blank"><img src="/bundles/btctriphotels/images/twitter.png" alt="Twitter" ></a>
	</div>
</div>


<div class="row">


</div>



<div class="row footer">
		<div class="span12">&copy 2013 BtcTrip | <a href="https://www.weusecoins.com" target="_blank">What is Bitcoin?</a> 
		| <a href="http://howtobuybitcoins.info" target="_blank">How to buy Bitcoins?</a> 
		| <a href="mailto:investors@btctrip.com"  >Investors</a> 
		| <a href="mailto:contact@btctrip.com"  >Contact</a>
		| <a href="<?php echo $view['router']->generate('btc_trip_about_us') ?>"> About us</a>
		</div>
</div>
