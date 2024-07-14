<?php
	require '../../inc/global.inc.php';
	require '../../inc/req_auth.inc.php';
	require 'common.inc.php';

	$fn = @$_POST['fn'];
	$of = realpath(dirname(__FILE__).'/../../../tmpl/'.basename($fn));
	if (!is_file($of))
		die("File {$of} not found");
	$cont = file_get_contents($of);
?>
<form action="#" method="post" class="modal0">
	<input type="hidden" name="fn" value="<?=$fn?>" />
	<div class="box1">
		<h2><a href="#" class="fr" act="close" reql="reql1"><i class="fa fa-close"></i></a>Edit email template</h2>
		<div class="msgc" id="m_main"></div>
		<div class="fc">
			<div class="fn">File name</div>
			<?=hsc($fn)?>
		</div>
		<div class="fc">
			<div class="fn">Content</div>
			<textarea name="<?=$t='cont'?>" class="big_ta"><?=hsc($cont)?></textarea>
		</div>
		<footer>
			<table>
				<tr>
					<td><a href="#" act="close" reql="reql1">Close</a></td>
					<td>
						<?php if (0) { ?>
						<a class="btn1 alt2" act="del" eid="<?=$r[$pk]?>"><i class="fa fa-trash"></i>Delete</a>
						<?php } ?>
						<button type="submit" class="btn1" name="btn1"><i class="fa fa-save"></i>Save</button>
					</td>
				</tr>
			</table>
		</footer>
	</div>
</form>