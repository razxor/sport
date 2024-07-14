<?php
	require '../../inc/global.inc.php';
	require '../../inc/req_auth.inc.php';
	require 'common.inc.php';
	
	$ea = array();
	$ea2 = array();
	
	foreach ($_FILES['f']['name'] as $k=>$v)
	{
		$pp = pathinfo($v);
		$pp['extension'] = strtolower($pp['extension']);
		if (!in_array($pp['extension'], array('txt', 'csv')))
			$ea[] = array("f_{$k}", 'ext');
	}
	
	if (!count($ea))
	{
		foreach ($_FILES['f']['tmp_name'] as $k=>$v)
		{
			$str = file_get_contents($v);
			$ret = process_pick_data($str, $eax);
			if (!$ret)
			{
				foreach ($eax as $vv)
				{
					$ea2[$k][] = $vv;
				}
			}		
		}
		
		if (count($ea2))
			$ea[] = array('main', 'proc');
	}
	
	if (!count($ea))
	{
		$ret = array('ea' => array());
		header('Content-Type: application/json');
		echo json_encode($ret);
	}
	else
	{
		ob_start();
		require 'fup_estr.inc.php';
		$estr = ob_get_contents();
		ob_end_clean();
		
		$ret = array('ea' => $ea, 'estr' => $estr);
		header('Content-Type: application/json');
		echo json_encode($ret);
	}
?>