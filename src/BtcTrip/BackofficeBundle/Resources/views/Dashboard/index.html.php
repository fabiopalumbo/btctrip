<?php $view->extend('BtcTripBackofficeBundle::layout.html.php') ?>

<?php $view['slots']->start('page_body') ?>

		<div class="jarviswidget jarviswidget-color-darken jarviswidget-sortable" id="wid-id-1" data-widget-editbutton="false" role="widget">
			<header role="heading"><div class="jarviswidget-ctrls" role="menu">   <a href="#" class="button-icon jarviswidget-toggle-btn" rel="tooltip" title="" data-placement="bottom" data-original-title="Collapse"><i class="fa fa-minus "></i></a> <a href="javascript:void(0);" class="button-icon jarviswidget-fullscreen-btn" rel="tooltip" title="" data-placement="bottom" data-original-title="Fullscreen"><i class="fa fa-resize-full "></i></a> <a href="javascript:void(0);" class="button-icon jarviswidget-delete-btn" rel="tooltip" title="" data-placement="bottom" data-original-title="Delete"><i class="fa fa-times"></i></a></div>
				<span class="widget-icon"> <i class="fa fa-inbox"></i> </span>
				<h2>Orders</h2>
				<span class="jarviswidget-loader"><i class="fa fa-refresh fa-spin"></i></span>
			</header>

			<!-- widget div-->
			<div role="content">

				<!-- widget edit box -->
				<div class="jarviswidget-editbox">
					<!-- This area used as dropdown edit box -->

				</div>
				<!-- end widget edit box -->

				<!-- widget content -->
				<div class="widget-body no-padding">

					<table class="table table-bordered table-striped">
						<thead>
							<tr>
								<th>Numero</th>
								<th>Tipo</th>								
								<th>Fecha</th>
								<th>Cliente</th>
								<th>Precio final</th>
								<th>Estado</th>
								<th>Acciones</th>
							</tr>
						</thead>
						<tbody>

					<?php foreach ($orders as $order) {	?>
							<tr>
								<td><?php echo $order['number']  ?></td>
								<td><?php echo $order['type']  ?></td>
								<td><?php echo gmdate("d-m-Y\ H:i", $order['_id']->getTimestamp())  ?></td>
								<td><?php echo $order['buyerInfo']['passengerDefinitions'][0]['firstName'] . " " . 
												$order['buyerInfo']['passengerDefinitions'][0]['lastName'] ?></td>
								<td><?php
									if ($order['type'] == 'flight') {
										echo $order['itinerary']['itenerariesBoxPriceInfoList'][0]['total']['fare']['raw'];
									} else if ($order['type'] == 'hotel') {
										echo $order['item']['hotel']['room']['prices']['totalPrice']['totalPrice'];
									} 
								?></td>
								<td><?php echo $order['status'] ?></td>
								<td><a href="<?php echo $view['router']->generate('flight_detail', array('orderId' => $order['_id'])) ?>">Detalle</a></td>
							</tr>
					<?php }  ?>
						</tbody>
					</table>

				</div>
				<!-- end widget content -->

			</div>
			<!-- end widget div -->

		</div>


<?php $view['slots']->stop() ?>