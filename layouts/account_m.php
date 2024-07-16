<header class="<?=$layout?>">
	<?php
		require 'frag/menu_m.inc.php';
	?>
</header>
<?php if (!$usr->logged_in()) { ?>
<?php require 'pages/account/frag/nli.inc.php'; ?>
<?php } else { ?>
<?php
	if (is_file($f = "pages/{$page}/{$sub}_sb.php"))
		require $f;
	else if (is_file($f = "pages/{$page}/main_sb.php"))
		require $f;
	else
		require 'pages/account/main_sb.php';
?>
<div class="cc1 <?=$layout?>">
	<?php
		if (is_file($f = "pages/{$page}/{$sub}.php"))
			require $f;
	?>
</div>
<?php } ?>
<footer>
	<?php
		require 'frag/f2_m.inc.php';
	?>
</footer>