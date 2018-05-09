<?php
namespace BtcTrip\MainBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Acceso a los gateways de pagos administracion de los pagos.
 * 
 * @author yamil
 *
 */
class PaymentManager {
	protected $container;
	
	const GATEWAY_BITPAY = 'BitPay';
	const GATEWAY_GOCOIN = 'GoCoin';
	
	public function __construct(ContainerInterface $container) {
		$this->container = $container;
	}

	public function retrieveOrCreateInvoice($currency, $preorderId, $basePrice, $posData, $orderType) {
		$logger = $this->container->get('logger');
		$invoice = null;
		
		// invoice de bitpay
		if ($currency == 'BTC') {
			$collection = $this->container->get('mega_helper')->getCollection('BitpayInvoice');
			$bitpayInvoice = $collection->findOne(array('posData' => new \MongoRegex("/".$posData.".*".$orderType."/")));

			if (isset($bitpayInvoice)) {
				$invoice = $this->getBtctripInvoiceFromBitpay($bitpayInvoice);
			} else {
				$invoice = $this->createInvoiceBitpay($preorderId, $basePrice, $posData, $orderType);
			}
		}
		// invoice de gocoin
		else if ($currency == 'XDG' || $currency == 'LTC') {
			$collection = $this->container->get('mega_helper')->getCollection('GocoinInvoice');
			$gcInvoice = $collection->findOne(array('data' => new \MongoRegex("/".$posData.".*".$orderType."/"), 'price_currency' => $currency));
			
			if (isset($gcInvoice)) {
				$invoice = $this->getBtctripInvoiceFromGocoin($gcInvoice);
			} else {
				$invoice = $this->createInvoiceGocoin($currency, $preorderId, $basePrice, $posData, $orderType);
			}
		}
		
		return $invoice;
	}
	
	// Devuele un link con el invoice para meter en un iframe
	public function createInvoice($currency, $preorderId, $basePrice, $posData, $orderType) {
		$invoice = null;
		
		// invoice de bitpay
		if ($currency == 'BTC') {
			$invoice = $this->createInvoiceBitpay($preorderId, $basePrice, $posData, $orderType);
		} 
		// invoice vi gocoin
		else if ($currency == 'XDG' || $currency == 'LTC') {
			$invoice = $this->createInvoiceGocoin($currency, $preorderId, $basePrice, $posData, $orderType);
		}

		return $invoice;
	}
	
	private function createInvoiceBitpay($preorderId, $basePrice, $posData, $orderType) {
		$invoice = null;

		$logger = $this->container->get('logger');
		$bitpayService = $this->container->get('bit_pay_api');
		
		$bitpayInvoice = $bitpayService->bpCreateInvoice($preorderId, $basePrice, $posData, $orderType);
		$logger->debug('BitPay Invoice: ' . print_r($bitpayInvoice, true));
		
		if (is_array($bitpayInvoice)) {
			$bpCollection = $this->container->get('mega_helper')->getCollection('BitpayInvoice');
			$bpCollection->save($bitpayInvoice);
				
			$invoice = $this->getBtctripInvoiceFromBitpay($bitpayInvoice);
		}
		
		return $invoice;
	} 
	
	private function getBtctripInvoiceFromBitpay($bitpayInvoice) {
		$invoice = null;

		$invoice['gateway'] = $this::GATEWAY_BITPAY;
		$invoice['id'] = $bitpayInvoice['_id'];
		$invoice['url'] = $bitpayInvoice['url'].'&view=iframe';
			
		$invoice['price'] = $bitpayInvoice['btcPrice'];
		$invoice['currency'] = 'BTC';
		$invoice['basePrice'] = $bitpayInvoice['price'];
		$invoice['baseCurrency'] = $bitpayInvoice['currency'];
		$invoice['creationTime'] = $bitpayInvoice['invoiceTime'];
		
		return $invoice;
	}
	
	
	private function createInvoiceGocoin($currency, $preorderId, $price, $posData, $orderType) {
		$logger = $this->container->get('logger');
		$gocoinService = $this->container->get('go_coin_api');
		
		$gcInvoice = (array)$gocoinService->createInvoice($currency, $preorderId, $price, $posData, $orderType);

		// si se creo ok
		
		// persistirla
		$gcCollection = $this->container->get('mega_helper')->getCollection('GocoinInvoice');
		$gcCollection->save($gcInvoice);

		return $this->getBtctripInvoiceFromGocoin($gcInvoice);
	}
	
	private function getBtctripInvoiceFromGocoin($gcInvoice) {
		$invoice = null;
		
		// generar la invoice btctrip
		$invoice['gateway'] = $this::GATEWAY_GOCOIN;
		$invoice['id'] = $gcInvoice['_id'];
		$invoice['url'] = $gcInvoice['gateway_url'] . '?hide_header=true&hide_footer=true';
			
		$invoice['price'] = $gcInvoice['price'];
		$invoice['currency'] = $gcInvoice['price_currency'];
		$invoice['basePrice'] = $gcInvoice['base_price'];
		$invoice['baseCurrency'] = $gcInvoice['base_price_currency'];
		$invoice['creationTime'] = $gcInvoice['created_at'];
		
		return $invoice;
	}
	
	
}