<?php
	require 'inc/global.inc.php';
	require 'classes/class.paypal.php';
	require 'classes/class.sub.php';
	require 'libs/phpmailer/PHPMailerAutoload.php';
	
	paypal::ipn($_POST);
?>