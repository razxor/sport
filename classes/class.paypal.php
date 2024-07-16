<?php
	class paypal
	{
		public static function create($p)
		{
			global $paypal, $url_proto, $maindw, $paypal_live;
			
			$d = bc::get_purchase_item($p);
			
			$apiContext = new \PayPal\Rest\ApiContext(new \PayPal\Auth\OAuthTokenCredential($paypal['client_id'], $paypal['secret']));
			$apiContext->setConfig(
				array(
					'mode' => $paypal_live ? 'live' : 'sandbox',
					'log.LogEnabled' => true,
					'log.FileName' => '/tmp/bc_PayPal1.log',
					'log.LogLevel' => 'DEBUG',
					'cache.enabled' => false,
				)
			);
			
			$payer = new \PayPal\Api\Payer();
			$payer->setPaymentMethod('paypal');
			
			$item1 = new \PayPal\Api\Item();
			$item1->setName($d['item_name'])->setCurrency('USD')->setQuantity(1)->setSku($d['item_number'])->setPrice($d['price']);
			
			$itemList = new \PayPal\Api\ItemList();
			$itemList->setItems(array($item1));
			
			$amount = new \PayPal\Api\Amount();
			$amount->setTotal($d['price']);
			$amount->setCurrency('USD');
			
			$transaction = new \PayPal\Api\Transaction();
			$transaction->setAmount($amount)->setItemList($itemList)->setDescription($d['item_name'])->setCustom($d['custom']);
			
			$redirectUrls = new \PayPal\Api\RedirectUrls();
			$redirectUrls->setReturnUrl("{$url_proto}://{$maindw}/purchases/complete/")->setCancelUrl("{$url_proto}://{$maindw}/purchases/");
			
			$payment = new \PayPal\Api\Payment();
			$payment->setIntent('sale')->setPayer($payer)->setTransactions(array($transaction))->setRedirectUrls($redirectUrls);
			
			try {
				$payment->create($apiContext);
			} catch (\PayPal\Exception\PayPalConnectionException $ex) {
				echo $ex->getData();
			}
			
			return $payment;
		}
		
		public static function execute($p)
		{
			global $paypal, $paypal_live;
			
			$apiContext = new \PayPal\Rest\ApiContext(new \PayPal\Auth\OAuthTokenCredential($paypal['client_id'], $paypal['secret']));
			$apiContext->setConfig(
				array(
					'mode' => $paypal_live ? 'live' : 'sandbox',
					'log.LogEnabled' => true,
					'log.FileName' => '/tmp/bc_PayPal2.log',
					'log.LogLevel' => 'DEBUG',
					'cache.enabled' => false,
				)
			);
			
			$payment = \PayPal\Api\Payment::get($p['paymentID'], $apiContext);
		
			$execution = new \PayPal\Api\PaymentExecution();
			$execution->setPayerId($p['payerID']);
			
			try {
				$result = $payment->execute($execution, $apiContext);
				
				try {
					$payment = \PayPal\Api\Payment::get($p['paymentID'], $apiContext);
					return $payment;
				} catch (Exception $e) {
					var_dump($e);
					return false;
				}
				
			} catch (Exception $e) {
				var_dump($e);
				return false;
			}
			
			return false;
		}
		
		public static function insert_order($payment)
		{
			global $db, $purchase_notify;
			
			$trx_l = $payment->getTransactions();
			$trx = $trx_l[0];
			
			$custom = $trx->getCustom();
			$itml = $trx->getItemList();
			$itm_l = $itml->getItems();
			$itm = $itm_l[0];
			$item_number = $itm->getSku();
			$item_name = $itm->getName();
			
			$a = explode('|', $custom);
			$cli_email = strtolower($a[0]);
			$user_id = @$a[1];
			$cli_name = $payment->getPayer()->getPayerInfo()->getFirstName().' '.$payment->getPayer()->getPayerInfo()->getLastName();
			
			$a = explode('.', $item_number);
			$year = $a[0];
			$week = @$a[1];
			$c_week = bc::get_week($year, 'G');
			$opt = count($a) == 1 ? 'y' : 'w';
			$c_ts = time();
			
			$txn_id = $trx->getRelatedResources()[0]->getSale()->getId();
			$amount = $trx->getAmount()->getTotal();
			
			$db->query("INSERT INTO orders (c_ts, user_id, email, name, opt, year, week, price, txn_id, status)
						VALUES (%u, %u, '%s', '%s', '%s', %u, %u, %.2f, '%s', '%s')",
						$c_ts, $user_id, $cli_email, $cli_name, $opt, $year, $week, $amount, $txn_id, 'C');
			
			$order_id = $db->insert_id();
			
			$sdata = array(
				'order_id' => $order_id,
				'c_ts' => $c_ts,
				'email' => $cli_email,
				'name' => $cli_name
			);
			
			sub::have_paid($sdata);
			
			$edata = array(
				'email' => $cli_email,
				'cli_name' => $cli_name,
				'c_ts' => $c_ts,
				'order_id' => $order_id,
				'item_name' => $item_name,
				'price' => $amount,
				'txn_id' => $txn_id
			);
			
			$picks = sub::get_picks($year, $c_week, 'final');
			$subj = "Order confirmation and Week {$c_week} picks";
			
			if (!$picks)
			{
				$picks = sub::get_picks($year, $c_week, 'probable');
				$subj = "Order confirmation and PROBABLE picks for Week {$c_week}";
			}

			if (!$picks)
			{
				$picks = array();
				$sub = 'Order confirmation';
			}
			
			pp::games($picks);
			$edata['picks'] = $picks;
			$edata['sender'] = 'sender2';
			
			send_email('pay_success', $edata, $subj);
			
			$data2['order_id'] = $order_id;
			$data2['email'] = $purchase_notify;
			$data2['c_ts'] = $c_ts;
			$data2['amount'] = $amount;
			$data2['item'] = $item_number;
			$data2['is_html'] = false;
			send_email('admin_notify', $data2, 'New order');
			
			//notify admin? - YES, send text-only to $purchase_notify (will be email2txt)
		}
	}
?>