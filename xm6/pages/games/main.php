<?php
	require '../classes/class.bc.php';
	$ss = bc::get_season('N');
	$seasons = $db->query("SELECT * FROM seasons ORDER BY year DESC");
	$week = bc::get_week($ss['year'], 'G');
?>
<div>
	<div class="box2">
		<table>
			<tr>
				<td><h1>Games</h1></td>
				<td>
					<a class="btn1" href="#" act="upload" id="b_upload"><i class="fa fa-cloud-upload"></i>Upload picks</a>
					<a class="btn1" href="#" act="paste"><i class="fa fa-file-text-o"></i>Paste picks</a>
					<form class="filters" id="filters">
						<select name="<?=$t='year'?>">
							<option value="" class="def">Season</option>
							<?php foreach ($seasons as $p) { ?>
							<option value="<?=$p[$t]?>"<?php if ($p[$t] == $ss[$t]) { ?> selected="selected"<?php } ?>><?=$p[$t]?></option>
							<?php } ?>
						</select>
						<select name="<?=$t='week'?>">
							<option value="" class="def">Week</option>
							<?php for ($i = 1; $i <= 22; $i++) if ($i != 21) { ?>
							<option value="<?=$i?>"<?php if ($i == $week) { ?> selected="selected"<?php } ?>><?=bc::wk_name($i)?></option>
							<?php } ?>
						</select>
						<input type="text" name="q" class="txt" placeholder="Search games" />
						<button><i class="fa fa-search"></i></button>
					</form>
				</td>
			</tr>
		</table>
	</div>
	<div id="reql0"></div>
</div>
<div id="reql1"></div>
<div id="reql2"></div>
<input type="file" name="f" multiple="multiple" class="hide" id="fup" accept=".txt,.csv" />
