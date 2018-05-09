<!DOCTYPE html>
<!--[if IE 7]> <html class="ie7"> <![endif]-->
<!--[if IE 8]> <html class="ie8"> <![endif]-->
<!--[if IE 9]> <html class="ie9"> <![endif]-->
<!--[if gt IE 9]><!--> <html> <!--<![endif]-->

	<head>
	    <title><?php $view['slots']->output('title', 'BTCTrip - One for All, All for One!') ?></title>

	    <link rel="icon" type="image/x-icon" href="<?php echo $view['assets']->getUrl('favicon.ico') ?>" /> 
	
	    <meta charset="UTF-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=Edge;chrome=1">
		<meta name="description" content="Travel and leisure with Bitcoins. The travel agency of the cryptocurrencies communities.">
		
		<meta property="og:title" content="BTCTrip - One for All, All for One!"/>
		<meta property="og:type" content="article"/>
		<meta property="og:url" content="http://btctrip.com"/>
		<meta property="og:site_name" content="Btctrip.com"/>
		<meta property="og:description" content="Travel and leisure with Bitcoins. The travel agency of the cryptocurrencies communities."/>
	
	    <?php $view['slots']->output('layout_stylesheets') ?>
	    
	</head>
	<body class="<?php $view['slots']->output('bodyClass') ?> btctrip es_ar">
		<div class="preloadimages">
			<?php $view['slots']->output('layout_preloadimages') ?>
		</div>	
			
		<div class="container">
		 	<?php $view['slots']->output('layout_body') ?>
	 	
		</div>

   		<?php $view['slots']->output('layout_javascripts') ?>
   		
   		<script>
		  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
		
		  ga('create', 'UA-41639383-1', 'btctrip.com');
		  ga('send', 'pageview');
		
		</script>
		
	</body>
    
</html>
