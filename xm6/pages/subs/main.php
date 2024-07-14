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
				<td><h1>Subscribers</h1></td>
				<td>
					<form class="filters" id="filters">
						<select name="<?=$t='year'?>">
							<option value="" class="def">Season</option>
							<?php foreach ($seasons as $p) { ?>
							<option value="<?=$p[$t]?>"<?php if ($p[$t] == $ss[$t]) { ?> selected="selected"<?php } ?>><?=$p[$t]?></option>
							<?php } ?>
						</select>
						<select name="<?=$t='week'?>">
							<option value="" class="def">Week</option>
							<?php for ($i = 1; $i <= 22; $i++) { ?>
							<option value="<?=$i?>"<?php if ($i == $week) { ?> selected="selected"<?php } ?>><?=$i?></option>
							<?php } ?>
						</select>
						<input type="text" name="q" class="txt" placeholder="Search subscribers" />
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
