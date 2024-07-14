<?php
	require 'inc/global.inc.php';

	if (!$usr->logged_in() || !in_array($usr->p['role_id'], array(1)))
	{
		header("Location: login.php?bt=".urlencode($_SERVER['REQUEST_URI']));
		die();
	}

	require 'inc/modules.inc.php';

	$x = $modules;
	$a = array_shift($x);
	$page = in_array(@$_GET['page'], db::choose($modules, 0)) ? $_GET['page'] : $a[0];
	foreach ($modules as $k=>$v)
	{
		if ($v[0] == $page)
		{
			$mod_key = $k;
			break;
		}
	}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Admin - <?=hsc($modules[$mod_key][1])?></title>
<link rel="stylesheet" type="text/css" href="css/style.css" />
<link rel="stylesheet" type="text/css" href="css/fa.min.css" />
<script type="text/javascript" src="js/app.js?2018032916"></script>
<script type="text/javascript" src="js/<?=$modules[$mod_key][0]?>.js?2018032916"></script>
</head>
<body>
	<header>
		<table>
			<tr>
				<td><a class="logo" href="index.php">BCW</a></td>
				<td>
					<div class="fr">
						<a href="index.php?page=account" act="toggle" tid="asm">Welcome, <b><?=hsc($usr->p['user'])?></b><i class="fa fa-angle-down"></i></a>
						<nav class="accmenu" id="asm">
							<ul>
								<li><a href="index.php?page=account"><i class="fa fa-user"></i>Edit account</a></li>
								<li><a href="logout.php"><i class="fa fa-sign-out"></i>Logout</a></li>
							</ul>
						</nav>
					</div>
				</td>
			</tr>
		</table>
	</header>
	<aside>
		<nav>
			<ul>
				<?php foreach ($modules as $v) if ($v[2]) { ?>
				<li<?php if ($v[0] == $page) { ?> class="active"<?php } ?>><a href="index.php?page=<?=$v[0]?>"><i class="<?=hsc($v[3])?>"></i><?=hsc($v[1])?></a></li>
				<?php } ?>
			</ul>
		</nav>
	</aside>
	<article>
		<div class="cont1">
			<?php
				if (is_file($f = "pages/{$page}/main.php"))
					require $f;
			?>
		</div>
	</article>
	<div id="ui_el"></div>
	<div id="modal"></div>
</body>
</html>
