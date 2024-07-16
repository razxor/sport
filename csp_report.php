<?php
	$fn = '/tmp/bc_csp.txt';
	$json_data = file_get_contents('php://input');
	
	$a = json_decode($json_data, true);
	
	$data = '';
	$data .= "TS: ".date('c')."\n";
	$data .= "IP: {$_SERVER['REMOTE_ADDR']}\n";
	$data .= "UA: {$_SERVER['HTTP_USER_AGENT']}\n";
	foreach ($a['csp-report'] as $k=>$v)
	{
		$data .= "{$k} => {$v}\n";
	}
	
	$data .= "\n---------------------------------------------------------------\n\n";
	
	$fp = fopen($fn, 'a');
	fwrite($fp, $data);
	fclose($fp);
?>