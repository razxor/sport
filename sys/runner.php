<?php
	require dirname(__FILE__).'/../inc/global.inc.php';
	require dirname(__FILE__).'/../classes/class.xml.php';
	require dirname(__FILE__).'/../classes/class.runner.php';
	require dirname(__FILE__).'/../classes/class.sub.php';
	require dirname(__FILE__).'/../libs/phpmailer/PHPMailerAutoload.php';
	
	$runner = new runner();
	$runner->main();
?>