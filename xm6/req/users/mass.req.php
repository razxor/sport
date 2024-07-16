<?php
	require '../../inc/global.inc.php';
	require '../../inc/req_auth.inc.php';
	require 'common.inc.php';
?>
<form action="#" method="post" class="modal0">
	<div class="box1">
		<h2><a href="#" class="fr" act="close" reql="reql1"><i class="fa fa-close"></i></a>Mass email</h2>
		<div class="fc">
			<div class="fn">Subject</div>
			<input type="text" class="txt" name="<?=$t='subj'?>" value="<?=hsc(@$r[$t])?>" maxlength="255" />
			<div class="err" assoc="<?=$t?>"></div>
		</div>
		<div class="fc">
			<textarea class="txt big_ta" rows="10" name="<?=$t='msg'?>"></textarea>
			<div class="err" assoc="<?=$t?>"></div>
		</div>
		<div class="msgc" assoc="main"></div>
		<div class="errc" assoc="main"></div>
		<footer>
			<table>
				<tr>
					<td><a href="#" act="close" reql="reql1">Close</a></td>
					<td>
						<button type="submit" class="btn1" name="btn1"><i class="fa fa-send"></i>Send</button>
					</td>
				</tr>
			</table>
		</footer>
	</div>
</form>