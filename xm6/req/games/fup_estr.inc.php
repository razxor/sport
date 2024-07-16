<div class="modal0">
	<div class="box1">
		<h2><a href="#" class="fr" act="close" reql="reql1"><i class="fa fa-close"></i></a>Processing errors</h2>
		<table class="data1">
			<tr>
				<th class="lt">File</th>
				<th class="rt">Line</th>
				<th class="lt">Error</th>
			</tr>
			<?php foreach ($ea2 as $k=>$v) { ?>
			<?php foreach ($v as $vv) { ?>
			<tr>
				<td><?=hsc($_FILES['f']['name'][$k])?></td>
				<td class="rt"><?=$vv[0]?></td>
				<td><?=hsc($vv[1])?></td>
			</tr>
			<?php } ?>
			<?php } ?>
		</table>
	</div>
</div>