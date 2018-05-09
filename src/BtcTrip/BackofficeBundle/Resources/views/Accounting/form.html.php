<?php $view->extend('BtcTripBackofficeBundle::layout.html.php') ?>

<?php $view['slots']->set('breadcrumb', 'Accounting') ?>

<?php $view['slots']->start('page_body') ?>


<div id="row">
		
	<article class="col-sm-12 col-md-12 col-lg-12 sortable-grid ui-sortable">
	
			<div id="result" class="alert alert-block alert-info hide">
				<a class="close" data-dismiss="alert" href="#">x</a>
				<p id="resultMessage">Updated!</p>
			</div>
							
			<!-- Widget ID (each widget will need unique ID)-->
				
			<!-- end widget -->
	
			<div class="jarviswidget jarviswidget-sortable" id="wid-id-1" data-widget-colorbutton="false" data-widget-editbutton="false" data-widget-custombutton="false" role="widget" style="">
					
					<header role="heading"><div class="jarviswidget-ctrls" role="menu">   <a href="#" class="button-icon jarviswidget-toggle-btn" rel="tooltip" title="" data-placement="bottom" data-original-title="Collapse"><i class="fa fa-minus "></i></a> <a href="javascript:void(0);" class="button-icon jarviswidget-fullscreen-btn" rel="tooltip" title="" data-placement="bottom" data-original-title="Fullscreen"><i class="fa fa-resize-full "></i></a> <a href="javascript:void(0);" class="button-icon jarviswidget-delete-btn" rel="tooltip" title="" data-placement="bottom" data-original-title="Delete"><i class="fa fa-times"></i></a></div>
						<span class="widget-icon"> <i class="fa fa-edit"></i> </span>
						<h2>Despegar Payment Information</h2>
	
					<span class="jarviswidget-loader"><i class="fa fa-refresh fa-spin"></i></span></header>
	
					<!-- widget div-->
					<div role="content">
	
						<!-- widget edit box -->
						<div class="jarviswidget-editbox">
							<!-- This area used as dropdown edit box -->
	
						</div>
						<!-- end widget edit box -->
	
						<!-- widget content -->
						<div class="widget-body no-padding">
	
							<form class="smart-form" action="<?php echo $view['router']->generate('accounting_submit') ?>" method="post" id="paymentInfoForm" >
								<!--  <header>
									Informaci—n para el pago de las reservas a Despegar
								</header>   -->

								<fieldset>
									<label class="label">Agencia</label>
									
									<section class="col col-6">
										<label class="label">Email</label>
										<label class="input">
											<input type="text" class="input-sm" name="agency[email]" value="<?php echo $paymentInfo['agency']['email'] ?>">
										</label>
									</section>

									<section class="col col-6">
										<ul class="inline-bullets" >
											<li>
												<label  class="label">Tel&eacute;fono</label>
												<label  class="input">
												   	<select  name="agency[phone][type]" class="input-sm">
													   		<option value="CELULAR" <?php echo ( $paymentInfo['agency']['phone']['type'] == 'CELULAR' ? 'selected' : '' ) ?> >
													   			Celular</option>
													   		<option value="HOME" <?php echo ( $paymentInfo['agency']['phone']['type'] == 'HOME' ? 'selected' : '' ) ?>>
													   			Casa</option>
													   		<option value="WORK" <?php echo ( $paymentInfo['agency']['phone']['type'] == 'WORK' ? 'selected' : '' ) ?>>
													   			Trabajo</option>
													   		<option value="FAX" <?php echo ( $paymentInfo['agency']['phone']['type'] == 'FAX' ? 'selected' : '' ) ?>>
													   			Fax</option>
													   		<option value="OTHER" <?php echo ( $paymentInfo['agency']['phone']['type'] == 'OTHER' ? 'selected' : '' ) ?>>
													   			Otro</option>
												   </select>
											   </label>
											</li>
											<li>
												<label class="label"> Pa&iacute;s</label>
												<label  class="input">
													<input  name="agency[phone][countryCode]" type="text" class="input-sm short-input" value="<?php echo $paymentInfo['agency']['phone']['countryCode'] ?>">
												</label>
											</li>
											<li>
												<label class="label">C&oacute;digo</label>
												<label  class="input">
													<input  name="agency[phone][areaCode]" class=" input-sm short-input" type="text" value="<?php echo $paymentInfo['agency']['phone']['areaCode'] ?>">
												</label>
											</li>
											<li>
												<label class="label">N&uacute;mero</label>
												<label  class="input">
													<input  name="agency[phone][number]" class="input-sm " type="text" value="<?php echo $paymentInfo['agency']['phone']['number'] ?>">
												</label>
											</li>
										</ul>
												
