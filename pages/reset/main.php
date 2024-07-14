<div<?php if (!$mobile_user) { ?> class="half ma"<?php } ?>>
	<h1>Reset password</h1>
	<?php if ($em) { ?>
	<div class="emsgc"><?=hsc($EMSG[$em])?></div>
	<?php } else { ?>
	<?php require 'frag/reset_form.inc.php'; ?>
	<?php } ?>
</div>