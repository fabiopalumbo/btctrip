<?php $view->extend('BtcTripSearchBundle::layout.html.php') ?>

<?php $view['slots']->set('bodyClass', 'checkout') ?>

<?php $view['slots']->start('stylesheets') ?>
<?php $view['slots']->stop() ?>

<?php $view['slots']->start('mainContent') ?>

<div class="span12 container-white">
	<div class="information-container" >
		<span><?php echo $message ?></span>
	</div>
</div>



<?php $view['slots']->stop() ?>