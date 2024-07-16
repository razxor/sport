<?php
	require dirname(__FILE__).'/style.inc.php';
?>
<body style="<?=$style['body']?>">
	<?php require dirname(__FILE__).'/header.inc.php'; ?>
	<div style="<?=$style['box1']?>">
		<span style="<?=$style['normal']?>">
			To reset your password, please click the "Reset" button, or access the link below:<br />
			<br />  
			<a href="<?=$url_proto?>://<?=$maindw?><?=$r['rs_link']?>"><?=$url_proto?>://<?=$maindw?><?=$r['rs_link']?></a><br />
			<br />
			<a href="<?=$url_proto?>://<?=$maindw?><?=$r['rs_link']?>" style="<?=$style['big_btn']?>">Reset</a>
		</span>
	</div>
	<?php require dirname(__FILE__).'/footer.inc.php'; ?>
</body>