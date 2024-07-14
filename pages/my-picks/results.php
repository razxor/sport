<?php if (!$usr->logged_in()) { ?>
<?php require 'pages/account/frag/nli.inc.php'; ?>
<?php } else { ?>
<?php require 'pages/account/frag/acc_menu2.inc.php'; ?>
<h1><?=$year?> Season results</h1>
<div id="sres">
<?php require 'frag/s_res.inc.php'; ?>
</div>
<?php } ?>