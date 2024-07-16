<?php
	require '../../inc/global.inc.php';
	require '../../inc/req_auth.inc.php';
	require 'common.inc.php';
?>
<form action="#" method="post" class="modal0">
	<div class="box1">
		<h2><a href="#" class="fr" act="close" reql="reql1"><i class="fa fa-close"></i></a>Paste picks</h2>
		<div class="msgc" assoc="main"></div>
		<div class="errc" assoc="main"></div>
		<div class="fc">
			<textarea class="txt" rows="10" name="<?=$t='txt'?>"></textarea>
			<div class="err" assoc="<?=$t?>"></div>
		</div>
		<footer>
			<table>
				<tr>
					<td><a href="#" act="close" reql="reql1">Close</a></td>
					<td>
						<button type="submit" class="btn1" name="btn1"><i class="fa fa-bolt"></i>Process</button>
					</td>
				</tr>
			</table>
		</footer>
	</div>
</form>