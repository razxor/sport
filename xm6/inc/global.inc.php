<?php
	require dirname(__FILE__).'/../../inc/config.inc.php';
	require dirname(__FILE__).'/../../inc/util.inc.php';
	require dirname(__FILE__).'/../../inc/data.inc.php';
	require dirname(__FILE__).'/../../classes/class.db.php';
	require dirname(__FILE__).'/../../classes/class.sess.php';
	require dirname(__FILE__).'/../../classes/class.user.php';
	require dirname(__FILE__).'/../../classes/class.pp.php';

	
	$db = new db($connect);
	$sh = new sess();
	$usr = new user($db);
	
	$ext2mime = array(
		'jpg' => 'image/jpeg',
		'png' => 'image/png',
		'pdf' => 'application/pdf'
	);
	$mime2ext = array_flip($ext2mime);
	$f_all_ext = array('pdf');
	$pic_all_ext = array('jpg', 'png');
	$ext2fa = array(
		'jpg' => 'file-image-o',
		'png' => 'file-image-o',
		'pdf' => 'file-pdf-o'
	);
	$yn = array(0 => 'No', 1 => 'Yes');
?>