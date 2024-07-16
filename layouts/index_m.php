<header class="<?=$layout?>">
	<?php
		require 'frag/menu_m.inc.php';
		require 'frag/upcoming.inc.php';
	?>
</header>
<?php require 'frag/slider_m.inc.php'; ?>
<div class="cc1">
<?php
	if (is_file($f = "pages/{$page}/{$sub}.php"))
		require $f;
?>
</div>
<footer>
	<?php
		require 'frag/f2_m.inc.php';
	?>
</footer>