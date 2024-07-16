<?php
	ini_set('display_errors', 1);
	
	require 'inc/global.inc.php';

	$JS = array('/js/bc.js?2018022313');
	
	$page = isset($_GET['page'])?basename($_GET['page']) : 'index';
	$sub = isset($_GET['sub'])?basename($_GET['sub']) : 'main';
	if (isset($_GET['stub1']))
		require 'inc/stub1.inc.php';
	else if (isset($_GET['stub2']))
		require 'inc/stub2.inc.php';
	else if (isset($_GET['stub3']))
		require 'inc/stub3.inc.php';
	else if (isset($_GET['stub4']))
		require 'inc/stub4.inc.php';
	if (is_file($f = "pages/{$page}/{$sub}_.php"))
		require $f;

	$layout = @$layout ? $layout : 'default';
	if ($mobile_user)
		$layout .= '_m';
			
	$css_base = $mobile_user ? 'style_m' : 'style';
	$orig_css_fn = dirname(__FILE__)."/css/{$css_base}.css";
	$fa_css_fn = dirname(__FILE__).'/css/fa.min.css';
	$min_css_fn = "/dev/shm/{$maindw}_{$css_base}.min.css";
	$css_meta_fn = "/dev/shm/{$maindw}_{$css_base}.meta";
	$jar_fn = dirname(__FILE__)."/sys/yuicompressor-2.4.8.jar";
	$css_hash_method = 'sha256';
	
	$css_meta = @unserialize(file_get_contents($css_meta_fn));
	$css_mod_time = filemtime($orig_css_fn);
	
	if (0 && @$css_meta['ts'] != $css_mod_time)
	{
		$cmd = "/usr/bin/java -jar {$jar_fn} --type css ".escapeshellarg($orig_css_fn)." > ".escapeshellarg($min_css_fn);
		shell_exec($cmd);
		$fp = fopen($min_css_fn, 'a');
		fwrite($fp, file_get_contents($fa_css_fn));
		fclose($fp);
		
		$css_hash = base64_encode(hash_file($css_hash_method, $min_css_fn, true));
		$css_meta = array('ts' => $css_mod_time, 'hash' => $css_hash);
		file_put_contents($css_meta_fn, serialize($css_meta));
	}
	
	$css_nonce = rand(0x00000000, 0xFFFFFFFF - 1);
	if ($page != 'purchases')
		header("Content-Security-Policy: default-src 'none'; script-src 'self'; img-src 'self' data: https://www.google-analytics.com https://i.ytimg.com; style-src 'self' '{$css_hash_method}-{$css_meta['hash']}' 'nonce-{$css_nonce}'; font-src 'self'; connect-src 'self'; child-src https://www.google.com https://www.youtube.com; block-all-mixed-content; frame-ancestors 'none'; form-action 'self' https://www.sandbox.paypal.com; base-uri {$url_proto}://{$maindw}; report-uri {$url_proto}://{$maindw}/csp_report.php;");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title><?=hsc(@$meta['title'])?></title>
<link rel="icon" href="/img/logo.svg">
<link rel="mask-icon" href="/img/logo.svg" color=”#000000">
<link rel="apple-touch-icon" href="/img/logo.svg">
<meta property="og:title" content="<?=hsc(@$meta['title'])?>" />
<meta name="description" content="<?=hsc(@$meta['description'])?>" />
<meta property="og:description" content="<?=hsc(@$meta['description'])?>" />
<meta property="og:type" content="website" />
<?php if (@$meta['robots']) { ?>
<meta name="ROBOTS" content="<?=strtoupper($meta['robots'])?>" />
<?php } ?>
<?php if (@$meta['og_image']) { ?>
<meta property="og:image" content="<?=$url_proto?>://<?=$maindw?><?=$meta['og_image']?>" />
<?php } ?>
<?php if (@$meta['canonical']) { ?>
<link rel="canonical" href="<?=$url_proto?>://<?=$maindw?><?=$meta['canonical']?>" />
<?php } ?>
<?php if (@$meta['og_url']) { ?>
<meta property="og:url" content="<?=$url_proto?>://<?=$maindw?><?=$meta['og_url']?>" />
<?php } else if (@$meta['canonical']) { ?>
<meta property="og:url" content="<?=$url_proto?>://<?=$maindw?><?=$meta['canonical']?>" />
<?php } ?>
<meta property="fb:app_id" content="<?=$fb_app_id?>" />
<meta name="viewport" content="initial-scale=1,maximum-scale=1,user-scalable=no" />
<?php if (0 && is_file($min_css_fn)) { ?>
<style type="text/css" nonce="<?=$css_nonce?>"><?=file_get_contents($min_css_fn)?></style>
<?php } else { ?>
<link href="css/<?=$mobile_user ? 'style_m' : 'style'?>.css" rel="stylesheet" type="text/css" />
<link href="css/fa.min.css" rel="stylesheet" type="text/css" />
<?php } ?>
<?php foreach ($JS as $v) { ?>
<script type="text/javascript" src="<?=$v?>" async></script>
<?php } ?>
<?php if (0) { ?>
<script async src="js/analytics.js?2017101518"></script>
<?php } ?>
</head>
<body>
	<?php require "layouts/{$layout}.php"; ?>
	<div class="reql reql0" id="reql0"></div>
</body>
</html>
