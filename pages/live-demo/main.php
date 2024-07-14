<div class="spl">
	<div class="quat3"><h1>Week <span id="week"><?=bc::wk_name($sel_week)?></span> game selections</h1></div>
	<div class="quat rta">
		<select id="wk_sel">
			<?php for ($i = 4; $i <= $last_week; $i++) if ($i != 21) { ?>
			<option value="<?=$i?>"<?php if ($i == $sel_week) { ?> selected="selected"<?php } ?>>Week <?=bc::wk_name($i)?></option>
			<?php }?>
		</select>
	</div>
</div>
<div id="games">
	<?php require 'pages/season-results/frag/gl1.inc.php'; ?>
</div>