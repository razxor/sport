<?php
	require '../../inc/global.inc.php';
	require '../../inc/req_auth.inc.php';
	require 'common.inc.php';

	$id = (int)@$_POST['id'];
	$r = db::first($db->query("SELECT * FROM `%s` WHERE `%s` = %u", $tbl, $pk, $id));
	if (!$r)
		die('Item not found');
?>
<div class="modal0">
	<div class="box1" style="max-height:80vh;overflow:auto;">
		<h2><a href="#" onclick="$('reql1').innerHTML='';return false;" class="fr"><i class="fa fa-close"></i></a>View message</h2>
		<div class="fc">
			<table class="w100">
				<tr>
					<td class="third pr">
						<div class="fn">Name</div>
						<?=hsc($r['name'])?>
					</td>
					<td class="third pr">
						<div class="fn">Email</div>
						<?=hsc($r['email'])?>
					</td>
					<td>
						<div class="fn">Phone</div>
						<?=hsc($r['phone'])?>
					</td>
				</tr>
			</table>
		</div>
		<div class="fc">
			<div class="fn">Subject</div>
			<?=hsc($r['subject'])?>
		</div>
		<div class="fc" style="max-width:500px;">
			<div class="fn">Message</div>
			<?=hsc($r['message'])?>
		</div>
	</div>
</div>