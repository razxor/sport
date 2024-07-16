<header class="<?=$layout?>">
	<?php
		require 'frag/menu_m.inc.php';
	?>
</header>
<div class="cc1 <?=$layout?>">
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