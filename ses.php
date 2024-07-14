<?php
	$input = file_get_contents("php://input");

	$allowed_topic = "arn:aws:sns:us-east-1:013333660861:bc-bounce";
	$source_domain = "sns.us-east-1.amazonaws.com";
	
	$json = json_decode($input);

	$logfile = '/tmp/bc_bounce.txt';

	$fp = fopen($logfile, 'a');
	fwrite($fp, print_r($json, 1)."\n\n\n\n");
	//fwrite($fp, $input."\n\n\n\n");
	fclose($fp);
	
	if ($json->TopicArn != $allowed_topic)
	{
		log2f("{$json->TopicArn} != {$allowed_topic}");
		die();
	}

	$pu = parse_url($json->SigningCertURL);
	if ($pu['host'] != $source_domain)
	{
		log2f("{$source_domain} != {$pu['host']} in {$json->SigningCertURL}");
		die();
	}
	
	if ($json->Type == 'SubscriptionConfirmation')
	{
		$valstr = "";
		$valstr .= "Message\n";
		$valstr .= $json->Message . "\n";
		$valstr .= "MessageId\n";
		$valstr .= $json->MessageId . "\n";
		$valstr .= "SubscribeURL\n";
		$valstr .= $json->SubscribeURL . "\n";
		$valstr .= "Timestamp\n";
		$valstr .= $json->Timestamp . "\n";
		$valstr .= "Token\n";
		$valstr .= $json->Token . "\n";
		$valstr .= "TopicArn\n";
		$valstr .= $json->TopicArn . "\n";
		$valstr .= "Type\n";
		$valstr .= $json->Type . "\n";
	}
	else
	{
		$valstr = "";
		$valstr .= "Message\n";
		$valstr .= $json->Message . "\n";
		$valstr .= "MessageId\n";
		$valstr .= $json->MessageId . "\n";
		if ($json->Subject != '')
		{
			$valstr .= "Subject\n";
			$valstr .= $json->Subject . "\n";
		}
		$valstr .= "Timestamp\n";
		$valstr .= $json->Timestamp . "\n";
		$valstr .= "TopicArn\n";
		$valstr .= $json->TopicArn . "\n";
		$valstr .= "Type\n";
		$valstr .= $json->Type . "\n";
	}
	
	$signature_valid = validate_certificate($json->SigningCertURL, $json->Signature, $valstr);
	if (!$signature_valid)
	{
		log2f("Data and Signature Do No Match Certificate or Certificate Error.");
		die();
	}
	
	if ($json->Type == "SubscriptionConfirmation")
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $json->SubscribeURL);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
		curl_exec($ch);
		curl_close($ch);
	}
	
	require 'inc/global.inc.php';
	require 'classes/class.sub.php';

	if ($json->Type == "Notification")
	{
		$a = json_decode($json->Message);
		if ($a->notificationType == 'Bounce')
		{
			foreach ($a->bounce->bouncedRecipients as $v)
			{
				$email = $v->emailAddress;
				sub::bounce($email);
				log2f("DELETED {$email}");
			}
		}
		if ($a->notificationType == 'Complaint')
		{
			foreach ($a->complaint->complainedRecipients as $v)
			{
				$email = $v->emailAddress;
				sub::bounce($email);
				log2f("DELETED {$email}");
			}
		}
	}
	
	function validate_certificate($keyFileURL, $signatureString, $data)
	{
		$signature = base64_decode($signatureString);
		$fp = fopen($keyFileURL, "r");
		$cert = fread($fp, 8192);
		fclose($fp);
		$pubkeyid = openssl_get_publickey($cert);
		$ok = openssl_verify($data, $signature, $pubkeyid, OPENSSL_ALGO_SHA1);
		if ($ok == 1)
			return true;
		return false;
	}
	
	function log2f($str)
	{
		$logfile = '/tmp/ses_bounce.txt';
		$fp = fopen($logfile, 'a');
		fwrite($fp, "---> {$str} <---\n\n");
		fclose($fp);
	}
?>