<!-- 									<!--	<label class="label">Telefono</label> -->
<!-- 									<!--	<label class="input"> -->
										<!--	<input type="text" class="input-sm" name="agency[email]" value="<?php echo $paymentInfo['agency']['email'] ?>">
<!-- 										</label> -->
									</section>
																		
								</fieldset>
							
							
								<fieldset>
									<label class="label">Cupon</label>
									
									<section class="col col-6">
										<label class="label">Codigo</label>
										<label class="input">
											<input type="text" class="input-sm" name="voucher[code]" value="<?php echo $paymentInfo['voucher']['code'] ?>">
										</label>
									</section>
									
									<section class="col col-6">
										<label class="label">Disponible</label>
										<label class="input">
											<input type="text" class="input-sm" name="voucher[value]" value="<?php echo $paymentInfo['voucher']['value'] ?>">
										</label>
									</section>
								
								</fieldset>
						
						
								<fieldset>
									<label class="label">Tarjeta</label>
									
									<section class="col col-6">
										<label class="label">Numero</label>
										<label class="input">
											<input type="text" class="input-sm" name="creditcard[number]" value="<?php echo $paymentInfo['creditcard']['number'] ?>">
										</label>
									</section>
									
									<section class="col col-6">
										<label class="label">Titular</label>
										<label class="input">
											<input type="text" class="input-sm" name="creditcard[holderName]" value="<?php echo $paymentInfo['creditcard']['holderName'] ?>">
										</label>
									</section>
									
									<section class="col col-4">
										<label class="label">Marca</label>
										<label class="input">
											<input type="text" class="input-sm" name="creditcard[brand]" value="<?php echo $paymentInfo['creditcard']['brand'] ?>">
										</label>
									</section>
									
									<section class="col col-4">
										<label class="label">Vencimiento</label>
										<label class="input">
											<input type="text" class="input-sm" name="creditcard[expirationDate]" placeHolder="yyyy-mm" value="<?php echo $paymentInfo['creditcard']['expirationDate'] ?>">
										</label>
									</section>
									
									<section class="col col-4">
										<label class="label">Codigo seguridad</label>
										<label class="input">
											<input type="password" class="input-sm" name="creditcard[securityCode]" value="<?php echo $paymentInfo['creditcard']['securityCode'] ?>">
										</label>
									</section>
								
								</fieldset>
								

								<footer>
									<button type="submit" class="btn btn-primary">
										Submit
									</button>
									<button type="button" class="btn btn-default" onclick="window.history.back();">
										Back
									</button>
								</footer>
								
								<input type="hidden" name="_id" value="<?php echo $paymentInfo['_id'] ?>">
								
							</form>
	
						</div>
						<!-- end widget content -->
	
					</div>
					<!-- end widget div -->
	
				</div>
			</article>

</div> 	
 

<?php $view['slots']->stop() ?>


<?php $view['slots']->start('javascripts') ?>
	<script  type="text/javascript"> 
		var $form = $( "#paymentInfoForm" );
		
		// Attach a submit handler to the form
		$form.submit(function( event ) {
		 
		  // Stop form from submitting normally
		  event.preventDefault();
		 
		  // Send the data using post
		  var posting = $.post( $form.attr('action'), $form.serialize() );
		 
		  // Put the results in a div
		  posting.done(function( data ) {
			  var jsonData = JSON.parse(data);
			  $("#result").removeClass('hide');
			  $("#resultMessage").empty().append( jsonData.result.message );
		  });
		});
	
	</script>
<?php $view['slots']->stop() ?>
