<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Log in</title>
<link rel="stylesheet" type="text/css" href="css/login.css" />
<link rel="stylesheet" type="text/css" href="css/fa.min.css" />
<script type="text/javascript" src="js/login.js" async></script>
<meta name="ROBOTS" content="NOINDEX,NOFOLLOW" />
</head>
<body>
	<form action="#" method="post" id="dfrm">
		<div class="logoc"><a class="logo" href="http://bc.eweb.ws/" target="_blank"></a></div>
		<input type="hidden" name="bt" value="<?=htmlspecialchars(@$_GET['bt'], ENT_QUOTES, 'utf-8')?>" />
		<div class="fc">
			<input type="text" class="txt" name="<?=$t='user'?>" placeholder="Username" value="" />
			<div class="err" id="e_<?=$t?>"></div>
		</div>
		<div class="fc">
			<input type="password" class="txt" name="<?=$t='pass'?>" placeholder="Password" value="" />
			<div class="err" id="e_<?=$t?>"></div>
		</div>
		<div class="fc">
			<table>
				<tr>
					<td><input type="checkbox" name="<?=$t='keep'?>" id="id_<?=$t?>" /></td>
					<td><label for="id_<?=$t?>">Keep me logged in</label></td>
					<td><button type="submit" class="btn1 fr">Log in</button></td>
				</tr>
			</table>
		</div>
	</form>
</body>
</html>
