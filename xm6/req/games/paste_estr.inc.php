<div class="modal0">
	<div class="box1">
		<h2><a href="#" class="fr" act="close" reql="reql2"><i class="fa fa-close"></i></a>Processing errors</h2>
		<table class="data1">
			<tr>
				<th class="rt">Line</th>
				<th class="lt">Error</th>
			</tr>
			<?php foreach ($ea2 as $k=>$vv) { ?>
			<tr>
				<td class="rt"><?=$vv[0]?></td>
				<td><?=hsc($vv[1])?></td>
			</tr>
			<?php } ?>
		</table>
	</div>
</div>