<?php

namespace BtcTrip\SearchBundle\Command;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;

class BitpayCronCommand extends ContainerAwareCommand {
	protected function configure() {
		$this
			->setName ( 'BitpayCron' )
			->setDescription ( 'Trae la ultima cotizacion del bitcon de Bitpay.' );
	}
	
	protected function execute(InputInterface $input, OutputInterface $output) {
		
		$bitpayService = $this->getContainer()->get('bit_pay_api');

		$now = new \DateTime('now');
		$bitpayExchangeRate['timestamp'] = $now->getTimestamp();
		$bitpayExchangeRate['rate'] = $bitpayService->bpGetExchangeRate();	
		
		$collection = $this->getContainer()->get('mega_helper')->getCollection('BitpayExchangeRate');
		$collection->save($bitpayExchangeRate);
		
		// uncommented this line by db!
		$output->writeln ("Bitpay Search Exchange Rate: " . $bitpayExchangeRate["_id"] . ", rate: " . $bitpayExchangeRate["rate"]);
	}
}
