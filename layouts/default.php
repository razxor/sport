<header class="<?=$layout?>">
	<?php
		require 'frag/menu1.inc.php';
		require 'frag/menu2.inc.php';
	?>
</header>
<div class="cw ma cc1">
<?php
	if (is_file($f = "pages/{$page}/{$sub}.php"))
		require $f;
?>
</div>
<footer>
	<?php
		require 'frag/f1.inc.php';
		require 'frag/f2.inc.php';
	?>
</footer>