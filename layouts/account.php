<header class="<?=$layout?>">
	<?php
		require 'frag/menu1.inc.php';
		require 'frag/menu2.inc.php';
	?>
</header>
<div class="cw ma cc1">
	<?php if (!$usr->logged_in()) { ?>
	<?php require 'pages/account/frag/nli.inc.php'; ?>
	<?php } else { ?>
	<div class="spl">
		<div class="quat3">
			<?php
				if (is_file($f = "pages/{$page}/{$sub}.php"))
					require $f;
			?>
		</div>
		<div class="quat padl">
			<?php
				if (is_file($f = "pages/{$page}/{$sub}_sb.php"))
					require $f;
				else if (is_file($f = "pages/{$page}/main_sb.php"))
					require $f;
				else
					require 'pages/account/main_sb.php';
			?>
		</div>
	</div>
	<?php } ?>
</div>
<footer>
	<?php
		require 'frag/f1.inc.php';
		require 'frag/f2.inc.php';
	?>
</footer>